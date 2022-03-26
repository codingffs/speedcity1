<?php


namespace App\Helpers;
use Request;
use App\Models\LogActivity as LogActivityModel;


class LogActivity
{


    public static function addToLog($subject, $record_id)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['record_id'] = $record_id;
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
        $LogActivityModel = new LogActivityModel;
        if(request()->get("start_date") != ""){
            $LogActivityModel = $LogActivityModel->where("created_at", '>=', date("Y-m-d", strtotime(request()->get("start_date"))));
        }
        if(request()->get("end_date") != ""){
            $LogActivityModel = $LogActivityModel->where("created_at", '<=', date("Y-m-d", strtotime(request()->get("end_date"))));
        }
    	$LogActivityModel = $LogActivityModel->latest()->get();
        return $LogActivityModel;
    }


}