<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('PPInfoKunjungan-v', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Laporan <b>Detail Presensi</b></legend>
    <div class="search-form">
        <?php
            $this->renderPartial('daftarHadir/_search',
                array(
                    'model'=>$model,
                )
            );
        ?>
    </div>
    <div class="block-tabel">
        <h6>Tabel Laporan <b>Detail Presensi</b></h6>
        <?php
       $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
                'id'=>'lapegawai-m-grid',
                'dataProvider'=>$model->searchByNofinger(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
				'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Hari Kerja</center>',
                        'start'=>'5',
                        'end'=>'9',
                    ),
                      array(
                        'name'=>'<center>Jam Kerja</center>',
                        'start'=>'10',
                        'end'=>'11',
                    ),
                ),
                'columns'=>array(
                     array(
                         'header' => 'No FP',
                         'value' => '$data->nofingerprint',
                     ),                    
                    'kelompokpegawai.kelompokpegawai_nama',
                    'jabatan.jabatan_nama',					
                    'nomorindukpegawai',
                    'nama_pegawai',  
                    //'ruanganpegawai.ruangan.ruangan_nama',
                   // array(
                      //  'header' => 'Shift',
                      //  'name' => 'shift.shift_nama',
                   // ),                    
                    /* array(
                         'header' => 'Rerata Jam Masuk',                        
                         'value' => function ($data) use ($model){                            
                            //return $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         }
                     ),                  
                    array(
                         'header' => 'Rerata Jam Pulang',
                         'value' => function ($data) use ($model){                            
                            //return $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         }
                        
                     ),              */                       
                    array(
                         'header' => 'Hadir',
                        // 'value' => '$data->getTotalStatusKehadiran(1, $data->pegawai_id)',
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir, $data->kelompokjabatan);
                         }   
                     ),
                    array(
                         'header' => 'Izin',
                        // 'value' => '$data->getTotalStatusKehadiran(2, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_IZIN, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir, $data->kelompokjabatan);
                         } 
                     ),
                    array(
                         'header' => 'Sakit',
                         //'value' => '$data->getTotalStatusKehadiran(3, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_SAKIT, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir, $data->kelompokjabatan);
                         } 
                     ),
                    array(
                         'header' => 'Dinas',
                         //'value' => '$data->getTotalStatusKehadiran(4, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_DINAS, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir, $data->kelompokjabatan);
                         } 
                     ),
                    array(
                         'header' => 'Alpha',
                         //'value' => '$data->getTotalStatusKehadiran(5, $data->pegawai_id)'
                         'value' => function ($data) use ($model){                            
                            return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir, $data->kelompokjabatan);
                         } 
                     ),
                    array(
                         'header' => 'Total Terlambat (Jam)',
                        // 'value'=>'$this->grid->owner->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1),true)',
                         'value' => function ($data) use ($model){                            
                            return $this->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         }   
                     ),
                    array(
                         'header' => 'Total Pulang Awal (Jam)',
                         //'value'=>'$this->grid->owner->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2),true)',
                        'value' => function ($data) use ($model){                            
                            return $this->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                         } 
                     ),                    
                    array(
                       'type'=>'raw',
                       //'value'=>'CHtml::link("<i class=icon-form-detail></i><br>Daftar Hadir", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/laporan/detailLaporanAbsen",array("id"=>"$data->pegawai_id")), array("target"=>"frame_detail", "onclick"=>"$(\'#detailAbsen\').dialog(\'open\');", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Detail Daftar Hadir"))',
                        'value' => function ($data) use ($model){
                         return CHtml::link("<i class=icon-form-detail></i><br>Daftar Hadir", Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/detailLaporanAbsen',array("id"=>$data->pegawai_id,"tgl_awal"=>$model->tglpresensi,"tgl_akhir"=>$model->tglpresensi_akhir)), array("target"=>"frame_detail", "onclick"=>"$('#detailAbsen').dialog('open');", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Detail Daftar Hadir"));
                        },
                       'htmlOptions'=>array('style'=>'text-align: center')
                    ),
                ),
                'afterAjaxUpdate'=>'
                    function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                }',
            )
        );
        ?>
    </div>
    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
            array(
                'id'=>'detailAbsen',
                'options'=>array(
                    'title'=>'Detail Absen Pegawai',
                    'autoOpen'=>false,
                    'minWidth'=>500,
                    'width'=>900,
                    'modal'=>true,
                ),
            )
        );
    ?>
    <iframe src="" height="500" width="100%"  name="frame_detail"></iframe>
    <?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintDetailPresensi');
        $this->renderPartial('daftarHadir/_footer', array('urlPrint'=>$urlPrint));
    ?>
</div>