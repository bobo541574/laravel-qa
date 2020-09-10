<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;

    protected $fillable = ['body', 'user_id'];

    protected $appends = [
        'created_date', 'body_html', 'is_best'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return $this->bodyHtml();
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(0, 250);
    }

    public function excerpt($start = 0, $end = null)
    {
        if ($end == null) {
            return strip_tags($this->bodyHtml());
        }
        return substr(strip_tags($this->bodyHtml()), $start, $end);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }
}