FROM trafex/php-nginx

# Where our code is volume mounted
WORKDIR /var/www/html

USER root

# This image is missing PDO support
RUN apk add --no-cache php8-pdo_sqlite

# Make sure PHP runs as non-root
RUN echo "user = nobody" >> /etc/php8/php-fpm.conf
RUN sed -i 's/8080/5000/g' /etc/nginx/nginx.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Because we are using a volume mount, we have to run composer on init instead
# Obviously we wouldn't do this on a production Docker image.
CMD composer install --optimize-autoloader --no-interaction --no-progress \
&& /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf -u root

EXPOSE 5000