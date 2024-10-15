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
  - php artisan make:model Employer -m -f  // create a model with accompanying migration and factory


REPL for laravel app
- php artisan tinker  // opens a repl for laravel


Factories
- used to create data from a model.
- Models by composition can take on behaviour via tratis.
- User model has trait hasFactory which means we can call factory methods on user to generate data
- eg. App\Models\User::factory()->create()
- eg. for creation multiple instances. Create 100 users in the DB
  - App\Models\User::factory(100)->create()


Eloquent
- App\Models\Job::find(1);

N+1 problem 
- happens due to lazy loading (similar to djano)
  - when loading data in a loop, if a relationship is reference in the loop and the data is not already loaded (due to lazy loading) then a new sql query is performed to fetch that data.  This means in a loop many extra queries can be performed which is bad for performance etc.
  - Use the Lavavel debug toolbar to detect these similarly to how it was done in django
    - ./vendor/bin/sail shell
    - composer require barryvdh/laravel-debugbar --dev
    - in .env set APP_DEBUG=true
    - Now good to go.
  - Fix it by using eager loading.  See "jobs" route in routes
  - To disable lazy loading project wide then add to App/Providers/AppServiceProvider.php the below
    - ```
        public function boot(): void
    {
        //
        Model::preventLazyLoading();
    }
    ```
  - This will display an error screen when you try to lazyload.  And you must then find the underlying eloquent query and eager load the query
  - eg
   ```
   <div class="font-bold text-blue-500 text-sm">{{ $job->employer->name }}</div> // lazy loading the employer info in a template

   underlying code is in route 
    CHANGE: // $jobs = Job::all(); // using eloquent orm // lazy loading. Does not fetch employer information
    TO: $jobs = Job::with('employer')->get(); //eager loading. Load emplyer information
   ```

   Pagination
   - see "jobs" route and jobs.blade.php.
   - Pagination UI looks good by default but we can also customize it if need be
     - to customize it we must fetch it from vendor and pushish it to our local project so we can edit it.
       - php artisan vendor:publish (now hit enter). This will give us a search in the termainal that we can find the package we are interested in.
       - the package in question is can be found by searching for "pagination". This will give us the tag "laravel-pagination" which is what we want to edit
       - we can switch to bootsrap for instance instead of tailwind via "App/Providers/AppServiceProvider.php"
         -  add "Paginator::useBootstrapFive();" to the boot function.  