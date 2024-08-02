<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'account_number', 'balance','first_name','last_name','is_active','currency'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
