<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\createRequest;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackComment;
use App\Models\FeedbackVote;
use App\Traits\FileTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class FeedbackController extends Controller
{
    //
    use FileTrait;

    public function index(Request $request){
        if ($request->ajax()) {
            $data = Feedback::with('user','category','votes')->withCount(['votes as upvotes' => function ($query) {
                $query->where('feedback_votes.vote', 1);
            }, 'votes as downvotes' => function ($query) {
                $query->where('feedback_votes.vote', 0);
            }])->orderBy('updated_at','desc')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('user', function($row){
                    return $row->user->name;
                })
                ->addColumn('category_id', function($row){
                    return $row->category['name'];
                })
                ->addColumn('Up Vote', function($row){
                    return $row->upvotes;
                })
                ->addColumn('Down Vote', function($row){
                    return $row->downvotes;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="' . route("feedback.view", ['id' => $row['id']]) . '" class="btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['user','action'])
                ->make(true);
        }

        return view('feedback.index');
    }

    public function create()
    {
        $category = FeedbackCategory::all();
        return view('feedback.create',compact('category'));
    }
    public function view(Feedback $id)
    {
        $id->load(['comments','category','votes'=>function($q){
            return $q->where('feedback_votes.user_id',auth()->user()->id);
        }]);
        $id->loadCount('votes');
        return view('feedback.view',compact('id'));
    }
    public function store(createRequest $request){
        if($request->has('attachments'))
        {
            $getFileName = $this->uploadFile($request);
        }
        $saveData = Feedback::create([
            'title'   =>$request->title,
            'description'   =>$request->description,
            'category_id'   =>$request->category,
            'user_id'       =>auth()->user()->id,
            'attachments'   =>$getFileName??null
        ]);
        return response()->json(['message' => 'Feedback addded successfully'], 200);
    }
    public function voteStatus(Request $request)
    {
        $existingVote = FeedbackVote::where('user_id', auth()->user()->id)
        ->where('feedback_id', $request->feedbackId)
        ->first();

        if ($existingVote) {
            // If a vote record exists, update the 'vote' column
            $existingVote->vote = $request->feedbackVoteStatus;
            $existingVote->save();
        } else {
            // If a vote record doesn't exist, create a new one
            $newVote = new FeedbackVote();
            $newVote->user_id = auth()->user()->id;
            $newVote->feedback_id = $request->feedbackId;
            $newVote->vote = $request->feedbackVoteStatus;
            $newVote->save();
        }
        return response()->json(['message' => 'Feedback Vote Updated successfully'], 200);

    }
    public function comment(Request $request)
    {
        $feedbackId = $request->feedback_id;
        $feedback = Feedback::findOrFail($feedbackId);
        $comment = $request->comment;
        if (!empty($comment)) {
            $feedbackComment = new FeedbackComment([
                'user_id' => auth()->user()->id,
                'content' => $comment,
            ]);

            $feedback->comments()->save($feedbackComment);

            return response()->json(['success' => true,'user'=>auth()->user(),'comments_count'=>$feedback->comments()->count(),'date'=>date_format(Carbon::now(),'d-M-Y')]);
        }

        return response()->json(['success' => false]);
    }
}
