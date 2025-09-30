pipeline {
    agent any

    stages {

        stage('Clean Workspace') {
            steps {
                sh 'rm -rf .git || true'
            }
        }
        
        stage('Copy .env') {
            steps {
                sh 'cp .env.example .env || true'
            }
        }

        stage('Fix Laravel Permissions') {
            steps {
                sh '''
                chmod -R 777 storage
                chmod -R 777 bootstrap/cache
                chmod 666 .env
                '''
            }
        }

        stage('Install Composer Dependencies') {
            steps {
                sh 'docker run --rm -v $PWD:/app -w /app composer install'
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('App Setup') {
            steps {
                sh '''
                ./vendor/bin/sail artisan key:generate
                ./vendor/bin/sail artisan migrate:fresh --seed
                '''
            }
        }

        stage('NPM Build') {
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