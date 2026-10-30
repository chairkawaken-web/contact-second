<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

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
}
