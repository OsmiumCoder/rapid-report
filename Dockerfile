FROM dunglas/frankenphp

ENV SERVER_NAME=:80

COPY . /app

WORKDIR /app

RUN apt-get update && apt-get install -y supervisor

RUN install-php-extensions \
	mbstring \
	xml \
	zip \
	curl \
	gd \
    pdo \
    pdo_mysql \
    pcntl \
    redis


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN mkdir -p /var/log/supervisor

RUN composer update
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

RUN npm install --production

RUN npm run build:ssr

RUN ln -s /usr/bin/php /usr/bin/php8.4

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
