pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'docker-compose.yml'
    }

    stages {
        stage('Detect UID/GID') {
            steps {
                script {
                    env.UID = sh(script: "id -u", returnStdout: true).trim()
                    env.GID = sh(script: "id -g", returnStdout: true).trim()
                    echo "Using UID=${env.UID} and GID=${env.GID}"
                }
            }
        }

        stage('Prepare Sail') {
            steps {
                sh """
                docker run --rm -u ${env.UID}:${env.GID} \
                    -v \$(pwd):/var/www/html \
                    -w /var/www/html \
                    laravelsail/php82-composer:latest composer require laravel/sail --dev

                cp .env.example .env

                docker run --rm -u ${env.UID}:${env.GID} \
                    -v \$(pwd):/var/www/html \
                    -w /var/www/html \
                    laravelsail/php82-composer:latest php artisan sail:install
                """
            }
        }

        stage('Start Sail') {
            steps {
                sh "./vendor/bin/sail up -d"
            }
        }

        stage('Composer & Artisan') {
            steps {
                sh """
                ./vendor/bin/sail composer install
                ./vendor/bin/sail artisan key:generate
                ./vendor/bin/sail artisan migrate:fresh --seed
                """
            }
        }

        stage('Node Build') {
            steps {
                sh """
                ./vendor/bin/sail npm install
                ./vendor/bin/sail npm audit fix || true
                ./vendor/bin/sail npm run build
                """
            }
        }

        stage('Run Tests') {
            steps {
                sh "./vendor/bin/sail artisan test"
            }
        }
    }

    post {
        always {
            sh "./vendor/bin/sail down || true"
        }
    }
}
