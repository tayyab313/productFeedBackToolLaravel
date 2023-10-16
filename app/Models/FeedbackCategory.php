<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    use HasFactory;

    protected $table = 'feedback_categories';
    protected $fillable = ['name'];

    // Define the relationship with the Feedback model
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'category_id');
    }
}
