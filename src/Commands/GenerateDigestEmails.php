<?php


namespace CodepotatoLtd\Digestive\Commands;


use CodepotatoLtd\Digestive\Tasks\Digestable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class GenerateDigestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digestif:pour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new digest emails';

    /**
     * Execute the command
     *
     * @param  Artisan  $artisan
     * @return int
     */
    public function handle(): int
    {

        if( !\config('digestif.enabled') ){
            $this->error('Zoiks! Digestif is disabled');
            return 0;
        }

        if( !Schema::hasTable('notifications') ){
            $this->error('We can\'t see a notifications table. Perhaps try running "php artisan notifications:table"');
            return 0;
        }

        $this->info('Pouring a small one to wet the whistle.');

        $service = new Digestable($this);
        $service->run();

        return 0;

    }

}