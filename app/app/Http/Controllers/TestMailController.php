<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class TestMailController extends Controller
{
    public function sendTest()
    {
        Mail::to('test@example.com')
    ->send(new TestMail());

    return '送信完了';
    }   
}
