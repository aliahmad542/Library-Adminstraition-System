<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname', 'lastname', 'location', 'email', 'password', 'verification_code','is_banned',
    ];

   

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];
    

    // public function setPasswordAttribute($password)
    // {
    //     if ($password) {
    //         $this->attributes['password'] = Hash::make($password);
    //     }
    // }


    public function favoritebooks()  {
        return   $this->belongsToMany(Book::class,'user_books');
        
    }
    public function requestedBooks(){
        return  $this->belongsToMany(Book::class,'requests');
    }
}
