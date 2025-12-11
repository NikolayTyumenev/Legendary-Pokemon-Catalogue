FROM php:8.4-apache

# Install OS packages & enable PHP extensions
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
      curl \
      zip unzip \
      git \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libwebp-dev \
      libavif-dev \
      libaom-dev \
      libdav1d-dev \
      libyuv-dev \
    && docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      --with-jpeg=/usr/include/ \
      --with-webp \
      --with-avif \
    && docker-php-ext-install -j"$(nproc)" \
      gd \
      pdo_mysql \
      mysqli \
    && rm -rf /var/lib/apt/lists/*

# Create session directory with proper permissions - Team builder breaking without this
RUN mkdir -p /var/lib/php/sessions && \
    chmod 777 /var/lib/php/sessions

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy Apache config
COPY apache-dirlist.conf /etc/apache2/sites-enabled/000-default.conf