Стандарт оформления PHP кода
============================

Установка
---------

#####Установить PHP_CodeSniffer:

    composer global require squizlabs/php_codesniffer 

#####Склонировать репозиторий:

    git clone https://github.com/itmh/coding-standard-php.git $HOME/.coding-standard-php

#####Создать в папке со стандартами симлинк на склонированный репозиторий

    ln -sv $HOME/.coding-standard-php/phpcs/ITMH $HOME/.composer/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards

Использование
-------------

    $HOME/.composer/vendor/bin/phpcs --standard=ITMH /path/to/file.php
    $HOME/.composer/vendor/bin/phpcs --standard=ITMH /path/to/directory
