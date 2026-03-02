<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        
        // Удаляем старую аватарку, если есть
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Загружаем новую
        $imageName = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('public/avatars', $imageName);
        
        $user->avatar = $imageName;
        $user->save();

        return back()->with('success', 'Аватарка обновлена');
    }
}