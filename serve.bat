@echo off
title JANGAN DITUTUP BOSS!!!!


start cmd /k "cd /d %~dp0 && php artisan serve"


start cmd /k "cd /d %~dp0 && php artisan queue:work"


start cmd /k "cd /d %~dp0 && php artisan schedule:work"

