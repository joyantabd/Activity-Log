<?php


namespace App\Helpers;

use App\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Request;


class LogActivity
{


    public static function addToLog($subject)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }


}
