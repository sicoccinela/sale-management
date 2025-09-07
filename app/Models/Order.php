<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id','user_id','order_code','product_name','quantity','price','images','total','verified_by','verified_at','status','invoice_path'
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $today = Carbon::today()->format('Ymd');

            // Cari order terakhir sales ini pada tanggal hari ini
            $lastOrder = self::where('sales_id', $order->sales_id)
                ->whereDate('created_at', Carbon::today())
                ->orderBy('id', 'desc')
                ->first();

            // Tentukan nomor urut
            $nextNumber = 1;
            if ($lastOrder) {
                // ambil nomor terakhir dari kode, misalnya "5-20250906-003"
                $lastNumber = (int) substr($lastOrder->order_code, -3);
                $nextNumber = $lastNumber + 1;
            }

            // Format: SALESID-TANGGAL-NO
            $order->order_code = $order->sales_id
                . '-' . $today
                . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
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
