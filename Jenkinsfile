pipeline {
    agent {
        dockerfile {
            filename 'Dockerfile'   // adjust if not at repo root
            dir '.'                 // build context
        }
    }

    stages {
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

        stage('Run Tests') {
            steps {
                sh 'php artisan test'
            }
        }
    }
}
