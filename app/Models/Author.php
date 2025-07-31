<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
class Author extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'firstname', 'lastname', 'location', 'email', 'password', 'verification_code',
    ];

    protected $table = 'authors';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_code',
    ];




    public function books() {
      return  $this->hasMany(Book::class);
    }
    public function postRequests()  {
        return $this->hasMany(PostRequest::class);
        
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
