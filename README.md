Стандарт кодирования ITMH
==============================

Установка
---------

#####Установить PHP_CodeSniffer:

    composer global require squizlabs/php_codesniffer 

#####Склонировать репозиторий:

    git clone https://github.com/itmh/php-standard-itmh.git $HOME/.php-standard-itmh

#####Создать в папке со стандартами симлинк на склонированный репозиторий

    ln -sv $HOME/.php-standard-itmh/ITMH $HOME/.composer/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards

Использование
-------------

    phpcs --standard=ITMH /path/to/file.php
    phpcs --standard=ITMH /path/to/directory
