
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'kelkumurhasillab_id',
		array(
			'header'=>'ID',
			'value'=>'$data->kelkumurhasillab_id',
		),
		'kelkumurhasillabnama',
		array (
			'name'=>'umurminlab',
			'type'=>'raw',
			'value'=>'$data->umurminlab',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array (
			'name'=>'umurmakslab',
			'type'=>'raw',
			'value'=>'$data->umurmakslab',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array (
			'name'=>'satuankelumur',
			'type'=>'raw',
			'value'=>'$data->satuankelumur',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array (
			'name'=>'kelkumurhasillab_urutan',
			'type'=>'raw',
			'value'=>'$data->kelkumurhasillab_urutan',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array (
			'name'=>'kelkumurhasillab_aktif',
			'type'=>'raw',
			'value'=>'(($data->kelkumurhasillab_aktif == 1)? "'.Yii::t('mds','Aktif').'" : "'.Yii::t('mds','Tidak Aktif').'")',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		)
	),
)); 
?>