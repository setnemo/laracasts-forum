<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(string $channel, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReplay([
            'body' => \request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
