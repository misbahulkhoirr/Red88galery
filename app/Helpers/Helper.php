<?php

namespace App\Helpers;

use App\Models\Logs;
use Illuminate\Support\Facades\DB;

class Helper
{

    public static function getLocations()
    {

        $locations = DB::table('locations')->orderBy('name', 'ASC')->get();

        return $locations;
    }

    public static function createLogs($activity)
    {
        // dd($activity);
        $log = [];
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['activity'] = $activity;
        Logs::create($log);
    }
}
