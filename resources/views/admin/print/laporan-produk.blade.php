@extends('admin/print/template')
@section('content')
    <h1>Laporan {{ request()->kategori }} Produk</h1>
    Periode 
    {{ ($_GET['date_start']) ? date('d M Y', strtotime($_GET['date_start'])) : '-' }} 
    s/d  
    {{ ($_GET['date_end']) ? date('d M Y', strtotime($_GET['date_end'])) : '-' }} 
    <br>
    <br>
    @if (request()->kategori === 'penjualan')
    <table class="table table-striped print">
            <thead>
                <tr>
                    <th>Nama Customer</th>
                    <th>Modal</th>
                    <th>Harga Jual</th>
                    <th>Qty</th>
                    <th>Laba</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_modal = 0;
                $total_jual = 0;
                $total_qty = 0;
                $total_laba = 0;
                foreach ($data as $row):
                    $subtotal = ($row->harga_jual - $row->modal) * $row->qty;
                    $modal = $row->modal * $row->qty;
                    $harga_jual = $row->harga_jual * $row->qty;

                    $total_jual = (int) $total_jual + (int) $harga_jual;
                    $total_modal = (int) $total_modal + (int) $modal;
                    $total_laba = (int) $total_laba + (int) $subtotal;
                ?>
                <tr>
                    <td>{{ $row->customer_name }}</td>
                    <td>{{ number_format($modal, 0) }}</td>
                    <td>{{ number_format($harga_jual, 0) }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>{{ number_format($subtotal) }}</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td>{{ number_format($total_modal, 0) }}</td>
                    <td>{{ number_format($total_jual, 0) }}</td>
                    <td></td>
                    <td>{{ number_format($total_laba, 0) }}</td>
                </tr>
            </tfoot>
    </table>
    @elseif (request()->kategori === 'pembelian')
    <table class="table table-striped print">
            <thead>
                <tr>
                    <th>Nama Supplier</th>
                    <th>Harga Normal</th>
                    <th>Discount</th>
                    <th>Qty</th>
                    <th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_harga_normal = 0;
                $total_harga_beli = 0;
                $total_qty = 0;
                $total_laba = 0;

                foreach ($data as $row):
                    $harga_normal = $row->harga_normal * $row->qty;
                    $harga_beli = $row->harga_beli * $row->qty;

                    $total_harga_normal = (int) $total_harga_normal + (int) $harga_normal;
                    $total_harga_beli = (int) $total_harga_beli + (int) $harga_beli;
                ?>
                <tr>
                    <td>{{ $row->supplier_name }}</td>
                    <td>{{ number_format($harga_normal, 0) }}</td>
                    <td>{{ number_format($row->discount, 2) }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>{{ number_format($harga_beli, 0) }}</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td>{{ number_format($total_harga_normal, 0) }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($total_harga_beli, 0) }}</td>
                </tr>
            </tfoot>
    </table>
    @endif
@endsection