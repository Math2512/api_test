<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['title', 'content', 'user_id', 'published_at', 'status', 'deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPublishedAtAttribute($date)
    {
        if($date)
            return Carbon::parse($date)->diffForHumans();
    }

}
