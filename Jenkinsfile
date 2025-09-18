pipeline {
    agent any

    environment {
        COMPOSER_IMAGE = 'laravelsail/php82-composer:latest'
        GIT_CREDENTIALS = 'prims-cicd' // your Jenkins GitHub credential ID
        GIT_EMAIL = 'jmmiyabe@student.apc.edu.ph'
        GIT_NAME = 'jmmiyabe'
    }

    options {
        skipDefaultCheckout(true) // We'll do a custom checkout
        timestamps()
    }

    stages {

        stage('Clean Workspace') {
            steps {
                deleteDir() // Ensures old .git/config.lock issues are gone
            }
        }

        stage('Checkout Code') {
            steps {
                checkout([$class: 'GitSCM',
                    branches: [[name: '*/main']],
                    doGenerateSubmoduleConfigurations: false,
                    extensions: [[$class: 'CleanBeforeCheckout']],
                    userRemoteConfigs: [[
                        url: 'https://github.com/APC-SoCIT/APC-2025-2026-T1-04-APC-Clinic-PRIMS.git',
                        credentialsId: env.GIT_CREDENTIALS
                    ]]
                ])
            }
        }

        stage('Setup Environment & Permissions') {
            steps {
                sh '''
                cp .env.example .env || true
                chmod -R 777 storage bootstrap/cache .env
                git config --global user.email "${GIT_EMAIL}"
                git config --global user.name "${GIT_NAME}"
                '''
            }
        }

        stage('Install Sail & Dependencies') {
            steps {
                sh '''
                docker run --rm -u $(id -u):$(id -g) -v $(pwd):/var/www/html -w /var/www/html $COMPOSER_IMAGE composer require laravel/sail --dev
                docker run --rm -u $(id -u):$(id -g) -v $(pwd):/var/www/html -w /var/www/html $COMPOSER_IMAGE php artisan sail:install
                ./vendor/bin/sail composer install
                '''
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

        stage('App Setup') {
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
                ./vendor/bin/sail npm audit fix || true
                ./vendor/bin/sail npm run build
                '''
            }
        }

        stage('Commit & Push Changes') {
            steps {
                sh '''
                git add .
                git commit -m "Automated update from Jenkins pipeline" || true
                git push origin HEAD
                '''
            }
        }
    }

    post {
        always {
            sh './vendor/bin/sail down || true' // stops containers after the build
        }
    }
}
