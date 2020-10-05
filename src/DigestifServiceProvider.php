<?php

namespace CodepotatoLtd\Digestif;

use CodepotatoLtd\Digestif\Commands\GenerateDigestEmails;
use Illuminate\Support\ServiceProvider;

class DigestifServiceProvider extends ServiceProvider
{


    public function boot(){

        if ($this->app->runningInConsole()) {
            $this->registerCommands()
                ->offerPublishing();
        }

    }

    /**
     * @return $this
     */
    protected function registerCommands(): self
    {
        $this->commands([
            GenerateDigestEmails::class,
        ]);

        return $this;
    }


    /**
     * @return $this
     */
    protected function offerPublishing(): self
    {
        $this->publishes([
            __DIR__.'/config/digestif.php' => config_path('digestif.php'),
        ], 'digestif-config');

        $this->publishes([__DIR__ . '/Notifications/SimpleDigestifEmail.php' => app_path('Notifications/SimpleDigestifEmail.php')], 'digestif-notifications');

        if ($this->app->runningInConsole()) {
            if (!class_exists('AddDigestedToNotificationsTable')) {
                $this->publishes([
                    __DIR__ . '/../stubs/migrations/AddDigestedToNotificationsTable.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_add_digested_to_notifications_table.php'),
                ], 'digestif-migrations');
            }
        }

        return $this;
    }


    public function register(){
        $this->mergeConfigFrom(
            __DIR__ . '/config/digestif.php',
            'digestif'
        );
    }


}