pipeline {
    agent any

    environment {
        APP_IMAGE = 'prims-app:latest'
        DB_CONNECTION = 'mysql'
        DB_HOST = '127.0.0.1'  // change if using a DB container
        DB_PORT = '3306'
        DB_DATABASE = 'laravel'
        DB_USERNAME = 'sail'
        DB_PASSWORD = 'password'
    }

    stages {

        stage('Install Dependencies') {
            steps {
                echo "Installing PHP dependencies..."
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
            }
        }

        stage('Build Docker Image') {
            steps {
                echo "Building Docker image..."
                sh 'docker build -t $APP_IMAGE .'
            }
        }

        stage('Prepare Environment') {
            steps {
                echo "Preparing environment and fixing permissions..."
                sh '''
                docker run --rm -u root -v $PWD:/var/www/html $APP_IMAGE bash -c "
                    # Copy .env if it doesn't exist
                    cp -n .env.example .env
                    # Fix permissions
                    chown -R sail:sail storage bootstrap/cache .env || true
                    chmod -R 777 storage bootstrap/cache .env || true
                "
                '''
            }
        }

        stage('Generate Key & Run Migrations') {
            steps {
                echo "Generating APP_KEY and running migrations..."
                sh '''
                docker run --rm -v $PWD:/var/www/html \
                    -e DB_CONNECTION=$DB_CONNECTION \
                    -e DB_HOST=$DB_HOST \
                    -e DB_PORT=$DB_PORT \
                    -e DB_DATABASE=$DB_DATABASE \
                    -e DB_USERNAME=$DB_USERNAME \
                    -e DB_PASSWORD=$DB_PASSWORD \
                    $APP_IMAGE bash -c "
                        php artisan key:generate --ansi
                        php artisan migrate:fresh --seed --force --env=testing
                    "
                '''
            }
        }

        stage('Install Frontend & Build Assets') {
            steps {
                echo "Installing frontend dependencies and building assets..."
                sh '''
                docker run --rm -v $PWD:/var/www/html $APP_IMAGE bash -c "
                    npm install
                    npm audit fix || true
                    npm run build
                "
                '''
            }
        }

        stage('Commit Jenkinsfile') {
            steps {
                echo "Committing Jenkinsfile..."
                sh '''
                git config user.email "jmmiyabe@student.apc.edu.ph"
                git config user.name "jmmiyabe"
                git add Jenkinsfile
                git commit -m "Update Jenkinsfile for Docker pipeline" || true
                git push origin HEAD:main
                '''
            }
        }
    }
}
