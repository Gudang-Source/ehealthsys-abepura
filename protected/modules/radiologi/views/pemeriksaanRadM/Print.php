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
	'id'=>'sapemeriksaan-rad-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'pemeriksaanrad_id',
                 array(
                            'name'=>'pemeriksaanrad_id',
                            'value'=>'$data->pemeriksaanrad_id',
                            'filter'=>false,

                    ),
		         array(
                            'name'=>'daftartindakan_id',
                          //  'filter'=>  CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                              'filter'=>  CHtml::listData(DaftartindakanM::model()->findAll(array('order'=>'daftartindakan_nama')), 'daftartindakan_id','daftartindakan_nama'),
							  'value'=>'$data->daftartindakan->daftartindakan_nama',

                    ),
                 array(     'header'=>'Jenis Pemeriksaan',
                            'name'=>'jenispemeriksaanrad_nama',
                            'filter'=>  CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order'=>'jenispemeriksaanrad_nama')), 'jenispemeriksaanrad_nama','jenispemeriksaanrad_nama'),
                            'value'=>'$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',

                    ),
                    'pemeriksaanrad_nama',
                    'pemeriksaanrad_namalainnya',

                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->pemeriksaanrad_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->pemeriksaanrad_aktif',
    //                ), 

//                    array(
//                            'header'=>Yii::t('zii','View'),
//                            'class'=>'bootstrap.widgets.BootButtonColumn',
//                            'template'=>'{view}',
//                            'buttons'=>array(
//                                'view'=>array(
//                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat pemeriksaan radiologi'),
//                                ),
//                            ),
                  ),
		
    ));
?>