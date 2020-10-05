<?php


namespace CodepotatoLtd\Digestive\Commands;


use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;

class GenerateDigestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digestive:pour';

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
    public function handle(Artisan $artisan): int
    {

        $artisan->setCommand($this);

        $artisan->note('Pouring a small one to wet the whistle.');



        return 0;

    }

}