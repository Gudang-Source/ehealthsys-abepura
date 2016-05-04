
Bagian dengan tanda bintang <span class="required">*</span> harus diisi.
<table>
    <tr>
        <td style = "vertical-align: middle;">1.</td>
        <td>Icon <i class="icon-calendar"></i> berfungsi untuk menentukan tanggal.</td>
    </tr>
    <tr>
        <td  style = "vertical-align: middle;">2.</td>
        <td>Icon <i class="icon-list"></i><i class="icon-search"></i> berfungsi untuk menampilkan list data sesuai dengan yang diketikkan dan menampilkan dialog box, ketika icon di klik.</td>
    </tr>
    <tr>
        <td  style = "vertical-align: middle;">3.</td>
        <td> Tombol  <i class="icon-plus"> </i> / <i class="icon-minus"> </i>
            berfungsi untuk menambahkan list data baru / mengurangi data baru.</td>
    </tr>
    <tr>
        <td  style = "vertical-align: middle;">4.</td>
        <td><div class = "span3">
            <?php 
                $this->Widget('ext.bootstrap.widgets.BootAccordion',array(                    
                    'content'=>array(
                        'content-datariwayat'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)")).'',
                                'isi'=>'Isi',
                                'active'=>false,
                                ),   
                        ),
                )); 
                ?>
            </div>
            berfungsi untuk menyembunyikan atau menampilkan data/form.
        </td>
    </tr>
    <tr>
        <td  style = "vertical-align: middle;">5.</td>
        <td>Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-ok icon-white"></i> Simpan</div>
            berfungsi untuk menyimpan.
        </td>
    </tr>
    <tr>
        <td  style = "vertical-align: middle;">6.</td>
        <td>Tombol  <div class="btn btn-danger" name="yt0" type="button"><i class="icon-refresh icon-white"></i> Ulang</div>
            berfungsi untuk melakukan pembayaran ulang.
        </td>
    </tr>
</table>
