
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
	'id'=>'sajenis-kegiatan-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'komponenunit_id',
		array(
                    'header'=>'ID',
                    'value'=>'$data->jeniskegiatan_id',
                ),
                array(
                    'header' => 'Kode Jenis Kegiatan',
                    'value' => '$data->jeniskegiatan_kode'
                ),
                array(
                    'header' => 'Nama Jenis Kegiatan',
                    'value' => '$data->jeniskegiatan_nama'
                ),
                array(
                    'header' => 'Ruangan Jenis Kegiatan',
                    'value' => '$data->jeniskegiatan_ruangan'
                ),
		array(
                    'header' => 'Status',
                    'value' => '($data->jeniskegiatan_aktif == TRUE)?"Aktif":"Tidak Aktif"'
                ),		
 
        ),
    )); 
?>