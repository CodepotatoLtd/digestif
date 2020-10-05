<?php

namespace CodepotatoLtd\Digestive;

use Illuminate\Support\ServiceProvider;

class DigestiveServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->publishes([
            __DIR__.'/../config/digestive.php' => config_path('digestive.php'),
        ], 'digestive-config');

        if ($this->app->runningInConsole()) {
            if (!class_exists('AddDigestedToNotificationsTable')) {
                $this->publishes([
                    __DIR__ . '/../stubs/migrations/AddDigestedToNotificationsTable.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_add_digested_at_to_notifications_table.php'),
                ], 'digestive-migrations');
            }
        }

    }


    public function register(){
        $this->mergeConfigFrom(
            __DIR__.'/../config/digestive.php',
            'digestive'
        );
    }

}