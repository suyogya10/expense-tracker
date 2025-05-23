<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'amount', 'category_id', 'description','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}