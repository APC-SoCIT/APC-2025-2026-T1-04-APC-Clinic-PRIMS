pipeline {
    agent any

    stages {

        stage('Prepare Sail') {
            steps {
                sh """
                # Install dependencies (gets artisan + vendor)
                docker run --rm -u "$(id -u):$(id -g)" \
                    -v $(pwd):/var/www/html \
                    -w /var/www/html \
                    laravelsail/php82-composer:latest composer require laravel/sail --dev

                # Copy .env
                cp .env.example .env

                # Require sail (safe if already there)
                docker run --rm -u "$(id -u):$(id -g)" \
                    -v $(pwd):/var/www/html \
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
