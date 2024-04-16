FROM debian:12

WORKDIR /var/www/istores-demo

RUN apt-get update
RUN apt-get install -y php-fpm php-dom php-curl php-mysql php-redis composer nodejs npm

ENTRYPOINT ["/usr/bin/bash"]
