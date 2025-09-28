pipeline {
    agent any

    stages {

        stage('Copy .env') {
            steps {
                sh 'cp .env.example .env || true'
            }
        }

        stage('Install Composer Dependencies') {
            steps {
                sh 'composer install'
            }
        }

        stage('App Setup') {
            steps {
                sh '''
                php artisan key:generate
                php artisan migrate:fresh --seed
                '''
            }
        }

        stage('NPM Build') {
            steps {
                sh '''
                npm install
                npm audit fix || true
                npm run build
                '''
            }
        }
    }

    post {
        always {
            echo 'Build finished.'
        }
    }
}
