pipeline {
    agent any

    stages {

        stage('Debug: Show Directory Structure') {
            steps {
                sh '''
                echo "Current working directory:"
                pwd

                echo "Listing contents of workspace root:"
                ls -al

                echo "Looking for composer.json files:"
                find . -name "composer.json" || true
                '''
            }
        }

        stage('Copy .env') {
            steps {
                sh 'cp .env.example .env || true'
            }
        }

        stage('Install Composer via Docker') {
            steps {
                sh '''
                docker run --rm \
                    -v $PWD:/app \
                    -w /app \
                    laravelsail/php82-composer:latest \
                    composer install --ignore-platform-reqs
                '''
            }
        }

        stage('Debug: Show Directory Structure') {
            steps {
                sh '''
                echo "Current working directory:"
                pwd

                echo "Listing contents of workspace root:"
                ls -al

                echo "Looking for composer.json files:"
                find . -name "composer.json" || true
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
