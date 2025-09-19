pipeline {
    agent any

    environment {
        COMPOSER_IMAGE = 'laravelsail/php82-composer:latest'
    }

    stages {

        stage('Install Sail') {
            steps {
                sh """
                docker run --rm -u \$(id -u):\$(id -g) -v \$(pwd):/var/www/html -w /var/www/html $COMPOSER_IMAGE composer require laravel/sail --dev
                docker run --rm -u \$(id -u):\$(id -g) -v \$(pwd):/var/www/html -w /var/www/html $COMPOSER_IMAGE php artisan sail:install
                """
            }
        }

        stage('Setup Environment & Permissions') {
            steps {
                sh """
                cp .env.example .env
                chmod -R 777 storage bootstrap/cache .env || true
                git config --global --add safe.directory \$(pwd)
                """
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('Fix Sail Ownership') {
            steps {
                // Make sure Sail user can write to mounted files
                sh './vendor/bin/sail root-shell -c "chown -R sail:sail /var/www/html"'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh './vendor/bin/sail composer install'
            }
        }

        stage('Generate App Key') {
            steps {
                sh './vendor/bin/sail artisan key:generate'
            }
        }

        stage('Migrate & Seed Database') {
            steps {
                sh './vendor/bin/sail artisan migrate:fresh --seed'
            }
        }

        stage('Build Frontend') {
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