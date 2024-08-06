<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send($billId){
        $bill = Bill::where('id', $billId)->with('billDetails')->first();
        $data = [
            'title' => 'Mail from '. env('APP_NAME'),
            'bill' => $bill,
        ];

        Mail::send('mail', $data, function($message) use ($bill){
            $message->to($bill->customer_email, $bill->customer_name)
                ->subject('You have a new mail from '. env('APP_NAME'));
        });
    }
}
