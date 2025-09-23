pipeline {
    agent any
    
    environment {
        COMPOSER_ALLOW_SUPERUSER = "1"
        WWWUSER = "1000"
        WWWGROUP = "1000"
    }

    stages {
        stage('Build Sail') {
            steps {
                sh './vendor/bin/sail build --build-arg WWWGROUP=$WWWGROUP --build-arg WWWUSER=$WWWUSER'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh './vendor/bin/sail composer install --no-interaction --prefer-dist --optimize-autoloader'
                sh 'cp .env.example .env || true'
                sh './vendor/bin/sail artisan key:generate'
            }
        }

        stage('Frontend Build') {
            steps {
                sh './vendor/bin/sail npm install'
                sh './vendor/bin/sail npm run build'
            }
        }

        stage('Run Tests') {
            steps {
                sh './vendor/bin/sail artisan test'
            }
        }

        stage('Deploy') {
            when {
                branch 'main'
            }
            steps {
                echo "Deploy step here (e.g. docker push, or SSH into server to run Sail up -d)"
            }
        }
    }

    post {
        always {
            cleanWs()
        }
    }
}
