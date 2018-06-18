#!/bin/sh
cd /home/svystun/www/$1

if ["$2" = "git-pull"]
then
    git pull
fi