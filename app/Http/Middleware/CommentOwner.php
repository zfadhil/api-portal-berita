<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        $comment = Comment::findOrFail($request->id);

        if ($comment->user_id != $currentUser->id) {
            return response([
                'message' => 'data not found'
            ], 404);
        }
        return $next($request);
    }
}
