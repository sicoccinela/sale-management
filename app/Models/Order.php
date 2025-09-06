<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id','user_id','product_name','quantity','price','images','total','verified_by','verified_at','status','invoice_path'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }


    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
