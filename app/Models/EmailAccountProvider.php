<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAccountProvider extends Model
{
    use HasFactory;

    protected $table = 'email_account_providers';


    protected $fillable = [
        'name',
        'smtp_server',
        'smtp_port',
        'username',
        'password',
        'encryption',
    ];

    protected $hidden = ['password'];
}
