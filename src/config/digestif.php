<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Digestif enabled
    |--------------------------------------------------------------------------
    |
    | Would you like Digestif to run? Expects a boolean
    |
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Digestif email type
    |--------------------------------------------------------------------------
    |
    | In the future there will be more than one email type that digestif can
    | send. For now leave this as 'simple'
    |
    */
    'type' => 'simple',

    /*
    |--------------------------------------------------------------------------
    | Digestif user model class
    |--------------------------------------------------------------------------
    |
    | Please set the model used for your users. Note, they must have the
    | notifiable trait.
    |
    */
    'user_model' => \User::class,

    /*
    |--------------------------------------------------------------------------
    | Notifications table user ID column
    |--------------------------------------------------------------------------
    |
    | Please tell us what column stores the user_id used for notifications
    |
    */
    'notifications_user_id_column' => 'notifiable_id',

];