<?php

namespace Modules\Iplaces\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iplaces\Events\Handlers\RegisterIplacesSidebar;

class IplacesServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIplacesSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('places', array_dot(trans('iplaces::places')));
            $event->load('categories', array_dot(trans('iplaces::categories')));
            $event->load('services', array_dot(trans('iplaces::services')));
            $event->load('zones', array_dot(trans('iplaces::zones')));
            // append translations




        });
    }

    public function boot()
    {
        $this->publishConfig('iplaces', 'permissions');
        $this->publishConfig('iplaces', 'settings');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Iplaces\Repositories\PlaceRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentPlaceRepository(new \Modules\Iplaces\Entities\Place());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CachePlaceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iplaces\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\ServiceRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Iplaces\Entities\Service());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheServiceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\ZoneRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentZoneRepository(new \Modules\Iplaces\Entities\Zone());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheZoneDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\ScheduleRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentScheduleRepository(new \Modules\Iplaces\Entities\Schedule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheScheduleDecorator($repository);
            }
        );

// add bindings




    }
}
