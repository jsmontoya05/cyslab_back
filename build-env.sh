#!/bin/bash 
echo "" > ./.env
echo "APP_NAME=${1}" >> ./.env
echo "APP_ENV=${2}" >> ./.env
echo "APP_KEY=" >> ./.env
echo "APP_DEBUG=${3}" >> ./.env
echo "APP_URL=${4}" >> ./.env

echo "LOG_CHANNEL=stack" >> ./.env

echo "DB_CONNECTION=${5}" >> ./.env
echo "DB_HOST=${6}" >> ./.env
echo "DB_PORT=${7}" >> ./.env
echo "DB_DATABASE=${8}" >> ./.env
echo "DB_USERNAME=${9}" >> ./.env
echo "DB_PASSWORD=${10}" >> ./.env

echo "BROADCAST_DRIVER=log" >> ./.env
echo "CACHE_DRIVER=file" >> ./.env
echo "QUEUE_CONNECTION=database" >> ./.env
echo "SESSION_DRIVER=cookie" >> ./.env
echo "SESSION_LIFETIME=120" >> ./.env

echo "REDIS_HOST=127.0.0.1" >> ./.env
echo "REDIS_PASSWORD=null" >> ./.env
echo "REDIS_PORT=6379" >> ./.env

echo "MAIL_DRIVER=smtp" >> ./.env
echo "MAIL_HOST=smtp.mailtrap.io" >> ./.env
echo "MAIL_PORT=2525" >> ./.env
echo "MAIL_USERNAME=null" >> ./.env
echo "MAIL_PASSWORD=null" >> ./.env
echo "MAIL_ENCRYPTION=null" >> ./.env

echo "AWS_ACCESS_KEY_ID=" >> ./.env 
echo "AWS_SECRET_ACCESS_KEY=" >> ./.env
echo "AWS_DEFAULT_REGION=us-east-1" >> ./.env
echo "AWS_BUCKET=" >> ./.env

echo "PUSHER_APP_ID=" >> ./.env
echo "PUSHER_APP_KEY=" >> ./.env
echo "PUSHER_APP_SECRET=" >> ./.env
echo "PUSHER_APP_CLUSTER=mt1" >> ./.env

echo 'MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"' >> ./.env
echo 'MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"' >> ./.env

echo "AZURE_CLIENT_ID=${11}" >> ./.env
echo "AZURE_CLIENT_SECRET=${12}" >> ./.env
echo "AZURE_REDIRECT_URI=${13}" >> ./.env
echo "ROUTE_APP_SPA=${14}" >> ./.env

echo 'JWT_SECRET=4SnAQXwkWn4rE2NOf8Wlq7E8SzPMlAwrZkSUWBPUNlXdJ0AzB4vzMajhEmtstgbz' >> ./.env
echo "JWT_PRIVATE_KEY=4SnAQXwkWn4rE2NOf8Wlq7E8SzPMlAwrZkSUWBPUNlXdJ0AzB4vzMajhEmtstgbz" >> ./.env


echo "AZURE_ROUTE_LOGOUT=https://login.microsoftonline.com/common/oauth2/logout?post_logout_redirect_uri=${14}&redirect_uri=${14}" >> ./.env

echo "SENTRY_LARAVEL_DSN=${15}" >> ./.env
echo 'SENTRY_TRACES_SAMPLE_RATE=1' >> ./.env