<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory, Searchable;

    protected $table = 'news_posts';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    //protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static function relatedNews($news)
    {
        $search = explode(',', $news->meta_keywords);
        $search = array_merge($search, explode(',', $news->meta_description));
        $filter = NewsPost::where([
            ['id', '!=', $news->id],
            ['status', 'Y']
        ])
        ->where(function ($query) use ($search, $news) {
            $query->where('category_id', $news->category_id);
            foreach($search as $keyword)
            {
                $query->orWhere('name', 'like', '%' . $keyword . '%');
                $query->orWhere('meta_title', 'like', '%' . $keyword . '%');
                $query->orWhere('meta_keywords','like', '%' . $keyword . '%');
                $query->orWhere('meta_description','like', '%' . $keyword . '%');
            }
        })->limit(6)->get();
        return $filter;
    }
}
