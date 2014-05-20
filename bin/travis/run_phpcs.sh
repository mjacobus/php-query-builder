#!/bin/bash

CODE=0

php --version | grep 5.5 > /dev/null


if (( $? == 0 )); then
  echo ""
  echo -en "Checking lib code standard..."
  phpcs --standard=PSR2 lib

  if (( $? == 0 )); then
    echo -e '\E[32m'"\033[1m\tPASSED!\033[0m" # Green
  else
    echo   -e '\E[31;47m'"\033[1m\tFAILED!\033[0m"   # Red
    CODE=1
  fi

  echo -en "Checking tests code standard..."
  phpcs --standard=PSR2 tests

  if (( $? == 0 )); then
    echo -e '\E[32m'"\033[1m\tPASSED!\033[0m" # Green
  else
    echo   -e '\E[31;47m'"\033[1m\tFAILED!\033[0m"   # Red
    CODE=1
  fi
fi

exit $CODE
