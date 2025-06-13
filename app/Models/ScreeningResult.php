<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningResult extends Model
{

    protected $fillable = [
        'user_id',
        'job_post_id',
        'resume_id',
        'fit_score',
        'matched_keywords',
        'missing_keywords',
        'ai_summary',
    ];

    protected $casts = [
        'matched_keywords' => 'array',
        'missing_keywords' => 'array',
    ];

    //
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function jobPost() {
        return $this->belongsTo(JobPost::class);
    }

    public function resume() {
        return $this->belongsTo(Resume::class);
    }

}
