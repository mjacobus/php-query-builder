#!/bin/bash

php --version | grep 5.5 > /dev/null

if (( $? == 0 )); then
  echo "Installing PHP Code Sniffer"

  pyrus install pear/PHP_CodeSniffer
  phpenv rehash
fi
