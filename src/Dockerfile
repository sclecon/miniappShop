FROM hyperf/hyperf:7.4-alpine-v3.15-swoole
MAINTAINER sclecon <27941662@qq.com>
WORKDIR /opt/www

RUN set -ex \
    && php -v \
    && php -m \
    && php --ri swoole \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

# CMD ["php", "bin/hyperf.php", "start"] \
CMD ["top"]