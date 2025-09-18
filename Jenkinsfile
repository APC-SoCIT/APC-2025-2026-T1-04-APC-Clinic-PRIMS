pipeline {
    agent any

    stages {

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $APP_IMAGE .'
            }
        }

        stage('Prepare Environment') {
            steps {
                sh '''
                cp .env.example .env
                chmod -R 777 storage bootstrap/cache .env
                '''
            }
        }

        stage('Generate Key') {
            steps {
                sh '''
                    if ! grep -q "APP_KEY=" .env || [ -z "$(grep 'APP_KEY=' .env | cut -d '=' -f2)" ]; then
                        key=$(./vendor/bin/sail artisan key:generate --show)
                        sed -i "s|^APP_KEY=.*|APP_KEY=$key|" .env
                    fi
                '''
            }
        }

        stage('Setup App') {
            steps {
                sh '''
                    ./vendor/bin/sail artisan key:generate
                    ./vendor/bin/sail artisan migrate:fresh --seed --env=testing
                    ./vendor/bin/sail root-shell -c "chown -R sail:sail /var/www/html"
                    ./vendor/bin/sail npm install
                    ./vendor/bin/sail npm audit fix || true
                    ./vendor/bin/sail npm run build
                '''
            }
        }

        stage('Commit Jenkinsfile') {
            steps {
                sh '''
                git config user.email "jmmiyabe@student.apc.edu.ph"
                git config user.name "jmmiyabe"
                git add Jenkinsfile
                git commit -m "Update Jenkinsfile for Docker pipeline" || true
                git push origin HEAD:main
                '''
            }
        }
    }
}
