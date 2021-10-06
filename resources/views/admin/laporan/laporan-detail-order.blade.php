<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<style>
    .footer-report {
        position: absolute;
        bottom: 0;
        right: 30px;
    }

</style>
<p class=" dotted" style="border-style: dotted;"></p>
<h3 class="mb-4 text-black-50">{{ $invoice->invoice }}</h3>

<body style=" font-size: 18px;">
    <table class="table table-bordered">
        <tr>
            <td width="25%">
                Tanggal Pembelian
            </td>
            <td width="1%">:</td>
            <td>{{ dateID($invoice->created_at) }}</td>
        </tr>
        <tr>
            <td width="25%">
                No. Invoice
            </td>
            <td width="1%">:</td>
            <td>{{ $invoice->invoice }}</td>
        </tr>
        <tr>
            <td width="25%">
                Nama Pembeli
            </td>
            <td width="1%">:</td>
            <td>{{ $invoice->customer->name }}</td>
        </tr>
        <tr>
            <td width="25%">
                Email
            </td>
            <td width="1%">:</td>
            <td>{{ $invoice->customer->email }}</td>
        </tr>
        <tr>
            <td>No WA Pembeli</td>
            <td>:</td>
            <td>{{ $invoice->phone }}</td>
        </tr>
        <tr>
            <td> Provinsi </td>
            <td>:</td>
            <td>{{ $invoice->provinsi->name }}</td>
            </td>
        </tr>
        <tr>
            <td> Kab / Kota</td>
            <td>:</td>
            <td>{{ $invoice->kota->name }}</td>
        </tr>
        <tr>
            <td>Alamat lengkap Pengiriman</td>
            <td>:</td>
            <td>
                {{ $invoice->address }}
            </td>
        </tr>
        <tr>
            <td>Catatan Pembeli</td>
            <td>:</td>
            <td>
                {{ $invoice->note ? $invoice->note : '-' }}

            </td>
        </tr>
        <tr>
            <td>Total Pembelian</td>
            <td>:</td>
            <td>{{ moneyFormat($invoice->grand_total) }}</td>
        </tr>
    </table>
</body>
<p class=" dotted" style="border-style: dotted;"></p>

</html>
