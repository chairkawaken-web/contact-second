<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContactMessageRequest;
use App\Models\ContactMessage;

class AdminController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->get();
        $total = ContactMessage::count();
        $today = ContactMessage::whereDate('created_at', today())->count();

        return view('admin.index', [
            'messages' => $messages,
            'total' => $total,
            'today' => $today,
        ]);
    }

    public function edit(ContactMessage $message)
    {
        return view('admin.edit', ['contactMessage' => $message]);
    }

    public function update(UpdateContactMessageRequest $request, ContactMessage $message)
    {
        $validated = $request->validated();

        $message->update($validated);

        return redirect()->route('admin.index')->with('status', 'お問い合わせを更新しました。');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.index')->with('status', 'お問い合わせを削除しました。');
    }
}
