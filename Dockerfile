FROM php:7.4.2-apache-buster

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

ARG LARAVEL_DB_CONNECTION
ARG LARAVEL_DB_HOST
ARG LARAVEL_DB_PORT
ARG LARAVEL_DB_DATABASE
ARG LARAVEL_DB_USERNAME
ARG LARAVEL_DB_PASSWORD

# Update
RUN apt-get -y update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*


# Install useful tools and install important libaries
RUN apt-get -y update && \
    apt-get -y --no-install-recommends install nano wget \
dialog \
libsqlite3-dev \
libsqlite3-0 && \
    apt-get -y --no-install-recommends install default-mysql-client \
zlib1g-dev \
libzip-dev \
libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing apt-utils \
build-essential \
git \
curl \
libonig-dev && \ 
    apt-get -y --no-install-recommends install --fix-missing libcurl4 \
libcurl4-openssl-dev \
zip \
openssl && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install xdebug
RUN pecl install xdebug-2.8.0 && \
    docker-php-ext-enable xdebug

# Install redis
#RUN pecl install redis-5.1.1 && \
##   docker-php-ext-enable redis

# Install imagick
RUN apt-get update && \
    apt-get -y --no-install-recommends install --fix-missing libmagickwand-dev && \
    rm -rf /var/lib/apt/lists/* && \
    pecl install imagick && \
    docker-php-ext-enable imagick

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
    docker-php-ext-install gettext && \
    docker-php-ext-install exif


# Install Freetype 
RUN apt-get -y update && \
    apt-get --no-install-recommends install -y libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Removing /var/lib/apt/lists worked
RUN rm -rf /var/lib/apt/lists/ && curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install nodejs -y

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/

#RUN git clone https://$GITHUB_USERNAME:$GITHUB_PASSWORD@github.com/cystecnologia/cyslab-backend.git html
RUN git clone https://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@github.com/cystecnologia/cyslab-backend.git html

RUN chmod -R 777 /var/www/html/*

WORKDIR /var/www/html

RUN echo "" > ./.env
RUN echo "APP_NAME=$LARAVEL_APP_NAME" >> ./.env
RUN echo "APP_ENV=$LARAVEL_APP_ENV" >> ./.env
RUN echo "APP_KEY=" >> ./.env
RUN echo "APP_DEBUG=$LARAVEL_APP_DEBUG" >> ./.env
RUN echo "APP_URL=$LARAVEL_APP_URL" >> ./.env
RUN echo "LOG_CHANNEL=daily" >> ./.env
RUN echo "DB_CONNECTION=$LARAVEL_DB_CONNECTION" >> ./.env
RUN echo "DB_HOST=$LARAVEL_DB_HOST" >> ./.env
RUN echo "DB_PORT=$LARAVEL_DB_PORT" >> ./.env
RUN echo "DB_DATABASE=$LARAVEL_DB_DATABASE" >> ./.env
RUN echo "DB_USERNAME=$LARAVEL_DB_USERNAME" >> ./.env
RUN echo "DB_PASSWORD=$LARAVEL_DB_PASSWORD" >> ./.env
RUN echo "BROADCAST_DRIVER=log" >> ./.env
RUN echo "CACHE_DRIVER=file" >> ./.env
RUN echo "QUEUE_CONNECTION=database" >> ./.env
RUN echo "SESSION_DRIVER=cookie" >> ./.env
RUN echo "SESSION_LIFETIME=120" >> ./.env
RUN echo "REDIS_HOST=127.0.0.1" >> ./.env
RUN echo "REDIS_PASSWORD=null" >> ./.env
RUN echo "REDIS_PORT=6379" >> ./.env
RUN echo 'JWT_SECRET=4SnAQXwkWn4rE2NOf8Wlq7E8SzPMlAwrZkSUWBPUNlXdJ0AzB4vzMajhEmtstgbz' >> ./.env
RUN echo "JWT_PRIVATE_KEY=4SnAQXwkWn4rE2NOf8Wlq7E8SzPMlAwrZkSUWBPUNlXdJ0AzB4vzMajhEmtstgbz" >> ./.env

#RUN composer install -n
RUN composer install --optimize-autoloader --no-dev -n

RUN npm install 

RUN npm run prod

RUN php artisan key:generate
RUN php artisan jwt:secret
RUN php artisan migrate --force
RUN php artisan db:seed --force

RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:clear

# Enable apache modules
RUN a2enmod rewrite headers
RUN a2enmod ssl

# Cleanup
RUN rm -rf /usr/src/*

RUN chmod -R 777 ./*

EXPOSE 80 443

#CMD ["php","/var/www/html/artisan","queue:work","&"]