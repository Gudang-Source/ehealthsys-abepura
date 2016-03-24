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
                        'name'=>'<center>Jam Presensi</center>',
                        'start'=>'5',
                        'end'=>'8',
                    ),
                ),
	'columns'=>array(
		 array(
                    'header'=>'No.',
                    'type'=>'raw',
                    'value' => '$row+1'
                ),
               'pegawai.nomorindukpegawai',
               'pegawai.nofingerprint',
               'pegawai.nama_pegawai',
               'pegawai.unit_perusahaan',
                array(
                    'header'=>'Tanggal presensi',
                    'value'=>'date("d/m/Y",strtotime($data->datepresensi))',//H:i:s
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
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Pulang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Keluar</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                ),
                array(
                    'header'=>'<center>Datang</center>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
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