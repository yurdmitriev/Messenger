<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Chat;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function uploadImage(Request $request)
    {
        $currentMedia = Media::create([
            'content' => Storage::putFile('/public/media', $request->image),
        ]);
        return $currentMedia->id;
    }

    public function userUploadImage(ImageUploadRequest $request, $user_id)
    {
        return User::findOrFail($user_id)->update(["media_id" => $this->uploadImage($request)]);
    }

    public function chatUploadImage(ImageUploadRequest $request, $group_id)
    {
        return Chat::findOrFail($group_id)->update(["media_id" => $this->uploadImage($request)]);
    }

    public function userUnloadImage($user_id)
    {
        $userImage =  User::findOrFail($user_id)->media;
        return url(Storage::url($userImage->content));
    }

    public function chatUnloadImage($user_id)
    {
        $chatImage = Chat::findOrFail($user_id)->media;
        return url(Storage::url($chatImage->content));
    }
}