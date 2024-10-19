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
  
Seeders
- use this to seed a database with data afer doing for exampe a "php artisan migrate:fresh"
- seeders are location in "/database/seeders"
- php artisan db:seed  // run the seeders to seed db
  - OR you can start from scratch and reseed at same time
    - php artisan migrate:fresh --seed 
- php artisan make:seeder // create a dedicated seeder file.  That is create a seeder for user table only etc.
- php artisan db:seed // runs DefaultSeeder.php by default
- php artisan db:seed --class=JobSeeder // run a specific seeder. !!! REMEMBER TO CLEAR TABLE FIRST OR SEEDING WILL JUST APPEND DATA !!!

Fillable propert in models
- $fillable // signifies which fields can be mass populated when using eloquent to create a record.
- $guarded // opposite to fillable, so signifies which fields CANNOT be mass populated. Usually less annoying than fillable
- so to diable fillable one way is to use $guarded with an empty array.

Validation
- request()->validate()
- request()->validate(['title' => ['required', min:3]])
- https://laravel.com/docs/validation

Controllers
- php artisan make:controller // interactive prompt
- php artisan make:controller <MyController>
- php artisan route:list  // list all your routes
- php artisan route:list --except-vendor // list routes with out all the noise of vendor routes
- The route names are specific
  - index
  - show
  - create
  - store
  - edit
  - update
  - destroy
  
Controllers can be grouped to simplify even further

Route::controller(JobController::class)->group(function() {
    Route::get("/jobs", "index");
    Route::get('/jobs/{job}', "show");
    Route::get('jobs/create',  "create");
    Route::post('/jobs', "store");
    Route::get('/jobs/{job}/edit', "edit");
    Route::patch('/jobs/{job}', "update");
    Route::delete('/jobs/{job}', "destroy");
})

Can use resource route to autogenerate the above. Note specific route names are used
Resource is just the collective name for all the related routes for a model. Contollers are use to handle the business logic for these routes.

Route::resource('jobs', JobController::class)

if some of the default routes are not needed we can exclude them
Route::resource('jobs', JobController::class, [
    'except' => ['edit']
])

OR include only routes
Route::resource('jobs', JobController::class, [
    'only' => ['edit']
])


Authentication
- check out laravel breeze


Gates
- Gate::
- Gates are like real gates. They allow entry if you meet certain criteria.
- For example in our Jobcontroller edit function we can check if a user is authorized to perform a certain action. This logic is stuck in the controller. Enter gates.  
- Example of a gate in action. It checks the authorization of a user to edit a job
  ```
      public function edit(Job $job)
    {
        Gate::define('edit-job', function (User $user, Job $job) {
            return ($job->employer->user->is($user));
        }); // Define a gate that will check if a user can update this job

        if (Auth::guest()) return redirect('/login');

        // if ($job->employer->user->isNot(Auth::user())) abort(403);
        Gate::authorize('edit-job', $job); // use the gate to allow user to update job

        return view('jobs/edit', ["job" => $job]);
    }
    ```
- Gate::authorize is automatically handled by Laravel and returns a 403 but if you need to handle the behavour manually use
  - Gate::denies or Gate::denies
  - example
  ```
  // if the gate denies access to the user trying to edit this job then do something, like redirect somewhere or run some other logic
  if (Gate::denies('edit-job', $job)) {

  }
  ```
- For best usage Gates should be place where they can be accessed easily.  In above example the gate is only created when the edit page is displayed.  This is not exactly what we want.  We need it to be more globally accessible.  
- Place it in the app/Providers/AppServiceProvider.php file in the boot section.
- Note that the user passed to the gate is always the currently logged in user. So if you are not logged in the Gate instanaly fails and does not run any logic inside. If you do need to Gate to run the logic even if user is not logged in can make user optional or give it a default of null
  ```
          Gate::define('edit-job', function (?User $user, Job $job) {
            return ($job->employer->user->is($user));
        }); 
    
    OR

            Gate::define('edit-job', function (User $user = null, Job $job) {
            return ($job->employer->user->is($user));
        }); 
    ```
Note we can use these gates to show/hide/enable/disable features like buttons on the fornt end.
eg.        
```
@can('edit-job', $job) <!-- using a gate to hid and show the edit button if user is authorized via the gate-->
   <p><x-button href="/jobs/{{ $job['id'] }}/edit">Edit Job</x-button></p>
@endcan
```

Using gates can get repetitive when you have to put them in every controller funtion they are needed in.  A better way is to call them at the ROUTE (the route file) level using MIDDLEWARE

Middleware
- can be used on the route level
- can use multipe middleware on one route
- eg: Route::post('/jobs', [JobController::class, "store"])->middleware('auth'); // requires user to be signed in.
- eg: Route::post('/jobs', [JobController::class, "edit"])->middleware(['auth', can:edit-job,job]); //user must be signed in AND we use a gate to check if user can edit. // NOTE the job provided to can-edit is the wildcard {job} mentioned in the route url
OR
Route::post('/jobs', [JobController::class, "edit"])->middleware('auth')->can(edit-job,job)

Note that this "can" method/directive can be found on the 
- Route declarations
- User model
- blade views

Policies
- policies are attached to all models
- php artisan make:policy