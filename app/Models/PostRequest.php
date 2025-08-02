<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostRequest extends Model
{
    protected $fillable=['title','file_path','description','author_id','admin_id','price','category_id','quantity','status','author_name','image_path'];
    public function author() {
        return  $this->belongsTo(Author::class);
    }
    public function category(){
        return  $this->belongsTo(Category::class);
    }
    public function admin(){
        return  $this->belongsTo(Admin::class);
    }
}
