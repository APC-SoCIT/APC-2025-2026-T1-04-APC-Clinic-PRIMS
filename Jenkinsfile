pipeline {
    agent any

    environment {
        COMPOSER_IMAGE = 'laravelsail/php82-composer:latest'
    }

    stages {

        stage('Setup Environment & Permissions') {
            steps {
                sh """
                if [ ! -f .env ]; then
                  cp .env.example .env
                fi
                chmod -R 777 storage bootstrap/cache .env || true
                git config --global --add safe.directory \$(pwd)
                """
            }
        }

        stage('Install Sail') {
            steps {
                sh """
                # ✅ Run Composer with Jenkins UID:GID to avoid permission issues
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

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('Fix Sail Ownership') {
            steps {
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
