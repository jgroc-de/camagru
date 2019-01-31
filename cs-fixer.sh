#!/bin/bash
php vendor/friendsofphp/php-cs-fixer/php-cs-fixer -vvv --allow-risky fix .
./vendor/bin/phpstan analyse app Dumb public --level max
