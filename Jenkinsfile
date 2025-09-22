pipeline {
    agent {
        dockerfile {
            filename 'Dockerfile'
            dir '.'
        }
    }

    stages {
        stage('Build') {
            steps {
                sh 'docker --version'
                sh './vendor/bin/sail build'
            }
        }
    }
}
