<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table='feedbacks';

    protected $fillable = ['title', 'description', 'category_id', 'attachments', 'user_id'];



    // public function setUserAttribute()
    // {
    //     $this->attributes['user_id'] = auth()->user()->id;
    // }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(FeedbackComment::class);
    }

    public function votes()
    {
        return $this->hasMany(FeedbackVote::class);
    }
    public function isVoteBy($user)
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }
    public function checkVoteVal($user)
    {
        return $this->votes()->where('user_id', $user->id)->select('vote');
    }
}
