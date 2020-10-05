<?php

namespace CodepotatoLtd\Digestive;

use Illuminate\Support\ServiceProvider;

class DigestiveServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->publishes([
            __DIR__.'/../config/digestive.php' => config_path('digestive.php'),
        ], 'digestive-config');
    }


    public function register(){
        $this->mergeConfigFrom(
            __DIR__.'/../config/digestive.php',
            'digestive'
        );
    }

}