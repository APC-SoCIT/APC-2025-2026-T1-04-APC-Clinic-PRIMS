pipeline {
    agent any

    stages {

        stage('Copy .env') {
            steps {
                sh 'cp .env.example .env || true'
            }
        }

        stage('Install Composer & Sail') {
            steps {
                sh '''
                composer install
                composer require laravel/sail --dev
                php artisan sail:install --no-interaction
                '''
            }
        }

        stage('Start Sail Containers') {
            steps {
                sh '''
                bash vendor/bin/sail up -d
                '''
            }
        }

        stage('App Setup') {
            steps {
                sh '''
                bash vendor/bin/sail artisan key:generate
                bash vendor/bin/sail artisan migrate:fresh --seed
                '''
            }
        }

        stage('NPM Install & Build') {
            steps {
                sh '''
                bash vendor/bin/sail npm install
                bash vendor/bin/sail npm audit fix || true
                bash vendor/bin/sail npm run build
                '''
            }
        }
    }

    post {
        always {
            sh 'bash vendor/bin/sail down || true'
        }
    }
}
