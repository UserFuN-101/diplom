<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'topic' => 'required|string'
        ]);

        $user = Auth::user();
        
        // Проверяем, не добавлял ли уже эту тему
        $exists = Favorite::where('user_id', $user->id)
                         ->where('topic', $request->topic)
                         ->exists();

        if (!$exists) {
            Favorite::create([
                'user_id' => $user->id,
                'topic' => $request->topic
            ]);
        }

        return response()->json(['success' => true]);
    }
}