pipeline {
  agent any

  environment {
    COMPOSER_ALLOW_SUPERUSER = "1"
    WWWUSER = "1000"
    WWWGROUP = "1000"
  }

  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Bootstrap Sail (only if missing)') {
      steps {
        script {
          if (!fileExists('vendor/bin/sail')) {
            sh '''
              echo "Sail not found — installing via laravelsail/php82-composer container..."
              docker run --rm -u "$(id -u):$(id -g)" \
                -v "$PWD":/var/www/html -w /var/www/html \
                laravelsail/php82-composer:latest \
                composer require laravel/sail --dev --no-interaction

              docker run --rm -u "$(id -u):$(id -g)" \
                -v "$PWD":/var/www/html -w /var/www/html \
                laravelsail/php82-composer:latest \
                php artisan sail:install --no-interaction
            '''
          } else {
            echo "vendor/bin/sail already present — skipping bootstrap"
          }
        }
      }
    }

    stage('Prepare env & permissions') {
      steps {
        sh 'cp .env.example .env || true'
        sh 'chmod +x vendor/bin/sail || true'
      }
    }

    stage('Build Sail images & start containers') {
      steps {
        sh '''
          ./vendor/bin/sail build --build-arg WWWUSER=${WWWUSER} --build-arg WWWGROUP=${WWWGROUP}
          ./vendor/bin/sail up -d
        '''
      }
    }

    stage('Install deps & build frontend') {
      steps {
        sh '''
          ./vendor/bin/sail composer install --no-interaction --prefer-dist --optimize-autoloader
          ./vendor/bin/sail npm install
          ./vendor/bin/sail npm audit fix || true
          ./vendor/bin/sail npm run build
        '''
      }
    }

    stage('Database migrations') {
      steps {
        sh '''
          retries=0
          until ./vendor/bin/sail artisan migrate:fresh --seed --force || [ $retries -ge 12 ]; do
            echo "Waiting for DB to be ready (attempt $((retries+1)))..."
            retries=$((retries+1))
            sleep 5
          done

          if [ $retries -ge 12 ]; then
            echo "DB never became ready — migrations may have failed"
          fi
        '''
      }
    }

    stage('Run tests') {
      steps {
        sh './vendor/bin/sail artisan test || true'
      }
    }
  }

  post {
    always {
      echo "Tearing down Sail and cleaning workspace..."
      sh './vendor/bin/sail down || true'
      cleanWs()
    }
  }
}
