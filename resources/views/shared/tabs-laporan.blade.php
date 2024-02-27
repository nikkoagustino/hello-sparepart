<div class="row mt-3 laporan-nav">
    <div class="col-3">
        <a href="{{ url('admin/laporan') }}" class="btn {{ (Str::contains(request()->url(), 'general')) ? 'active' : ''; }}">GENERAL</a>
    </div>
    <div class="col-3">
        <a href="{{ url('admin/laporan/penjualan') }}" class="btn {{ (Str::contains(request()->url(), 'penjualan')) ? 'active' : ''; }}">PENJUALAN</a>
    </div>
    <div class="col-3">
        <a href="{{ url('admin/laporan/pembelian') }}" class="btn {{ (Str::contains(request()->url(), 'pembelian')) ? 'active' : ''; }}">PEMBELIAN</a>
    </div>
    <div class="col-3">
        <a href="{{ url('admin/laporan/laba-rugi') }}" class="btn {{ (Str::contains(request()->url(), 'laba-rugi')) ? 'active' : ''; }}">LABA RUGI</a>
    </div>
    <div class="col-3">
        <a href="{{ url('admin/laporan/produk') }}" class="btn {{ (Str::contains(request()->url(), 'produk')) ? 'active' : ''; }}">PRODUK</a>
    </div>
    <div class="col-3">
        <a href="{{ url('admin/laporan/jenis-barang') }}" class="btn {{ (Str::contains(request()->url(), 'jenis-barang')) ? 'active' : ''; }}">JENIS BARANG</a>
    </div>
    <div class="col-3">
        <a href="{{ url('admin/laporan/customer') }}" class="btn {{ (Str::contains(request()->url(), 'customer')) ? 'active' : ''; }}">CUSTOMER</a>
    </div>
</div>