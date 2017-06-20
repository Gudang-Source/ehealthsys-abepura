<?php
    echo $this->renderPartial(
        'application.views.headerReport.headerLaporanTransaksi',
            array(
                'judulLaporan'=>false,
            )
    );
?>
<fieldset>
    <div align="center"><b>DETAIL PRESENSI PEGAWAI</b></div>
    <br>
    <table width="100%">
        <tr>
            <td width="50%" style="vertical-align:top;">
                <table>
                    <tr>
                        <td>No. Finger</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nofingerprint; ?></td>
                    </tr>
                    <tr>
                        <td>Kelompok Pegawai</td>
                        <td>:</td>
                        <td><?php echo isset($modPegawai->kelompokpegawai_id)?$modPegawai->kelompokpegawai->kelompokpegawai_nama:''; ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?php echo  isset($modPegawai->jabatan_id)?$modPegawai->jabatan->jabatan_nama:""; ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nomorindukpegawai; ?></td>
                    </tr>                    
                    <tr>
                        <td>Nama Pegawai</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nama_pegawai; ?></td>
                    </tr>  
                    <?php /*
                    <tr>
                        <td>Shift</td>
                        <td>:</td>
                        <td><?php echo ($modPegawai->shift_id)?$modPegawai->shift->shift_nama:'-'; ?></td>
                    </tr>*/ ?>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td style = "text-align:right;">Hadir</td>
                        <td>:</td>
                        <td><?php  echo $modPegawai->hadir; ?></td>
                    </tr>
                    <tr>
                        <td  style = "text-align:right;">Izin</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->izin; ?></td>
                    </tr>
                    <tr>
                        <td  style = "text-align:right;">Sakit</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->sakit; ?></td>
                    </tr>
                    <tr>
                        <td  style = "text-align:right;">Dinas</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->dinas; ?></td>
                    </tr>
                    <tr>
                        <td  style = "text-align:right;">Alpha</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->alpha; ?></td>
                    </tr>
                    <tr>
                        <td  style = "text-align:right;">Rerata Jam Masuk</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->rerata_jam_masuk; ?></td>
                    </tr>
                    <tr>
                        <td  style = "text-align:right;">Rerata Jam Pulang</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->rerata_jam_keluar; ?></td>
                    </tr>
                    <?php /*<tr>
                        <td >Jumlah Absensi</td>
                        <td>:</td>
                        <td>
                        <?php
                            $count = count($model->printDetailPresensi()->getData());
                            echo $count;
                        ?>
                        </td>
                    </tr>*/ ?>
                </table>            
            </td>
        </tr>
    </table>
</fieldset>
<br>
<?php
      $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'lapegawai-d-grid',
            'dataProvider'=>$model->printDetailPresensi(),
            'template'=>"{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '$row+1',
                    'htmlOptions'=>array('style'=>'text-align: center; width:20px'),
                ),
//                array(
//                    'header'=>'<center>Masuk</center>',
//                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->tglpresensi),true)',
//                ),
                array(
                   'header'=>'Tanggal Presensi',
                   'type'=>'raw',
                   'value'=>'MyFormatter::formatDateTimeForUser($data->datepresensi)',
                ),
                array(
                    'header'=>'<center>Masuk</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),                                
                 array(
                    'header'=>'<center>Terlambat</center>',       
					 'type' => 'raw',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("kelompokjabatan"=>$data->pegawai->kelompokjabatan,"statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),                                             
                     'footer' => $this->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$model->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi.' 00:00:00','tgl_akhir'=>$model->tglpresensi_akhir.' 23:59:59'),true),
                     'footerHtmlOptions' => array('style'=>'text-align: center;'),
                         
                ), 
                 array(
                    'header'=>'<center>Pulang Awal</center>',
					 'type' => 'raw',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("kelompokjabatan"=>$data->pegawai->kelompokjabatan,"statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                     'footer' => $this->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$model->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi.' 00:00:00','tgl_akhir'=>$model->tglpresensi_akhir.' 23:59:59'),true),
                     'footerHtmlOptions' => array('style'=>'text-align: center;'),
                ), 
                 array(
                    'header'=>'<center>Status</center>',
					 'type' => 'raw',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("kelompokjabatan"=>$data->pegawai->kelompokjabatan,"statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ), 
            )
        )
  );
?>
