<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\EmailContacts;

class MailController extends Controller
{
    public function contacts(Request $request)
    {

        $data = [
            'subject' => 'Обращение со страницы контакты',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];
//        return response()->json($request);
//        $data = [
//            'subject' => 'Обращение со страницы контакты',
//            'nameProduct' => 'nameProduct',
//        ];


        try {
            Mail::to('arhipov035@gmail.com')->send(new EmailContacts($data));
            return response()->json(['Great check you ']);
        }catch (Exception $th) {
            return response()->json(['Sorry Error']);
        }
    }
}
