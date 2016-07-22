<ol class="row-fluid">
    <div class="span6">
        <li>
            Icon  <i class="icon-form-detail"></i>
            berfungsi untuk melihat penggajian pegawai secara detail.
        </li>
        <?php
            if (isset($gaji)):
                if ($gaji==true)
                {
        ?>
            <li>
            Icon  <i class="icon-form-bayar"></i>
            berfungsi untuk melanjutkan ke halaman transaksi pembayaran gaji.
            </li>
        <?php
                }
            endif;
        ?>
        
        <li>
            Icon  <i class="icon-calendar"></i>
            berfungsi untuk menentukan tanggal.
        </li>
        <li>
            Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-search icon-white"></i> Cari</div>
            berfungsi untuk mencari.
        </li>
        <li>
            Tombol  <div class="btn btn-danger" name="yt0" type="button"><i class="icon-refresh icon-white"></i> Ulang</div>
            berfungsi untuk mengulang kembali pencarian.
        </li>
    </div>
</ol>