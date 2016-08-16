Bagian dengan tanda bintang <span class="required">*</span> harus diisi.
<br>
<ol class="row-fluid">     
    <div class="span6">
        
        <li>
            Icon <i class="icon-calendar"></i> untuk menentukan tanggal transaksi.
        </li>      
        <li>
            Icon <span class="add-on"><a id="" href="#"><i class="icon-list"></i><i class="icon-search"></i></a></span> 
            berfungsi untuk mencari dan menampilkan daftar data sesuai yang diketikan serta menampilkan dialog box jika diklik.
        </li>
        <li>
            Icon <?php echo CHtml::checkBox('checkbox',true); ?>
            berfungsi untuk pilih / tidak pilih data.
        </li>
         <li>
            Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-ok icon-white"></i> Simpan</div>
            berfungsi untuk menyimpan.
        </li>
    </div>
    <div class="span6">
       
        <li>
            Tombol  <div class="btn btn-danger" name="yt0" type="button"><i class="icon-refresh icon-white"></i> Ulang</div>
            berfungsi untuk melakukan transaksi ulang.
        </li>
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i></div> dapat digunakan (sedang aktif)
            sedangkan tombol <div class="btn btn-info" name="yt0" type="button" disabled="disabled"><i class="icon-print icon-white"></i></div> tidak dapat digunakan (tidak aktif).
        </li>
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i> Print</div>
            berfungsi untuk mencetak transaksi.
        </li>
    </div>
</ol>
