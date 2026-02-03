<?php

namespace App\Services;

use App\Helpers\SettingsHelper;
use Illuminate\Http\Request;
use App\Mail\Notification;
use File;
use Mail;

class RequestsService
{
    /**
     * @param Request $request
     * @return string
     */
    public function sendApplication(Request $request): string
    {
        $path = public_path('uploads/attachment');
        $attachment = $request->file('attachment');

        $filename = time() . '.' . $attachment->getClientOriginalExtension();;

        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $attachment->move($path, $filename);

        Mail::to(explode(",", SettingsHelper::getSetting('EMAIL_NOTIFY')))->send(new Notification($path . '/' . $filename));

        return $filename;
    }
}
