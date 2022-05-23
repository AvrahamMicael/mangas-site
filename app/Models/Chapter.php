<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_manga',
        'name',
        'order',
    ];

    public function getPath()
    {
        $page_path = $this->pages[0]->path;
        $file_basename = basename($page_path);

        $chapter_path = str_replace('storage/', '', $page_path);
        return str_replace("/$file_basename", '', $chapter_path);
    }

    public function getPageByOrder(int $order)
    {
        return $this->pages()
                    ->where('order', $order)
                    ->first();
    }

    public function rearrangePagesOrder(int $removed_page_order)
    {
        $this->pages()
                ->where('order', '>', $removed_page_order)
                ->decrement('order');
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'id_manga');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'id_chapter')->orderBy('order');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_chapter');
    }
}
