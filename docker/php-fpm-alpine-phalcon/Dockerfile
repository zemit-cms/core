# Argument for specifying PHP version
ARG PHP_VERSION=8.3-fpm-alpine

# Use PHP base image with the specified version
FROM php:${PHP_VERSION}

# Argument for specifying Phalcon version
ARG PHALCON_VERSION=5.8.0

# Install system dependencies including build tools
RUN apk add --no-cache --virtual .build-deps \
        gettext-dev \
        oniguruma-dev \
        libpng-dev \
        icu-dev \
        libzip-dev \
        imap-dev \
        libxml2-dev \
        libxslt-dev \
        openldap-dev \
        g++ \
        make \
        autoconf \
        bash \
        curl \
        build-base \
        linux-headers \
    && apk add --no-cache \
        gettext \
        icu \
        imap \
        libpng \
        libxml2 \
        libxslt  \
        libzip \
        oniguruma \
    && docker-php-ext-install -j$(nproc) \
        gettext \
        intl \
        bcmath \
        opcache \
        imap \
        sockets \
        bz2 \
        calendar \
        gd \
        ldap \
        mbstring \
        pcntl \
        xsl \
        zip \
    # Mysql
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-install pdo_mysql \
    # Pecl Extensions
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install apcu docker-php-ext-enable apcu \
#    && pecl install imagick docker-php-ext-enable imagick \
    # Clean up
    && pecl clear-cache \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*

# Install Phalcon Extension
RUN set -xe \
        && export CFLAGS="$CFLAGS -fpermissive" \
        && cd / && docker-php-source extract \
        && curl -sSLO "https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz" \
        && tar xzf "/v${PHALCON_VERSION}.tar.gz" \
        && docker-php-ext-install -j$(nproc) "/cphalcon-${PHALCON_VERSION}/build/phalcon" \
        && rm -r "/v${PHALCON_VERSION}.tar.gz" "/cphalcon-${PHALCON_VERSION}" \
        && docker-php-source delete \
        && php -m | grep phalcon

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
