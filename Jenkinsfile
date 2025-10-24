pipeline {
    agent { label 'wonderpets' }
    environment {
        ENV_FILE = credentials('wonderprims')
    }
    
    stage('Load Env') {
    steps {
        withCredentials([file(credentialsId: 'wonderprims', variable: 'ENV_FILE')]) {
            sh(script: '''
                #!/bin/bash
                set -a
                while IFS='=' read -r key value; do
                    if [[ "$key" =~ ^[A-Za-z_][A-Za-z0-9_]*$ ]]; then
                        export "$key=$value"
                    fi
                done < "$ENV_FILE"
                set +a
            ''', shell: '/bin/bash')
        }
    }
    
        stage('Install Composer Dependencies') {
            steps {
                sh '''
                docker run --rm -v $PWD:/app -w /app composer install
                git config --global --add safe.directory /app
                '''
            }
        }

        stage('Start Sail') {
            steps {
                sh './vendor/bin/sail up -d'
            }
        }

        stage('App Setup') {
            steps {
                sh '''
                    ./vendor/bin/sail artisan key:generate
                '''
            }
        }

        stage('npm build') {
            steps {
                sh '''
                    ./vendor/bin/sail npm install
                    ./vendor/bin/sail npm run build
                '''
            }
        }

        stage('Run Tests and migrate') {
            steps {
                sh '''
                    ./vendor/bin/sail test
                    ./vendor/bin/sail artisan migrate:fresh --seed
                '''
            }
        }
    }
}
