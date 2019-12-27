# Для начала указываем исходный образ, он будет использован как основа
FROM php:7.4-cli

# RUN выполняет идущую за ней команду в контексте нашего образа.
# В данном случае мы установим некоторые зависимости и модули PHP.
# Для установки модулей используем команду docker-php-ext-install.
# На каждый RUN создается новый слой в образе, поэтому рекомендуется объединять команды.
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libonig-dev \
        libzip-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-source delete

# Куда же без composer'а.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Указываем рабочую директорию для PHP
WORKDIR /app

RUN git clone https://github.com/aerospike/aerospike-client-php.git
RUN cd aerospike-client-php/src && ./build.sh && make install
#RUN find aerospike-client-php/ -name "*.sh" -exec chmod +x {} \;
#RUN cd aerospike-client-php/ && composer run-script post-install-cmd && make install
#RUN php -i | grep ".ini "

# Добавим свой php.ini, можем в нем определять свои значения конфига
COPY docker-aerospike.ini /usr/local/etc/php/conf.d/

