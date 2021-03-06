<?php
   namespace App\Providers;

   use Illuminate\Support\ServiceProvider;

   class RepositoryServiceProvider extends ServiceProvider
     {
         protected static $repositories = [
            'user' => [
                \App\Repositories\Contracts\UserInterface::class,
                \App\Repositories\Eloquent\UserRepository::class,
            ],

        ];

        /**
         * Bootstrap the application services.
         *
         * @return void
         */
        public function boot()
        {
            //
        }

        /**
         * Register the application services.
         *
         * @return void
         */
        public function register()
        {
            foreach (static::$repositories as $repository) {
                $this->app->singleton(
                    $repository[0],
                    $repository[1]
                );
            }
        }
}
