<?php


namespace CodepotatoLtd\Digestif\Tasks;


use CodepotatoLtd\Digestif\Commands\GenerateDigestEmails;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Digestable
{

    protected $drinks = ['vermouth', 'champagne', 'pastis', 'gin', 'raki', 'fino', 'amontillado', 'dry sherry'];
    protected $awaiting_digest;
    protected $artisan;

    /**
     * Digestable constructor.
     * @param  Artisan  $artisan
     */
    public function __construct(GenerateDigestEmails $artisan)
    {
        $this->awaiting_digest = [];
        $this->artisan = $artisan;
    }

    /**
     *
     */
    public function run()
    {
        // check to see if the table column exists to power our digests
        if (!$this->preFlightChecks()) {
            $this->artisan->error('Digestive requires a migrate, please');
        }

        $user_column = \config('digestif.notifications_user_id_column', 'notifiable_id');

        DB::table('notifications')
            ->orderBy('id', 'asc')
            ->select('*')
            ->where('digested_at', '=', null)
            ->chunk(100, function ($notifications) use ($user_column) {

                foreach ($notifications as $notification) {
                    if (!isset($this->awaiting_digest[$notification->{$user_column}])) {
                        $this->awaiting_digest[$notification->{$user_column}] = 1;
                        DB::table('notifications')->where('id', $notification->id)->update(['digested_at' => now()]);
                        continue;
                    }
                    $this->awaiting_digest[$notification->{$user_column}]++;
                    DB::table('notifications')->where('id', $notification->id)->update(['digested_at' => now()]);
                }
            });

        $this->artisan->info('Preparing a total of ' . count($this->awaiting_digest) . ' digestifs for your users');

        if (count($this->awaiting_digest)) {
            foreach( $this->awaiting_digest as $key => $count ){
                // process the notification for each user

                $model = \config('digestif.user_model');
                $user = (app($model))::find($key);

                if( $user instanceof $model ) {
                    $user->notify(new \App\Notifications\SimpleDigestifEmail($count));
                    $this->artisan->info('Poured a ' . $this->getDigestifName() .  ' for '. $user->email );
                }

            }
            $this->artisan->info('Hic. I think we\'ve had enough for right now. ');
        } else {
            $this->artisan->info('Alas, there was no need for a digestif. More for us! Hic!');
        }

    }

    /**
     * @return bool
     */
    final private function preFlightChecks()
    {
        return Schema::hasColumn('notifications', 'digested_at');
    }

    /**
     * @return array|mixed
     */
    final private function getDigestifName(){
        return Arr::random($this->drinks);
    }

}