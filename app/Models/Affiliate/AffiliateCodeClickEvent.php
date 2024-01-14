<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateCodeClickEvent extends Model
{
    use HasFactory;

    // No timestamps
    public $timestamps = false;

    // Fillable
    protected $fillable = [
        'affiliate_code_id',
    ];
}
