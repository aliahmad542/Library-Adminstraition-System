<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Admin as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
class Admin extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'location', 'email', 'password', 'verification_code',
    ];
    protected $table = 'admins';
    protected $guarded = [];
   

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_code',
    ];
    use HasApiTokens, HasFactory, Notifiable;


    public function books() {
        return  $this->hasMany(Book::class);
        
    }
    public function postRequests() {
        return  $this->hasMany(PostRequest::class);
        
    }
}
