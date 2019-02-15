#!/bin/sh

#check command input
if [ "$#" -ne 2 ];
then
    echo "JENKINS LARAVEL PUSH"
    echo "--------------------"
    echo ""
    echo "Usage : ./jenkins-laravel.sh project-name"
    echo ""
    exit 1
fi

# Declare variables
currentdate=`date "+%Y-%m-%d"`
scriptpath="/usr/local/bin/jenkins"
destination_project="$1"
destination_branch=`echo "$2" | awk -F "/" '{printf "%s", $2}'`

# Get configuration variables
source ${scriptpath}/config/laravel/${destination_project}.confss
echo "Pushing to $destination_branch .. "

################
# STAGING PUSH #
################
if [ "$destination_branch" == "staging" ]
then
    destination_user="$dest_user_staging"
    destination_host="$dest_host_staging"
    destination_dir="$dest_dir_staging"
    # Push command over ssh
    ssh -l $destination_user $destination_host \
        "cd $destination_dir;\
        rm -rf composer.lock;\
        git reset --hard;\
        git fetch --all;\
        git checkout -f $destination_branch;\
        git reset --hard;\
        git fetch --all;\
        git pull origin $destination_branch;\
        /usr/local/bin/composer update --no-interaction --prefer-dist --optimize-autoloader;\
        php artisan clear-compiled;\
        php artisan migrate --force;\
        php artisan cache:clear;\
        php artisan route:clear;\
        php artisan view:clear;\
        php artisan config:clear;\
        php artisan config:cache;\
        npm i;\
        npm run dev;\
        php artisan config:clear;\
        /usr/bin/php ./vendor/bin/phpunit --log-junit ${destination_dir}/tests/results/${destination_project}_test1.xml"

    # Get test results
    ssh -l $destination_user $destination_host \
        "cat ${destination_dir}/tests/results/${destination_project}_test1.xml" &gt; ${item_rootdir}/tests/results/${destination_project}_test1.xml

###################
# PRODUCTION PUSH #
###################
elif [ "$destination_branch" == "production" ]
then
    destination_user="$dest_user_prod"
    destination_host="$dest_host_prod"
    destination_dir="$dest_dir_prod"
    pre_prod_dir="$pre_prod"

    # Get current latest commit running on prod
    current_local_commit=`ssh -l $destination_user $destination_host "cd $destination_dir;git rev-parse --short HEAD"`
    current_remote_commit=`ssh -l $destination_user $destination_host "cd $destination_dir;git rev-parse --short origin/${destination_branch} "`
    # Make sure local and remote arent the same because then theres no reason to push
    if [ "$current_local_commit" == "$current_remote_commit" ]
    then
        alert_msg="Remote HEAD : $current_remote_commit matches Local HEAD : $current_local_commit, exiting..."
        echo "$alert_msg"
        alert_notification $alert_email "$alert_msg"
        exit 1
    fi
