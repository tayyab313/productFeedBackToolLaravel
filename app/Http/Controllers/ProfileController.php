<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function userListing(Request $request){
        if ($request->ajax()) {
            $data = Feedback::with('user','category','votes')->withCount(['votes as upvotes' => function ($query) {
                $query->where('feedback_votes.vote', 1);
            }, 'votes as downvotes' => function ($query) {
                $query->where('feedback_votes.vote', 0);
            }])->where('user_id',auth()->user()->id)->orderBy('updated_at','desc')->get();
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
}
