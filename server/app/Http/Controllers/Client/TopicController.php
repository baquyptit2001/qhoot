<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\TopicRequest;
use App\Http\Resources\Topic\TopicResource;
use Intervention\Image\Facades\Image;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $topics = Topic::where('user_id', $user->id)->get();
        return response()->json([
            'topics' => TopicResource::collection($topics),
            'message' => 'Topics retrieved successfully',
            'status_code' => 200,
        ]);
    }

    public function create(TopicRequest $request)
    {
        $user = $request->user();
        $image = $request->get('image');
        Log::channel('debug')->info($image);
        $image_name = $user->id . '_' . time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Image::make($request->get('image'))->save(public_path('images/topics/').$image_name);
        $topic = Topic::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => $user->id,
            'image' => 'images/topics/' . $image_name,
        ]);
        $topic->save();
        return response()->json(
            [
                'topic' => TopicResource::make($topic),
                'message' => 'Topic created successfully',
                'status_code' => 201,
            ]
        );
    }

    public function show(Request $request, Topic $topic)
    {
        $user = $request->user();
        if ($topic->user_id != $user->id) {
            return response()->json([
                'message' => 'You are not authorized to view this topic',
                'status_code' => 401,
            ]);
        }
        return response()->json([
            'topic' => TopicResource::make($topic),
            'message' => 'Topic retrieved successfully',
            'status_code' => 200,
        ]);
    }
}
