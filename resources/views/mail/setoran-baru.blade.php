<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setoran Sampah Baru</title>
    <style>
        th, td {
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: rgb(129, 245, 198);">
    <h1 style="margin-bottom: 8px; font-size: 21px;">Halo, {{ $user->nama_depan }}!</h1>

    <p>Kamu berhasil melakukan setoran sampah baru.</p>
    <p>Total Harga: <strong>{{ $transaction->total_harga }}</strong></p>
    <p>Total Berat: <strong>{{ $transaction->total_berat }}</strong></p>

    <h3 style="margin-top: 8px;">Detail Transaksi:</h3>
    <table style="width: 100%; margin-bottom: 8px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Sampah</th>
                <th>Berat (kg)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->sampah as $sampah)
                <tr>
                    <td>{{ $sampah->nama }}</td>
                    <td>{{ number_format($sampah->pivot->berat, 2, ',', '.') }} kg</td>
                    <td>Rp {{ number_format($sampah->pivot->harga_subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td>TOTAL</td>
                <td>{{ number_format($transaction->total_berat, 2, ',', '.') }} kg</td>
                <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-bottom: 4px;">Terima kasih!</p>

    <p>Hormat kami,<br>Bank Sampah</p>

</body>

</html>
