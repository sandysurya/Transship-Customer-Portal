<?php

namespace App\Models;

use App\Concerns\HasJwtTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class UserDoc extends Model
{
    use HasFactory;
    use HasJwtTokens;
    use Notifiable;
    protected $table = 'user_document';
    protected $guarded =[];
}
