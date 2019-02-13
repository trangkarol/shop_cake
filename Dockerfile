FROM nginx:latest

ADD ./docker/default.conf /etc/nginx/conf.d/
RUN mkdir -p /var/www/example/
ADD ./ /var/www/example/
RUN chown -R nginx:nginx /var/www/example

#Install net tools
RUN apt-get update
RUN apt-get install net-tools lsof -y

#Change nginx uid & gid
RUN usermod -u 1000 nginx && groupmod -g 1000 nginx

##Clearing the apt-get caches
RUN apt-get clean

## Expose ports
EXPOSE 80
