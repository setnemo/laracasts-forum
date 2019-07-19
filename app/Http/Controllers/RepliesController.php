<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param string $channel
     * @param Thread $thread
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(string $channel, Thread $thread): RedirectResponse
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReplay([
            'body' => \request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
