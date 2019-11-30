## 安装

~~~
yum install -y epel-release
yun update -y
 
yum install -y autoconf curl-devel openssl openssl-devel openssl openssl-devel gcc gcc-c++ libxml2 libxml2-devel libpng libpng-devel bzip2 bzip2-devel freetype-devel libicu-devel
 
 
wget https://nih.at/libzip/libzip-1.2.0.tar.gz
tar -zxvf libzip-1.2.0.tar.gz
cd libzip-1.2.0
./configure
make && make install
 
cp /usr/local/lib/libzip/include/zipconf.h /usr/local/include/zipconf.h
 
 
wget https://www.php.net/distributions/php-7.3.11.tar.gz
tar -xzvf php-7.3.11.tar.gz
 
wget https://www.php.net/distributions/php-7.2.22.tar.gz
tar -xzvf php-7.2.22.tar.gz 
 
 
 
./configure --prefix=/usr/local/php7  --with-bz2 --with-curl --enable-filter --enable-fpm --with-gd --enable-intl --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --with-openssl --with-zlib --with-freetype-dir --disable-phpdbg --disable-phpdbg-webhelper --enable-opcache --enable-simplexml --enable-xmlreader --enable-xmlwriter --enable-zip --enable-soap --enable-shmop --enable-sockets --enable-sysvmsg --enable-bcmath --enable-mbstring --enable-mysqlnd  --enable-tokenizer
 
make && make install
 
 
vi /etc/profile
export PATH=/usr/local/php7/bin:$PATH
source /etc/profile
 
 
 
php -i | grep php.ini
cp php.ini-development /usr/local/php7/lib/php.ini
 
pecl install redis
echo extension=redis.so >>/usr/local/php7/lib/php.ini
 
 
 
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

~~~
