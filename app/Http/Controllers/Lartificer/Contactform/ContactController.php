<?php namespace App\Http\Controllers\Lartificer\Contactform;

class ContactController extends \Lartificer\Contactform\Http\Controllers\ContactController {
    public function sendMail() {
        $data = \Input::except("csrf_token");
        \Mail::send('contactform::mailbody', $data, function ($message) use ($data) {
            $message->to('p.mohr@sopamo.de', 'John Smith')
                    ->from($data['email'], $data['firstname'] . ' ' . $data['lastname'])
                    ->subject('A new email');
        });
    }
    
}