node {
    currentBuild.result = "SUCCESS"
    try {
        sh 'rsync -avzhP --delete --exclude=.git/ --exclude=Jenkinsifle $WORKSPACE/ www@10.0.1.234:/root/docker/'

        sh 'ssh www@10.0.1.234 "cd /root/docker/ && bash docker-compose.sh"'
        //push image to private dockerhub
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
