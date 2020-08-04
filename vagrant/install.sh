#!/bin/bash

echo ""
echo " ------ START CUSTOM INSTALLATION ------------"
echo ""

apt update -y
apt upgrade -y

timedatectl set-timezone UTC

add-apt-repository ppa:ondrej/php
apt update -y
apt upgrade -y

apt remove -y --auto-remove git
apt install -y nginx
apt install -y php7.4 php7.4-cli php7.4-fpm php7.4-json php7.4-pdo php7.4-mysql php7.4-zip php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath php7.4-json php7.4-xdebug
apt install -y composer
# Install MySQL Server in a Non-Interactive mode. Default root password will be "qwerty"
echo "mysql-server-5.6 mysql-server/root_password password qwerty" | sudo debconf-set-selections
echo "mysql-server-5.6 mysql-server/root_password_again password qwerty" | sudo debconf-set-selections
apt install -y mysql-server-5.6
mysql_secure_installation
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
mysql -uroot -p -e 'USE mysql; UPDATE `user` SET `Host`="%" WHERE `User`="root" AND `Host`="localhost"; DELETE FROM `user` WHERE `Host` != "%" AND `User`="root"; FLUSH PRIVILEGES;'
mysql -e "CREATE USER 'exam'@'%' IDENTIFIED BY 'qwerty'; GRANT ALL PRIVILEGES ON *.* TO 'exam'@'%';FLUSH PRIVILEGES;CREATE DATABASE exam CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
service mysql restart

# Nginx
systemctl disable nginx
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt -subj "/C=ES/ST=Barcelona/L=Exam/O=Dis/CN=exam.dev"
ln -s /var/www/exam/nginx.conf /etc/nginx/sites-enabled/exam
mkdir -p /var/log/nginx/exam
cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf.originalBKP
sed -i 's/http {/http {\n\n        ##\n        # Custom Settings\n        ##\n        client_max_body_size 200m;/' /etc/nginx/nginx.conf
service nginx restart
systemctl enable nginx

# PHP fpm
echo "xdebug.remote_enable=1" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.remote_host=192.168.12.1" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.remote_port=9000" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.remote_autostart=1" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.remote_log = /tmp/xdebug_remote.log" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.idekey=PHPSTORM" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.profiler_enable=0" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.profiler_output_dir=/tmp" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.profiler_output_name=cachegrind.out.%R" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.max_nesting_level=200" >> /etc/php/7.4/mods-available/xdebug.ini
echo "xdebug.var_display_max_data = 8192" >> /etc/php/7.4/mods-available/xdebug.ini

service php7.4-fpm restart

# Symfony console
wget https://get.symfony.com/cli/installer -O - | bash
mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Project setup
cd /var/www/exam || return


echo "cd /var/www/exam" >> /home/vagrant/.bashrc

echo ""
echo "DONE :), have a nice coding! https://192.168.12.90/"
echo ""
