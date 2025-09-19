pipeline {
    agent any

    environment {
        COMPOSER_IMAGE = 'laravelsail/php82-composer:latest'
    }

    stages {

        stage('Fix Permissions') {
            steps {
                // Ensure workspace files are writable by Sail's default user (UID 1000)
                sh 'sudo chown -R 1000:1000 /var/lib/jenkins/workspace/PRIMS'
            }
        }

        stage('Install Sail') {
            steps {
                sh """
                docker run --rm \
                -u \$(id -u):\$(id -g) \
                -v \$(pwd):/var/www/html \
                -w /var/www/html \
                $COMPOSER_IMAGE composer require laravel/sail --dev

                docker run --rm \
                -u \$(id -u):\$(id -g) \
                -v \$(pwd):/var/www/html \
                -w /var/www/html \
                $COMPOSER_IMAGE php artisan sail:install
                """
            }
        }

        stage('Setup Environment') {
            steps {
                sh """
                cp .env.example .env
                chmod -R 777 storage bootstrap/cache .env || true
                """
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('Install Dependencies') {
            steps {
                // Add git safe.directory fix for Jenkins user
                sh './vendor/bin/sail git config --global --add safe.directory /var/www/html'
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
                sh './vendor/bin/sail artisan migrate:fresh --seed --env=testing'
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

        stage('Run Tests') {
            steps {
                sh 'rm -f .phpunit.result.cache'
                sh './vendor/bin/sail artisan test --parallel --env=testing'
            }
        }

    }

    post {
        always {
            sh './vendor/bin/sail down -v || true'
        }
    }
}
