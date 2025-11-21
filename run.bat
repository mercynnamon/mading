@echo off
mysql -u root -p emading < final_setup.sql
php artisan config:clear
php artisan serve
pause