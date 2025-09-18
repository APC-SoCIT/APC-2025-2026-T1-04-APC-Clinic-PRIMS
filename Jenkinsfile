pipeline {
    agent any

    environment {
        COMPOSER_IMAGE = 'laravelsail/php82-composer:latest'
    }

    options {
        // Clean workspace at the start to avoid leftover permission issues
        skipDefaultCheckout(false)
        buildDiscarder(logRotator(numToKeepStr: '10'))
        cleanWs()
    }

    stages {

        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Install Sail') {
            steps {
                sh """
                docker run --rm -u \$(id -u):\$(id -g) -v \$(pwd):/var/www/html -w /var/www/html $COMPOSER_IMAGE composer require laravel/sail --dev
                docker run --rm -u \$(id -u):\$(id -g) -v \$(pwd):/var/www/html -w /var/www/html $COMPOSER_IMAGE php artisan sail:install
                """
            }
        }

        stage('Setup Environment & Permissions') {
            steps {
                sh """
                cp .env.example .env
                chmod -R 777 storage bootstrap/cache .env || true
                git config --global --add safe.directory \$(pwd)
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

        stage('Commit & Push Changes') {
            steps {
                script {
                    // Make sure Jenkins user owns the workspace
                    sh "sudo chown -R \$(whoami):\$(whoami) \$(pwd) || true"

                    sh '''
                    git config --global user.email "jmmiyabe@student.apc.edu.ph"
                    git config --global user.name "jmmiyabe"

                    # Stage any changes
                    git add .

                    # Commit changes, ignore if nothing to commit
                    git commit -m "Automated update from Jenkins pipeline" || true

                    # Push changes safely
                    git push origin HEAD || true
                    '''
                }
            }
        }
    }

    post {
        always {
            // Tear down Sail safely
            sh './vendor/bin/sail down || true'
        }
    }
}
