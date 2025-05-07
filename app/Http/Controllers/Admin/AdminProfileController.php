<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function create()
    {
        return view('admin.profile');
    }

    public function store(UpdateProfileRequest $request)
    {

        $user = $request->user();

        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $oldAvatarUrl = $user->avatar_url;
            $avatarUrl = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar_url'] = $avatarUrl;
        }

        $updated = $user->update($validated);

        if ($updated && $oldAvatarUrl) 
            Storage::disk('public')->delete($oldAvatarUrl);

        return back()->with('success', 'Data profil berhasil diganti.');
        
    }
}
