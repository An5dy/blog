<?php

namespace App\Listeners;

use Log;
use DateTime;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Events\QueryExecuted;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if (config('app.env') == 'local') {
            $sql = str_replace("?", "'%s'", $event->sql);
            $bindings = $event->bindings;
            foreach ($bindings as $key => $binding) {
                if ($binding instanceof DateTime) {
                    $bindings[$key] = $binding->format('Y-m-d H:i:s');
                }
            }
            $log = vsprintf($sql, $bindings);
            Log::info($log);
        }
    }
}
