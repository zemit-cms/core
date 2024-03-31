# Use the official PHP 8.2 Apache base image
FROM php:8.2-apache

# Update and upgrade packages
RUN apt-get update && apt-get upgrade -y

# Install system dependencies
RUN apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        gnupg \
        build-essential \
        libpspell-dev \
        libicu-dev \
        openssl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Install Redis and APCu extensions
RUN pecl install redis apcu \
    && docker-php-ext-enable redis apcu

# Install and configure Opcache for PHP
RUN docker-php-ext-install opcache

# Enable Apache modules
RUN a2enmod rewrite headers ssl

# Copy existing application directory contents
COPY . /var/www/html

# Update Apache configuration to set /public as the document root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Generate self-signed SSL certificate
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/localhost.key \
    -out /etc/ssl/certs/localhost.crt \
    -subj "/C=CA/ST=Quebec/L=Montreal/O=Zemit/CN=localhost"

# Configure Apache to use SSL
RUN sed -i 's|SSLCertificateFile.*|SSLCertificateFile /etc/ssl/certs/localhost.crt|' /etc/apache2/sites-available/default-ssl.conf \
    && sed -i 's|SSLCertificateKeyFile.*|SSLCertificateKeyFile /etc/ssl/private/localhost.key|' /etc/apache2/sites-available/default-ssl.conf

# Optionally, enable the default SSL site
RUN a2ensite default-ssl

# Set the working directory to the public folder
WORKDIR /var/www/html/public

# Apache is already configured to listen on port 80 and 443
EXPOSE 80 443

# Phalcon installation
# Download and install Phalcon 5.6.2
RUN curl -sSL https://github.com/phalcon/cphalcon/archive/refs/tags/v5.6.2.tar.gz | tar xz \
    && cd cphalcon-5.6.2/build \
    && ./install \
    && docker-php-ext-enable phalcon

# Start Apache in the foreground
CMD ["apache2-foreground"]
