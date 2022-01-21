<?php

/**
 * This file is part of the Lasalle Software library front-end package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2022 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 *
 * @see        https://lasallesoftware.ca
 * @see        https://packagist.org/packages/lasallesoftware/ls-libraryfrontend-pkg
 * @see        https://github.com/LaSalleSoftware/ls-libraryfrontend-pkg
 */

namespace Lasallesoftware\Libraryfrontend;

// LaSalle Software classes
use Lasallesoftware\Libraryfrontend\Commands\SetenvvarsCommand;

// Laravel Framework
use Illuminate\Support\ServiceProvider;



class LibraryfrontendServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * "Within the register method, you should only bind things into the service container.
     * You should never attempt to register any event listeners, routes, or any other piece of functionality within
     * the register method. Otherwise, you may accidentally use a service that is provided by a service provider
     * which has not loaded yet."
     * (https://laravel.com/docs/5.6/providers#the-register-method)
     */
    public function register()
    {
        $this->app->singleton('lslibraryfrontend', function ($app) {
            return new LSLibraryfrontend();
        });

        $this->registerArtisanCommands();
    }

    /**
     * Register the artisan commands for this package.
     */
    protected function registerArtisanCommands()
    {
        $this->app->bind('command.lslibraryfrontend:setenvvars', SetenvvarsCommand::class);
        $this->commands([
            'command.lslibraryfrontend:setenvvars',
        ]);
    }

    /**
     * Bootstrap any package services.
     *
     * "So, what if we need to register a view composer within our service provider?
     * This should be done within the boot method. This method is called after all other service providers
     * have been registered, meaning you have access to all other services that have been registered by the framework"
     * (https://laravel.com/docs/5.6/providers)
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Publish this package's configuration file.
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config/lasallesoftware-libraryfrontend.php' => config_path('lasallesoftware-libraryfrontend.php'),
        ], 'config');
    }
}
