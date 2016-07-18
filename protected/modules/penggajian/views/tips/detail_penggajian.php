<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<p>
<table border="0" style="padding :none;">
  <tr>
    <td>1. </td>
    <td>Icon <i class="icon-calendar"></i><i class="icon-time"></i> berfungsi untuk menentukan tanggal dan waktu.</td>
  </tr>
  <tr>
      <td>2. </td>
        <td>Gunakan icon ini <span class="add-on">
        <?php 
            $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons'=>array(                    
                    array('label'=>'', 'items'=>array(
                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'',),
                        array('label'=>'EXCEL','icon'=>'icon-pdf', 'url'=>'',),
                        array('label'=>'PRINT','icon'=>'icon-print', 'url'=>'',),
                    )),       
                ),
        //        'htmlOptions'=>array('class'=>'btn')
            )); 
        ?>	
        </span> berfungsi untuk memilih jenis printout yang ingin di cetak.</td>
  </tr>
       <td>3. </td>
        <td>Gunakan tombol ini  <button class="btn btn-primary" name="yt0" onkeypress="return formSubmit(this,event)" type="submit">
<i class="icon-ok icon-white"></i>
Simpan
</button>
Cari
</button> berfungsi untuk menyimpan</td>
  <tr>
    <td>4. </td>
    <td>Gunakan tombol ini <a class="btn btn-danger" href="/simrs/index.php?r=rawatInap/pasienRawatInap/formTindakLanjutDariPasienRI">
<i class="icon-refresh icon-white"></i>
Ulang
</a> untunk mengulang kembali inputan.</td>
  </tr>
</table>
</p>

