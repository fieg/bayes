pipeline {
  agent docker
  stages {
    stage('test') {
      steps {
        sh 'php vendor/bin/phpunit'
      }
    }
  }
}