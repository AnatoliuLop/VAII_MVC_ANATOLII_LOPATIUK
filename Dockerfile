FROM php:8.1-apache

RUN apt-get update && docker-php-ext-install mysqli pdo pdo_mysql



#  Inštalujeme potrebné rozšírenia, povoľujeme rewrite atď.
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

# Meníme DocumentRoot
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# Kopírujeme súbory projektu
COPY . /var/www/html

# Predpokladajme, že chceme udeliť práva na všetky súbory pod www-data
RUN chown -R www-data:www-data /var/www/html/public/uploads
RUN chmod -R 777 /var/www/html/public/uploads
RUN chmod -R g+s /var/www/html/public/uploads

WORKDIR /var/www/html/public

EXPOSE 80
CMD ["apache2-foreground"]
