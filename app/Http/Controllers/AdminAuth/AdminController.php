<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackComment;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    //
    use FileTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Feedback::with('user', 'category', 'votes')->withCount(['votes as upvotes' => function ($query) {
                $query->where('feedback_votes.vote', 1);
            }, 'votes as downvotes' => function ($query) {
                $query->where('feedback_votes.vote', 0);
            }])->orderBy('updated_at', 'desc')->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('category_id', function ($row) {
                    return $row->category['name'];
                })
                ->addColumn('Up Vote', function ($row) {
                    return $row->upvotes;
                })
                ->addColumn('Down Vote', function ($row) {
                    return $row->downvotes;
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <a href="' . route("admin.feedback.view", ['id' => $row['id']]) . '" class="btn btn-success btn-sm">V</a>
                    <a href="' . route("admin.feedback.edit", ['id' => $row['id']]) . '" class="btn btn-primary btn-sm">E</a>
                    <button type="button" url="' . route("admin.feedback.comment.delete", ['id' => $row['id']]) . '" class="btn btn-danger btn-sm delete-record">Delete</button>';

                    return $btn;
                })
                ->rawColumns(['user', 'action'])
                ->make(true);
        }

        return view('admin.feedback.index');
    }

    public function view(Feedback $id)
    {
        $id->load(['comments', 'category', 'votes' => function ($q) {
            return $q->where('feedback_votes.user_id', auth()->user()->id);
        }]);
        $id->loadCount('votes');
        return view('admin.feedback.view', compact('id'));
    }

    public function edit(Feedback $id)
    {
        $id->load('category');
        $category = FeedbackCategory::all();
        return view('admin.feedback.edit', compact('id', 'category'));
    }
    public function update(Request $request)
    {
        if ($request->has('attachments')) {
            $getFileName = $this->uploadFile($request);
        }
        $feedBack = Feedback::find($request['id']);
        $updateData = $feedBack->update([
            'title'   => $request->title,
            'description'   => $request->description,
            'category_id'   => $request->category,
            'user_id'       => auth()->user()->id,
            'attachments'   => $getFileName ?? $feedBack['attachments']
        ]);
        return response()->json(['message' => 'Feedback updated successfully'], 200);
    }
    public function destroy(Feedback $id)
    {
        // $id->comments()->detach();
        // $id->votes()->detach();

        // Delete related comments
        foreach ($id->comments as $comment) {
            $comment->delete();
        }
        foreach ($id->votes as $comment) {
            $comment->delete();
        }

        // Delete the feedback
        $id->delete();
        return response()->json(['message' => 'Feedback delete successfully'], 200);
    }
    public function commentDestroy(FeedbackComment $id)
    {

        $id->delete();
        return response()->json(['message' => 'Feedback Comment delete successfully'], 200);
    }
}
