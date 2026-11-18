#!/bin/bash
# Comando de inicio en Azure App Service: aplica la configuración de nginx
# y prepara la caché de Laravel.
cp /home/site/wwwroot/deploy/nginx.conf /etc/nginx/sites-available/default
service nginx reload
cd /home/site/wwwroot
php artisan config:cache
php artisan route:cache
php artisan view:cache
