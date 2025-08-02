<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public static function sendNotification($route = null, $type = 'info', $title = 'Notification', $message = '')
    {
        $notification = [
            'type'    => $type,
            'title'   => $title,
            'message' => $message
        ];

        if ($route) {
            return redirect()->route($route)->with('notification', $notification);
        }

        return redirect()->back()->with('notification', $notification);
    }
}
