pipeline {
    agent { dockerfile true }

    stages {
        stage('Setup Environment & Permissions') {
            steps {
                sh '''
                if [ ! -f .env ]; then
                  cp .env.example .env
                fi
                chmod -R 777 storage bootstrap/cache .env || true
                git config --global --add safe.directory $(pwd)
                '''
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
            }
        }

        stage('Generate App Key') {
            steps {
                sh 'php artisan key:generate'
            }
        }

        stage('Migrate & Seed Database') {
            steps {
                sh 'php artisan migrate:fresh --seed'
            }
        }

        stage('Build Frontend') {
            steps {
                sh '''
                npm install
                npm audit fix || true
                npm run build
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh 'php artisan test'
            }
        }
    }
}
