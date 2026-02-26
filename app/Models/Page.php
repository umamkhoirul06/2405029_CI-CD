<?php

namespace App\Models;

use App\Traits\SanitizesHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, SanitizesHtml;

    protected $fillable = ['name', 'slug','content', 'navbar', 'footer', 'user_id'];

    // One to many realtionship -> Users has many Page
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
