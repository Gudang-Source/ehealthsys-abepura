
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
		////'linen_id',
		array(
			'header'=>'ID',
			'value'=>'$data->linen_id',
		),
                array(
			'header'=>'Ruangan',
			'type'=>'raw',
                        'name'=>'ruangan_id',
			'value'=>'$data->ruangan->ruangan_nama',
                        'filter'=>  CHtml::activeDropDownList($model, 'ruangan_id', 
                                CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                    'ruangan_aktif'=>true,
                                ), array(
                                    'order'=>'ruangan_nama',
                                )), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --')),
		), 
		array(
			'header'=>'Rak Penyimpanan',
			'type'=>'raw',
			'value'=>function($data) {
                            $rak = RakpenyimpananM::model()->findByPk($data->rakpenyimpanan_id);
                            return empty($rak)?"-":$rak->rakpenyimpanan_nama;
                        },
                        'filter'=>  CHtml::activeDropDownList($model, 'rakpenyimpanan_id', 
                                CHtml::listData(RakpenyimpananM::model()->findAllByAttributes(array(
                                    'rakpenyimpanan_aktif'=>true,
                                ), array(
                                    'order'=>'rakpenyimpanan_nama',
                                )), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('empty'=>'-- Pilih --')),
		),     
		array(
			'header'=>'Jenis',
                        'name'=>'jenislinen_id',
			'type'=>'raw',
			'value'=>'$data->jenis->jenislinen_nama',
                        'filter'=>  CHtml::activeDropDownList($model, 'jenislinen_id', 
                                CHtml::listData(JenislinenM::model()->findAll(array(
                                    'order'=>'jenislinen_nama',
                                )), 'jenislinen_id', 'jenislinen_nama'), array('empty'=>'-- Pilih --')),
		), 		
		array (
			'header'=>'Bahan',
			'type'=>'raw',
                        'name'=>'bahanlinen_id',
			'value'=>'$data->bahan->bahanlinen_nama',
                        'filter'=>  CHtml::activeDropDownList($model, 'bahanlinen_id', 
                                CHtml::listData(BahanlinenM::model()->findAllByAttributes(array(
                                    'bahanlinen_aktif'=>true,
                                ), array(
                                    'order'=>'bahanlinen_nama',
                                )), 'bahanlinen_id', 'bahanlinen_nama'), array('empty'=>'-- Pilih --')),
		), 
		array(
			'header'=>'Nama Linen',
			'type'=>'raw',
                        'name'=>'barang_nama',
			'value'=>'isset($data->barang->barang_nama)?$data->barang->barang_nama:"-"'
		),
                array(
                    'header' => 'Status',
                    'value' => '($data->linen_aktif)?"Aktif":"Tidak Aktif"',
                ),

		/*
		'kodelinen',
		'tglregisterlinen',
		'noregisterlinen',
		'namalinen',
		'namalainnya',
		'merklinen',
		'beratlinen',
		'warna',
		'tahunbeli',
		'gambarlinen',
		'jmlcucilinen',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'linen_aktif',
		*/
 
	),
)); 
?>