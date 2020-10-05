<?php


namespace CodepotatoLtd\Digestive;


use CodepotatoLtd\Digestive\Notifications\SimpleDigestEmail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Digestable
{

    protected $awaiting_digest;
    protected $artisan;

    public function __construct(Artisan $artisan)
    {
        $this->awaiting_digest = [];
        $this->artisan = $artisan;
    }

    public function run()
    {
        // check to see if the table column exists to power our digests
        if (!$this->preFlightChecks()) {
            $this->artisan->error('Digestive requires a migrate, please');
        }

        DB::table('notifications')
            ->select('*')
            ->where('digested_at', '=', null)
            ->chunk(100, function ($notifications) {

                foreach ($notifications as $notification) {
                    if (!isset($this->awaiting_digest[$notification->user_id])) {
                        $this->awaiting_digest[$notification->user_id] = 1;
                        continue;
                    }
                    $this->awaiting_digest[$notification->user_id]++;
                }
            });

        $this->artisan->info('Preparing a total of ' . count($this->awaiting_digest) . ' digestives for your users');

        if (count($this->awaiting_digest)) {
            foreach( $this->awaiting_digest as $key => $count ){
                // process the notification for each user

                $model = config('digestive.user_model');
                $user = $model::find($key);

                if( $user instanceof $model ) {
                    $user->notify(new SimpleDigestEmail($count));
                    $this->artisan->info('Poured a  for '. $user->email );
                }

            }
        }

    }

    final private function preFlightChecks()
    {
        return Schema::hasColumn('notifications', 'digested_at');
    }

}