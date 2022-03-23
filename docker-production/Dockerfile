FROM php:7.3-apache-stretch

# Surpresses debconf complaints of trying to install apt packages interactively
# https://github.com/moby/moby/issues/4032#issuecomment-192327844
 
ARG DEBIAN_FRONTEND=noninteractive

#Arguments for clone repository of github
ARG GITHUB_USERNAME
ARG GITHUB_PASSWORD

#Arguments for .env laravel project
ARG LARAVEL_APP_NAME
ARG LARAVEL_APP_ENV
ARG LARAVEL_APP_DEBUG
ARG LARAVEL_APP_URL
ARG LARAVEL_LOG_CHANNEL
ARG LARAVEL_DB_CONNECTION
ARG LARAVEL_DB_HOST
ARG LARAVEL_DB_PORT
ARG LARAVEL_DB_DATABASE
ARG LARAVEL_DB_USERNAME
ARG LARAVEL_DB_PASSWORD
ARG LARAVEL_AZURE_CLIENT_ID
ARG LARAVEL_AZURE_CLIENT_SECRET
ARG LARAVEL_AZURE_REDIRECT_URI
ARG LARAVE_SENTRY_LARAVEL_DSN

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*


# Install useful tools and install important libaries
RUN apt-get -y update && \
    apt-get -y --no-install-recommends install nano wget dialog libsqlite3-dev libsqlite3-0 && \
    apt-get -y --no-install-recommends install mysql-client zlib1g-dev libzip-dev libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing apt-utils build-essential git curl && \ 
    apt-get -y --no-install-recommends install --fix-missing libcurl3 libcurl3-dev zip openssl && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug-2.7.2 && \
    docker-php-ext-enable xdebug

# Install redis
RUN pecl install redis-5.0.2 && \
    docker-php-ext-enable redis

# Other PHP7 Extensions

RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo_sqlite && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install curl && \
    docker-php-ext-install tokenizer && \
    docker-php-ext-install json && \
    docker-php-ext-install zip && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install gettext

# Install Freetype 
RUN apt-get -y update && \
    apt-get --no-install-recommends install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/

RUN git clone "https://$GITHUB_USERNAME:$GITHUB_PASSWORD@github.com/cystecnologia/cyslab-backend.git" html

RUN chmod -R 777 ./html/*

WORKDIR /var/www/html

ENTRYPOINT ["./build-env.sh $LARAVEL_APP_NAME \
$LARAVEL_APP_ENV \
$LARAVEL_APP_DEBUG \
$LARAVEL_APP_URL \
$LARAVEL_LOG_CHANNEL \
$LARAVEL_DB_CONNECTION \
$LARAVEL_DB_HOST \
$LARAVEL_DB_PORT \
$LARAVEL_DB_DATABASE \
$LARAVEL_DB_USERNAME \
$LARAVEL_DB_PASSWORD \
$LARAVEL_AZURE_CLIENT_ID \
$LARAVEL_AZURE_CLIENT_SECRET \
$LARAVEL_AZURE_REDIRECT_URI \
$LARAVE_SENTRY_LARAVEL_DSN \
"]

#RUN cp .env.example .env

RUN composer install -n

RUN php artisan key:generate

# Enable apache modules
RUN a2enmod rewrite headers

# Cleanup
RUN rm -rf /usr/src/*

EXPOSE 80 443 22