<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageStoreRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームを表示
     */
    public function showForm()
    {
        return view('contact.form');
    }

    /**
     * お問い合わせを送信
     */
    public function submit(ContactMessageStoreRequest $request)
    {
        $validated = $request->validated();

        ContactMessage::create($validated);

        return view('contact.thanks', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);
    }
}
