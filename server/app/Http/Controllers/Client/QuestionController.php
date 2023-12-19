<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Topic\TopicResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Topic;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $topic = Topic::where('user_id', $user->id)->get();
        return response()->json([
            'topics' => TopicResource::collection($topic),
            'message' => 'Topics retrieved successfully',
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $topic = Topic::find($request->topic_id);
        $question = new Question();
        $question->description = $request->description;
        $question->topic_id = $request->topic_id;
        $question->user_id = $user->id;
        $question->sort_order = $request->sort_order;
        $question->save();
        $answers = array();
        foreach ($request->answers as $key => $answer) {
            $save = new Answer();
            Log::channel('debug')->info($answer);
            $save->description = $answer['description'];
            $save->question_id = $question->id;
            $save->is_correct = $key == $request->correct_answer ? true : false;
            $save->save();
            $answers[] = $save;
        }
        return response()->json([
            'question' => $question,
            'answer' => $answers,
            'user' => $request->user(),
            'message' => 'Question created successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $question = Question::find($id);
        if ($question->user_id != $user->id) {
            Log::channel('debug')->info($user->id);
            Log::channel('debug')->info($question->user_id);
            Log::channel('debug')->info($question);
            return response()->json([
                'message' => 'You are not authorized to update this question',
                'status_code' => 401,
            ]);
        }
        $question->description = $request->description;
        $question->topic_id = $request->topic_id;
        $question->user_id = $user->id;
        $question->sort_order = $request->sort_order;
        $question->save();
        $answers = array();
        foreach ($request->answers as $key => $answer) {
            $save = Answer::find($answer['id']);
            Log::channel('debug')->info($answer);
            $save->description = $answer['description'];
            $save->question_id = $question->id;
            $save->is_correct = $key == $request->correct_answer ? 1 : 0;
            $save->save();
            $answers[] = $save;
        }
        return response()->json([
            'question' => $question,
            'answer' => $answers,
            'user' => $request->user(),
            'message' => 'Question updated successfully',
        ]);
    }
}
