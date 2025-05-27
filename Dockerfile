FROM php:8.2-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    curl \
    git \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    unzip \
    zip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd pdo pdo_mysql \
  && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Comando padrão
CMD ["php-fpm"]
