# from https://www.drupal.org/requirements/php#drupalversions
FROM php:7.4-apache

# Activate the rewrite_module
# RUN set -ex; \
#     \
#     if command -v a2enmod; then \
#       a2enmod rewrite; \
#     fi; \
#     \
#     savedAptMark="$(apt-mark showmanual)";
RUN a2enmod rewrite

# Install packages
RUN rm /bin/sh && ln -s /bin/bash /bin/sh && \
    apt-get update && apt-get install --no-install-recommends -y \
      libjpeg-dev \
      libpng-dev \
      libpq-dev \
      libzip-dev \
      curl \
      wget \
      vim \
      git \
      unzip \
      default-mysql-client \
    ;

# Install PHP extensions
# RUN docker-php-ext-install \
#     mcrypt

# From the official docker image
RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr; \
    docker-php-ext-install -j "$(nproc)" \
      gd \
      opcache \
      pdo_mysql \
      pdo_pgsql \
      zip \
    ;
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
# RUN apt-mark auto '.*' > /dev/null; \
#     apt-mark manual $savedAptMark; \
#     ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
#       | awk '/=>/ { print $3 }' \
#       | sort -u \
#       | xargs -r dpkg-query -S \
#       | cut -d: -f1 \
#       | sort -u \
#       | xargs -rt apt-mark manual; \
#     \
#     apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
#     rm -rf /var/lib/apt/lists/*

# Clean repository
RUN apt-get clean && rm -rf /var/lib/apt/lists/*







WORKDIR /var/www/html

COPY public_html /var/www/html/
