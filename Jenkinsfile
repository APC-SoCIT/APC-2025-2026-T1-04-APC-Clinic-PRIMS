pipeline {
    agent any

    environment {
        SAIL = './vendor/bin/sail'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/yourusername/PRIMS.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh "${env.SAIL} composer install --no-interaction --prefer-dist --optimize-autoloader"
            }
        }

        stage('Build Containers') {
            steps {
                sh "${env.SAIL} up -d"
            }
        }

        stage('Run Migrations & Seeders') {
            steps {
                sh "${env.SAIL} artisan migrate:fresh --seed"
            }
        }
    }

    post {
        always {
            echo 'Cleaning up containers'
            sh "${env.SAIL} down"
        }
        success {
            echo 'Build and tests successful!'
        }
        failure {
            echo 'Build failed! Check logs.'
        }
    }
}
