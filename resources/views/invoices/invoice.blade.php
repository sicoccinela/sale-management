<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 26px;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .content {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
        }
        .content p {
            font-size: 14px;
            margin: 6px 0;
        }
        .content b {
            color: #2c3e50;
        }
        .images {
            margin-top: 20px;
        }
        .images h4 {
            margin: 0 0 40px 0;
            font-size: 16px;
            color: #2c3e50;
            font-weight: bold;
            display: block;
        }
        .image-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .image-grid img {
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 400px;
            height: auto;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice #{{ $order->id }}/{{ $order->order_code }}</h2>
        <p>Sales: <b>{{ $order->sales->name }}</b></p>
    </div>

    <div class="content">
        <p><b>Product:</b> {{ $order->product_name }}</p>
        <p><b>Price:</b> Rp{{ number_format($order->price, 0, ',', '.') }}</p>
        <p><b>Quantity:</b> {{ $order->quantity }}</p>
        <p><b>Status:</b> {{ $order->status }}</p>
        <hr>
        <p style="font-size:16px; font-weight:bold; color:#2c3e50;">
            Total: Rp{{ number_format($order->total ?? $order->price * $order->quantity, 0, ',', '.') }}
        </p>
    </div>

    <div class="images">
        <h4 style="clear:both;">
            Gambar Produk:
        </h4>
        @if ($order->images && count($order->images) > 0)
            <div class="image-grid">
                @foreach ($order->images as $img)
                    <img src="{{ public_path('storage/' . $img) }}" alt="Product Image">
                @endforeach
            </div>
        @else
            <p><i>Tidak ada gambar produk.</i></p>
        @endif
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja bersama kami.</p>
        <p><i>Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan.</i></p>
    </div>
</body>
</html>
