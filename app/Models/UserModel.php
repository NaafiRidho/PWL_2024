<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;
use Illuminate\Foundation\Auth\User as Authenticatable; //tambahkan jika ingin melakukan autentiviasi
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'name', 'password'];

    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    //relasi ke table level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_kode;
    }

    //cek apakah user memiliki role tertentu
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    //mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
    public function getRouteKeyName()
    {
        return 'user_id';
    }
}
