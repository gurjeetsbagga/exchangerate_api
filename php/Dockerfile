
FROM php:7.4-fpm
#
## Install PHP extensions deps
RUN apt-get update \
    && apt-get install --no-install-recommends -y \
#           libfreetype6-dev \
           libpng-dev \
           libonig-dev \
           zlib1g-dev \
#           g++ \
#           libicu-dev \
#           libmcrypt4 \
#           libzip-dev \
#        libjpeg62-turbo-dev \
#        libmcrypt-dev \
#        unixodbc-dev \
#        libxml2-dev \
#        libaio-dev \
        libmemcached-dev \
#        freetds-dev \
#	libssl-dev \
	openssl

# Install unzip utility and libs needed by zip PHP extension
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

## Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- \
#        --install-dir=/usr/local/bin \
#        --filename=composer
# install composer
RUN curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Whether or not to install Xdebug
ARG WITH_XDEBUG=false

# install Xdebug
RUN set -eux; \
   if [ $WITH_XDEBUG = "true" ] ; then \
       pecl install xdebug; \
       docker-php-ext-enable xdebug; \
       echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
       echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
       echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
       echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
       echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
       echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
   fi ;

# Install PHP extensions
RUN docker-php-ext-configure gd \
    && pecl install redis \
    && pecl install memcached \
    && docker-php-ext-enable \
            redis \
            memcached \
            opcache
# Install APCu and APC backward compatibility
RUN pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

# phalcon version setting
ARG PSR_VERSION=1.0.0
ARG PHALCON_VERSION=4.0.5
ARG PHALCON_EXT_PATH=php7/64bits

RUN set -xe && \
   # install PSR
   curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
   tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
   # install Phalcon
   curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
   tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
   docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) \
       ${PWD}/php-psr-${PSR_VERSION} \
       ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} \
   && \
   # remove tmp file
   rm -r \
       ${PWD}/v${PSR_VERSION}.tar.gz \
       ${PWD}/php-psr-${PSR_VERSION} \
       ${PWD}/v${PHALCON_VERSION}.tar.gz \
       ${PWD}/cphalcon-${PHALCON_VERSION} \
   && \
   php -m \

RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*



RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

## change the document root to /var/www/html/public
#RUN sed -i -e "s/html/html\/public/g" \
#
## enable apache mod_rewrite
#RUN a2enmod rewrite
#
#WORKDIR /var/www/html
#
#COPY . /var/www/html
#COPY --from=vendor /app/vendor/ /var/www/html/vendor/
#COPY --from=vuejs /app/public/js/ /var/www/html/public/js/
#COPY --from=vuejs /app/public/css/ /var/www/html/public/css/
#COPY --from=vuejs /app/mix-manifest.json /var/www/html/mix-manifest.json
#
