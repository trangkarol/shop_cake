FROM nginx:latest

ADD ./default.conf /etc/nginx/conf.d/default.conf
ADD ./src /var/www/blog
RUN chown www-data:www-data -R /var/www/blog

RUN apt-get update
RUN apt-get install net-tools -y
