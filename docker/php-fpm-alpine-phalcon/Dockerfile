# Argument for specifying PHP version
ARG PHP_VERSION=8.3-fpm-alpine

# Use PHP base image with the specified version
FROM php:${PHP_VERSION}

# Argument for specifying Phalcon version
ARG PHALCON_VERSION=5.8.0

# Install system dependencies including build tools
RUN apk update && apk add --no-cache \
        gettext-dev \
        gettext \
        oniguruma-dev \
        libpng-dev \
        icu-dev \
        libzip-dev \
        imap-dev \
        libxml2-dev \
        g++ \
        make \
        autoconf \
        bash \
        curl \
        build-base \
        linux-headers \
    && docker-php-ext-install \
        gettext \
        intl \
        bcmath \
        opcache \
        gd \
        imap \
        sockets \
    # Mysql
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-install pdo_mysql \
    && pecl install redis apcu \
    && docker-php-ext-enable redis apcu \
    # Clean up
    && rm -rf /tmp/* /var/cache/apk/*

# Install Phalcon
RUN curl -sSL https://codeload.github.com/phalcon/cphalcon/tar.gz/v$PHALCON_VERSION | tar xz \
    && cd cphalcon-$PHALCON_VERSION/build \
    && sh install \
    && docker-php-ext-enable phalcon \
    && cd ../../ \
    && rm -rf cphalcon-$PHALCON_VERSION 

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define an environment variable for the working directory
ENV WORKDIR_PATH=/var/www/html

# Set the working directory
WORKDIR $WORKDIR_PATH

# Copy the entrypoint script into the container
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set the script as the entrypoint
ENTRYPOINT ["entrypoint.sh"]

## Set the default command (what was originally the CMD in your Dockerfile)
CMD ["php-fpm"]
