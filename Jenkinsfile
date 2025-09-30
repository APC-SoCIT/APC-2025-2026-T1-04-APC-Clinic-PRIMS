pipeline {
    agent any

    environment {
        WORKDIR = "${env.WORKSPACE}"
    }

    stages {

        stage('Clean Workspace') {
            steps {
                dir(WORKDIR) {
                    sh 'rm -rf .git || true'
                }
            }
        }

        stage('Copy .env') {
            steps {
                dir(WORKDIR) {
                    sh 'cp .env.example .env || true'
                }
            }
        }

        stage('Fix Laravel Permissions') {
            steps {
                dir(WORKDIR) {
                    sh '''
                    chmod -R 777 storage
                    chmod -R 777 bootstrap/cache
                    chmod 666 .env
                    '''
                }
            }
        }

        stage('Install Composer Dependencies') {
            steps {
                dir(WORKDIR) {
                    sh 'docker run --rm -v $PWD:/app -w /app composer install'
                }
            }
        }

        stage('Start Sail') {
            steps {
                dir(WORKDIR) {
                    sh './vendor/bin/sail up -d'
                }
            }
        }

        stage('App Setup') {
            steps {
                dir(WORKDIR) {
                    sh '''
                    ./vendor/bin/sail artisan key:generate
                    ./vendor/bin/sail artisan migrate:fresh --seed
                    '''
                }
            }
        }

        stage('NPM Build') {
            steps {
                dir(WORKDIR) {
                    sh '''
                    ./vendor/bin/sail npm install
                    ./vendor/bin/sail npm audit fix || true
                    ./vendor/bin/sail npm run build
                    '''
                }
            }
        }
    }

    post {
        always {
            dir(WORKDIR) {
                sh './vendor/bin/sail down || true'
            }
        }
    }
}
