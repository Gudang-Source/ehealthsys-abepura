
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'barang_id',
		array(
			'name'=>'barang_id',
			'value'=>'$data->barang_id',
			'filter'=>false,
		),
		array(
                        'name'=>'subsubkelompok_id',
                        'filter'=> CHtml::activeDropDownList($model, 'subsubkelompok_id',CHtml::listData($model->SubSubKelompokItems, 'subsubkelompok_id', 'subsubkelompok_nama'),array('empty'=>'--Pilih--')),
                        'value'=>function($data) {
                            $sub = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
                            return $sub->subsubkelompok_nama;
                        }
                    ),
		array(
			'name'=>'barang_type',
			'value'=>'$data->barang_type',
			'filter'=>CHtml::activeTextField($model, 'barang_type'),
		),
		'barang_kode',
		'barang_nama',
		'barang_namalainnya',
		 array(
			'header'=>'<center>Status</center>',
			'value'=>'($data->barang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		/*
		'barang_merk',
		'barang_noseri',
		'barang_ukuran',
		'barang_bahan',
		'barang_thnbeli',
		'barang_warna',
		'barang_statusregister',
		'barang_ekonomis_thn',
		'barang_satuan',
		'barang_jmldlmkemasan',
		'barang_aktif',
		*/
 
        ),
    )); 
?>