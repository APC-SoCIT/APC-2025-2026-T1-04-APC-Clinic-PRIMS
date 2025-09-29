pipeline {
    agent any

    stages {

        stage('Debug: Show Directory Structure') {
            steps {
                sh '''
                echo "Current working directory:"
                pwd

                echo "Listing contents of workspace root:"
                ls -al

                echo "Looking for composer.json files:"
                find . -name "composer.json" || true
                '''
            }
        }

        stage('Copy .env') {
            steps {
                sh 'cp .env.example .env || true'
            }
        }

        stage('Install Composer via Docker') {
            steps {
                sh '''
                docker run --rm \
                    -v $PWD:/app \
                    -w /app \
                    laravelsail/php82-composer:latest \
                    sh -c "
                        rm -f composer.lock &&
                        composer install --no-interaction --prefer-dist
                    "
                '''
            }
        }


        stage('Another Debug: Show Directory Structure') {
            steps {
                sh '''
                echo "Current working directory:"
                pwd

                echo "Listing contents of workspace root:"
                ls -al

                echo "Looking for composer.json files:"
                find . -name "composer.json" || true
                '''
            }
        }


        stage('Start Sail Containers') {
            steps {
                sh '''
                ./vendor/bin/sail up -d
                '''
            }
        }

        stage('App Setup') {
            steps {
                sh '''
                ./vendor/bin/sail artisan key:generate
                ./vendor/bin/sail artisan migrate:fresh --seed
                '''
            }
        }

        stage('NPM Install & Build') {
            steps {
                sh '''
                ./vendor/bin/sail npm install
                ./vendor/bin/sail npm audit fix || true
                ./vendor/bin/sail npm run build
                '''
            }
        }
    }

    post {
        always {
            sh './vendor/bin/sail down || true'
        }
    }
}
