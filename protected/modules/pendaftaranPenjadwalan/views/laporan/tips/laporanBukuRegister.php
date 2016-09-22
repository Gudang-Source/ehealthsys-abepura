<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<p>
<table border="0" style="padding :none;">
  <tr>
    <td style = "vertical-align:middle;">1. </td>
    <td>Icon <i class="icon-calendar"></i> untuk menentukan tanggal.</td>
  </tr>
  <!--<tr>
    <td>2. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown">
<span class="caret"></span>
</a> dapat di klik dan akan memunculkan pilihan pencetakan melalui PDF, Excel, atau Grafik.</td>
  </tr>-->
  <tr>
    <td style = "vertical-align:middle;">2. </td>
    <td>Gunakan tombol ini  <button class="btn btn-primary" type="button"><i class="entypo-check"></i>
Cari
</button> berfungsi untuk melakukan pencarian data.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle;">3. </td>
    <td>Gunakan tombol ini  <button class="btn btn-danger" type="button"><i class="entypo-arrows-ccw"></i>
Ulang
</button> berfungsi untuk mengulang kembali inputan.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle;">4. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary" >
<i class="entypo-print"></i>
Cetak
</a> untuk mencetak data.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle;">5. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary" >
<i class="icon-book icon-white"></i>
PDF
</a> untuk mencetak data dalam bentuk file pdf.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle;">6. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary" >
<i class="icon-pdf icon-white"></i>
Excel
</a> untuk mencetak data dalam bentuk file excel.</td>
  </tr>
  <?php
    $no = '7.';
    //if (isset($grafik)){
    if (isset($grafik)){
        $grafik=$grafik;
    }else{
        $grafik='ada';
    }
    if ($grafik!='none'){            
        $no='9.';
  ?>
   <tr>
    <td style = "vertical-align:middle;">7. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary" >
<i class="entypo-print"></i>
Grafik
</a> untuk mencetak data dalam bentuk grafik.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle;">8. </td>
    <td>
 
        <ul class="nav nav-tabs">
        <li class="active" type="batang" >
            <a>Batang</a>
        </li>
        <li class="" type="pie" >
            <a>Pie</a>
        </li>
        <li class="" type="garis">
            <a>Garis</a>
        </li>
        </ul>        
    </td>
  </tr>
  <tr>
      <td>&nbsp;</td> 
    <td>
        Navigasi di atas berfungsi untuk menampilkan pencarian dalam bentuk digram batang, pie, atau garis.
    </td>
   </tr>   
   

<?php
    }//}
?>
<tr>
       <td><?php echo $no; ?></td>
       <td>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                 'id'=>'a',
                                 'slide'=>true,
                                 'content'=>array(
                                     'content2'=>array(
                                         'header'=>'&nbsp;',
                                         'isi' => 'Tidak Ada Data',
                                         'active'=>false,
                                         ),
                                 ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                         )); ?>
       </td>
   </tr>
   <tr>
      <td>&nbsp;</td> 
    <td>
        Untuk menampilkan form atau menyembunyikan form, ketika header gambar diatas di klik.
    </td>
   </tr>
</table>
</p>