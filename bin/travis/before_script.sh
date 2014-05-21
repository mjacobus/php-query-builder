# only if version is 5.5

php --version | grep 5.5 > /dev/null

if (( $? == 0 )); then
  curl -s getcomposer.org/installer | php -d detect_unicode=Off
  php composer.phar install --dev --no-interaction
  ./install_phpcs.sh
fi
