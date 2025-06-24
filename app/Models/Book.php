<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'Description', 'price', 'file_path', 'admin_id', 'author_id','quantity','category_id',
    ];
    public function author() {
        return  $this->belongsTo(Author::class);
        
    }
    public function category() {
        return  $this->belongsTo(Category::class);
        
    }
    public function admin() {
        return   $this->belongsTo(Admin::class);
        
    }
    public function favoriteByUser()  {
        return  $this->belongsToMany(User::class,'user_books');
    }
    public function requestedByUser(){
        return  $this->belongsToMany(User::class,'requests');
    }
}
