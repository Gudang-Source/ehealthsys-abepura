
<?php
$this->breadcrumbs=array(
	'Kppresensi Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#laporan-search').submit(function(){
	$.fn.yiiGridView.update('laporanpresensi-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'laporanpresensi-t-grid',
	'dataProvider'=>$model->searchPresensi(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
//        'mergeColumns' => array('pegawai.nomorindukpegawai', 'pegawai.nama_pegawai',),
        'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Jadwal Presensi</center>',
                        'start'=>'9',
                        'end'=>'13',
                    ),
                ),
	'columns'=>array(
				array(
                    'header'=>'No.',
                    'type'=>'raw',
                    'value' => '$row+1'
                ),
                array(
                    'header' => 'No FP',
                    'name' => 'no_fingerprint'
                ),
				array(
					'header' => 'Kelompok Pegawai/ <br/> Kategori Pegawai Asal',
					'type' => 'raw',
					'value' => function ($data){
							$kelPeg = !empty($data->pegawai->kelompokpegawai_id)?$data->pegawai->kelompokpegawai->kelompokpegawai_nama:'-';
							$katPegAsl =  !empty($data->pegawai->kategoripegawaiasal)?$data->pegawai->kategoripegawaiasal:'-';
						
							return $kelPeg."/ <br/>".$katPegAsl;
					}
				),                               
				array(
					'header' => 'Jabatan/ <br/> Kelompok Jabatan',
					'type' => 'raw',
					'value' => function ($data){
							$jab = !empty($data->pegawai->jabatan_id)?$data->pegawai->jabatan->jabatan_nama:'-';
							$kelJab =  !empty($data->pegawai->kelompokjabatan)?$data->pegawai->kelompokjabatan:'-';
						
							return $jab."/ <br/>".$kelJab;
					}
				),                
				array(
					'header' => 'Jenis Tenaga Medis',
					'type' => 'raw',
					'value' => function ($data){
							$jnsTegMedis = !empty($data->pegawai->jenistenagamedis)?$data->pegawai->jenistenagamedis:'-';							
						
							return $jnsTegMedis;
					}
				),     
                'pegawai.nomorindukpegawai',
                'pegawai.nama_pegawai',  
                 array(
                        'header' => 'Shift / Jam Kerja',
                        'value'=>'$this->grid->owner->renderPartial("presensiT/_shift",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                    ),
            
                array(
                    'header'=>'Tanggal Presensi',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->datepresensi)',
                ),
                /*
                array(
                    'header'=>'Jabatan',
                    'value'=>'$data->pegawai->jabatan->jabatan_nama',
                ),
                 * 
                 */
//                array(
//                    'header'=>'Tanggal Presensi',
//                    'value'=>'$data->tglpresensi',
//                ),
                array(
                    'header'=>'<center>Masuk</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_KELUAR, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                ),                
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_DATANG, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header' => 'Terlambat (Menit)',
                     'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                      'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header' => 'Pulang Awal (Menit)',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                     'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id, "datepresensi"=>$data->datepresensi),true)',
                ),
                
            ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        }',
)); ?>