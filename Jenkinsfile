pipeline {
    agent any

    environment {
        WORKDIR = "${env.WORKSPACE}"
    }

    stages {
        stage('Debug Workspace') {
            steps {
                sh 'ls -la'
            }
        }

        stage('Copy .env') {
            steps {
                sh 'cp .env.example .env || true'
            }
        }

        stage('Check composer.json') {
            steps {
                sh '''
                if [ ! -f composer.json ]; then
                  echo "composer.json not found!"
                  exit 1
                fi
                '''
            }
        }

        stage('Install Composer Dependencies') {
            steps {
                sh 'docker run --rm -v ${WORKDIR}:/app -w /app composer:latest install'
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d || true'
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
