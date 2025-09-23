pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'docker-compose.yml'
        WWWUSER = '1000'
        WWWGROUP = '1000'
    }

    stages {
        stage('Install Sail') {
            steps {
                sh '''
                    docker run --rm -u "$(id -u):$(id -g)" \
                        -v $PWD:/var/www/html \
                        -w /var/www/html \
                        laravelsail/php82-composer:latest \
                        composer require laravel/sail --dev --no-interaction
                '''
            }
        }

        stage('Install Dependencies') {
            steps {
                sh './vendor/bin/sail composer install --no-interaction --prefer-dist --optimize-autoloader'
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('Prepare Env') {
            steps {
                sh '''
                    cp .env.testing .env || cp .env.example .env
                    chmod -R 777 storage bootstrap/cache .env
                '''
            }
        }

        stage('Setup App') {
            steps {
                sh '''
                    ./vendor/bin/sail artisan key:generate
                    ./vendor/bin/sail artisan migrate:fresh --seed --env=testing
                    ./vendor/bin/sail npm install
                    ./vendor/bin/sail npm run build
                '''
            }
        }

        stage('Test') {
            steps {
                sh './vendor/bin/sail artisan test'
            }
        }
    }

    post {
        always {
            sh './vendor/bin/sail down || true'
        }
    }
}
