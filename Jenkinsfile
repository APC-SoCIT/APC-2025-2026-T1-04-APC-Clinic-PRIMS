pipeline {
    agent any

    environment {
        COMPOSER_IMAGE = 'laravelsail/php82-composer:latest'
    }

    stages {

        stage('Install Sail') {
            steps {
                sh '''
                docker run --rm \
                -u $(id -u):$(id -g) \
                -v /var/lib/jenkins/workspace/PRIMS:/var/www/html \
                -v /var/lib/jenkins/composer-cache:/tmp/composer-cache \
                -w /var/www/html \
                laravelsail/php82-composer:latest \
                composer install --prefer-dist --no-interaction --optimize-autoloader \
                --no-cache-dir
                '''
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
                sh './vendor/bin/sail artisan test --parallel'
            }
        }

    }

    post {
        always {
            sh './vendor/bin/sail down || true'
        }
    }
}
