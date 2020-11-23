#!/bin/bash
php vendor/friendsofphp/php-cs-fixer/php-cs-fixer -vvv --allow-risky fix .
./vendor/bin/phpstan analyse -c phpstan.neon
