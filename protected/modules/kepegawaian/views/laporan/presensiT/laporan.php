
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
                        'start'=>'5',
                        'end'=>'9',
                    ),
                ),
	'columns'=>array(
		/* array(
                    'header'=>'No.',
                    'type'=>'raw',
                    'value' => '$row+1'
                ),*/
                array(
                    'header' => 'No FP',
                    'name' => 'no_fingerprint'
                ),
               'pegawai.kelompokpegawai.kelompokpegawai_nama',
                'pegawai.jabatan.jabatan_nama',
                'pegawai.nomorindukpegawai',
                'pegawai.nama_pegawai',  
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
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_KELUAR, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                ),                
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_DATANG, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header' => 'Terlambat (Menit)',
                     'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_MASUK, "datepresensi"=>$data->datepresensi),true)',
                      'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header' => 'Pulang Awal (Menit)',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>Params::STATUSSCAN_PULANG, "datepresensi"=>$data->datepresensi),true)',
                     'htmlOptions' => array('style'=>'text-align:center;')   
                ),
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("pegawai_id"=>$data->pegawai_id, "datepresensi"=>$data->datepresensi),true)',
                ),
                
            ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        }',
)); ?>