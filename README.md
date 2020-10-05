# 🥃 Digestif - Gloriously simple digest emails for Laravel

<a href="https://packagist.org/packages/codepotatoltd/digestif"><img src="https://poser.pugx.org/codepotatoltd/digestif/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/codepotatoltd/digestif"><img src="https://poser.pugx.org/codepotatoltd/digestif/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/codepotatoltd/digestif"><img src="https://poser.pugx.org/codepotatoltd/digestif/license.svg" alt="License"></a>

## What is this?
Using the database driver for laravel notifications is great, but then you need a way to communicate to your users if they've not logged in for a while. With Digestif we'll handle the digest emails for you. 

## Installation instructions
1. Install using ```composer require codepotatoltd/digestif```
2. Ensure you have a notifications table in your database, otherwise run ```php artisan notifications:table``` and then ```php artisan migrate```
2. Publish Digestif's config, notification and database migration using ```php artisan vendor:publish``` and select the DigestifServiceProvider option.
4. Run ```php artisan migrate``` to add the "digested_at" column
5. Open the digestif.php config file and update the User model that your app uses.
6. Open your App/Console/Kernel.php and in the scheduler define how often you would like the digest process to run. E.g. ```$schedule->command('digestif:pour')->hourly();``` Alternatively, setup your own cron process to run ```php artisan digestif:pour``` when you would like emails to be sent.
7. Sit back and let Digestif handle the rest 🥃

## Customisation options
Using the vendor:publish method you have full control of both the notification that we use behind the scenes. You can find this in your App/Notifications folder and you're welcome to tweak this to something that works better for you. 


## Roadmap
- [x] ~~Simple digest email~~ 
- [ ] Unsubscribing from the digest email
- [ ] Itemised digest emails as well as our simple counter version
- [ ] User controls to set the frequency of their digests 
