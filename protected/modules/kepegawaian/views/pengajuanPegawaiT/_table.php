<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'kpinfopengajuanpegawai-v-grid',
	'dataProvider'=>$model->searchInformasi(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(		
		array(
			'header'=>'Tanggal Pengajuan',
			'name'=>'tglpengajuan',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengajuan)',
		),
		array(
			'header'=>'No Pengajuan',
			'name'=>'nopengajuan',
			'value'=>'$data->nopengajuan',
		),
		array(
			'header'=>'Yang Mengajukan',
			'name'=>'mengajukan_id',
			'value'=>'(!empty($data->id_pegmengajukan)?$data->namaLengkapMengajukan:"")',
		),
                array(
			'header'=>'Mengetahui',
			'name'=>'mengetahui_id',
			'value'=>'(!empty($data->id_pegmengetahui)?$data->namaLengkapMengetahui:"")',
		),
                array(
			'header'=>'Menyetujui',
			'name'=>'mengetahui_id',
			'value'=>'(!empty($data->id_pegmenyetujui)?$data->namaLengkapMenyetujui:"")',
		),
                array(
                        'header' => 'Jml Orang',
                        'name' => 'jmlorang',
                        'value' => '$data->jmlorang',
                        'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array(
                        'header' => 'Untuk Keperluan',  
                        'name' => 'untukkeperluan',
                        'value' => '$data->untukkeperluan'
                ),
                array(
                        'header' => 'Keterangan',  
                        'name' => 'keterangan',
                        'value' => '$data->keterangan'
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>