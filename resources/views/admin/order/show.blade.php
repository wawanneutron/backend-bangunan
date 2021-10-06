@extends('layouts.app-dashboard', [
'title' => 'Orders'
])

@section('content')
    <div class="container-fluid">
        <div class="row" id="app">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Data Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <div class="card border-0 shadow">
                    <div class=" card-header">
                        <h6 class="m6 font-weight-bold text-uppercase"><i class="fas fa-shopping-cart mr-3"></i>detail order
                        </h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.cetak.detail.order', $invoice->id) }}" class=" btn btn-primary mb-4"><i
                                class="fas fa-file-pdf mr-2"></i>Cetak pdf</a>
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
                                <td>No. Telp/WA</td>
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
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>{{ $invoice->status }}</td>
                            </tr>
                        </table>
                        <div class="row">
                            <div class="col-md-4">
                                @if ($invoice->status == 'payment-success')
                                    <label>Update Status</label>
                                    <form action="{{ route('admin.order.update', $invoice->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class=" form-control" name="status">
                                            <option disabled>--Pilih Status--</option>
                                            <option value="process">Barang Diproses</option>
                                        </select>
                                        <button type="submit" class="mt-4 btn btn-primary">Update</button>
                                    </form>
                                @endif

                                @if ($invoice->status == 'process')
                                    <label>Update Status</label>
                                    <form action="{{ route('admin.order.update', $invoice->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class=" form-control" name="status">
                                            <option disabled>--Pilih Status--</option>
                                            <option value="shipping">Barang Dikirim</option>
                                        </select>
                                        <button type="submit" class="mt-4 btn btn-primary">Update</button>
                                    </form>
                                @endif

                                @if ($invoice->status == 'shipping')
                                    <label>Update Status</label>
                                    <form action="{{ route('admin.order.update', $invoice->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class=" form-control" name="status">
                                            <option disabled>--Pilih Status--</option>
                                            <option value="success">Pengiriman success</option>
                                            <input type="text" hidden value=" {{ $invoice->resi }} " name="resi"
                                                class=" form-control mt-3" placeholder="input resi">
                                        </select>
                                        <button type="submit" class="mt-4 btn btn-primary">Update</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 rounded shadow mt-4">
                    <div class="card-body">
                        <h5><i class="fa fa-shopping-cart mr-3 text-uppercase"></i> Detail Order</h5>
                        <hr>
                        <table class=" table"
                            style="border-style: solid !important;border-color: rgb(198, 206, 214) !important;">
                            <tbody>
                                @foreach ($invoice->orders()->get() as $product)
                                    <tr style="background: #edf2f7;">
                                        <td class="b-none" width="25%">
                                            <div class="wrapper-image-cart">
                                                <img src="{{ $product->gallery->image }}"
                                                    style="width: 100%;border-radius: .5rem">
                                            </div>
                                        </td>
                                        <td class="b-none text-right">
                                            <p class="m-0 font-weight-bold">{{ moneyFormat($product->price) }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
