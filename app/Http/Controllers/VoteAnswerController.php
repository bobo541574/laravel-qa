<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function __invoke(Answer $answer)
    {
        $vote = (int) request()->vote;

        $votesCount = auth()->user()->voteAnswer($answer, $vote);
        // dd($votesCount);
        if (request()->expectsJson()) {
            return response()->json([
                'message'       => 'Thanks for the feedback',
                'votesCount'    => $votesCount
            ]);
        }

        return back();
    }
}