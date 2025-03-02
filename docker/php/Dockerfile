FROM php:8.3-cli

RUN apt update && apt install -y curl unzip sqlite3

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /application

RUN useradd -m -u 1000 jose
USER jose

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
