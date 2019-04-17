#! /bin/bash

git pull
php composer.phar install --no-dev
chown www-data var/ -R
chgrp www-data var/ -R