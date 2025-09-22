pipeline {
    agent { dockerfile true }

    stages {
        stage('Install Sail') {
            steps {
                sh 'composer require laravel/sail --dev'
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('Setup') {
            steps {
                sh '''
                ./vendor/bin/sail artisan key:generate
                ./vendor/bin/sail artisan migrate:fresh --seed
                '''
            }
        }

        stage('Build Frontend') {
            steps {
                sh '''
                ./vendor/bin/sail npm install
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
    