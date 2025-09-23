pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'docker-compose.yml'
        WWWUSER = '1000'
        WWWGROUP = '1000'
    }

    stages {
        stage('Prepare Sail') {
            steps {
                sh """
                docker run --rm -u $UID:$GID \
                    -v \$(pwd):/var/www/html \
                    -w /var/www/html \
                    laravelsail/php82-composer:latest composer require laravel/sail --dev

                cp .env.example .env

                docker run --rm -u $UID:$GID \
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
