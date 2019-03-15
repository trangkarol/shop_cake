node {
    currentBuild.result = "SUCCESS"
    try {
        stage('Checkout'){
            checkout scm
        }

        stage("Build Docker"){
            //build docker & mount source to /var/www/html
            sh 'DOCKER_HOST=127.0.0.1'
            //build docker & mount source to /var/www/html
            sh 'bash $WORKSPACE/docker/docker-compose.sh'
            sh 'docker-compose down'
            sh 'docker-compose up -d'
            docker.image('shopcake_web').inside {
                sh $USER
                sh 'composer install'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
                sh 'chmod -R 777 storage/ boostrap/cache'
            }
            //push image to private dockerhub
            //....
        }
    }
    catch (err) {
        currentBuild.result = "FAILURE"
            mail body: "project build error is here: ${env.BUILD_URL}" ,
            from: 'info@vnsys.wordpress.com',
            replyTo: 'info@vnsys.wordpress.com',
            subject: 'project build failed',
            to: 'keepwalking86@vnsys.wordpress.com'
        throw err
    }
}
