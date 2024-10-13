Setup laravel
- curl -s https://laravel.build/example-app | bash
- cd ./example-app
- Add APP_PORT=9000 to .env file to avoid app starting on port 80
- ./vendor/bin/sail up
- ./vendor/bin/sail artisan migrate (Run only the very first time you set up the app)


Run laravel app
- cd ./example-app
- ./vendor/bin/sail up


{{ }} is blade syntaxt and is equivalent to <?php echo ?>


Configure laravel app in .env file
- example configure type of db
- application port

Running commands must be done via sail
- vendor/bin/sail artisan 
- OR switch to sail shell "./vendor/bin/sail shell" and run commands directly there example "php artisan"
- ./vendor/bin/sail shell
  - php artisan
  - php artisan db:show
  - php artisan make:migration // create a migration
  - php artisan migrate // run a migration
