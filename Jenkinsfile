pipeline {
    agent any

    environment {
        APP_IMAGE = 'prims-app:latest'
        DB_CONNECTION = 'mysql'
        DB_HOST = 'mysql'
        DB_PORT = '3306'
        DB_DATABASE = 'laravel'
        DB_USERNAME = 'sail'
        DB_PASSWORD = 'password'
    }

    stages {
        stage('Build Docker Image') {
            steps {
                sh 'docker build -t $APP_IMAGE .'
            }
        }

        stage('Prepare Environment') {
            steps {
                sh '''
                cp .env.testing .env
                chmod -R 777 storage bootstrap/cache .env
                '''
            }
        }

        stage('Generate App Key & Run Migrations') {
            steps {
                sh '''
                docker run --rm \
                    -v $PWD:/var/www/html \
                    -e DB_CONNECTION=$DB_CONNECTION \
                    -e DB_HOST=$DB_HOST \
                    -e DB_PORT=$DB_PORT \
                    -e DB_DATABASE=$DB_DATABASE \
                    -e DB_USERNAME=$DB_USERNAME \
                    -e DB_PASSWORD=$DB_PASSWORD \
                    $APP_IMAGE \
                    bash -c "php artisan key:generate && php artisan migrate:fresh --seed"
                '''
            }
        }

        stage('Install Frontend & Build Assets') {
            steps {
                sh '''
                docker run --rm \
                    -v $PWD:/var/www/html \
                    $APP_IMAGE \
                    bash -c "npm install && npm audit fix || true && npm run build"
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
