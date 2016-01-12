<ol class="row-fluid">
    <div class="span6">
        <li>
            Bagian dengan tanda bintang <span class="required">*</span> harus diisi.
        </li>
        <li>
            Icon <i class="icon-calendar"></i> untuk menentukan tanggal presensi.
        </li>
        <li>
            Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-search icon-white"></i> Cari</div>
            berfungsi untuk mencari.
        </li>
        <li>
            Tombol  <div class="btn btn-danger" name="yt0" type="button"><i class="icon-refresh icon-white"></i> Ulang</div>
            berfungsi untuk melakukan pengisian ulang.
        </li>
        <li>
            Tombol  <?php  echo CHtml::button("connect",array("class"=>'btn btn-primary','style'=>'height:20px;line-height:4px;padding:0px 5px 0px 5px ;')); ?>
            berfungsi untuk melakukan koneksi ke alat Finger Print.
        </li>
        <li>
            Tombol  <?php echo CHtml::button("info",array("class"=>'btn btn-info','style'=>'height:20px;line-height:4px;padding:0px 5px 0px 5px ;')); ?>
            berfungsi untuk melihat status koneksi.
        </li>
    </div>
</ol>