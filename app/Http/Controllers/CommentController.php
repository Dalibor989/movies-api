<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Movie $movie, CreateCommentRequest $request)
    {
        $data = $request->validated();

        $comment = new Comment();
        $comment->content = $data['content'];
        $comment->user()->associate(Auth::user());
        $comment->movie()->associate($movie);
        $comment->save();

        return response()->json($comment);
    }
}
