<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Tgl. Rekam Medik',
			'value'=>'isset($data->tgl_rekam_medik) ? MyFormatter::formatDateTimeForUser($data->tgl_rekam_medik) : ""',
		),
		array(
			'header'=>'No. Rekam Medik',
			'value'=>'$data->no_rekam_medik',
		),
		array(
			'header'=>'No. Pendaftaran',
			'value'=>'$data->no_pendaftaran',
		),
		array(
			'header'=>'Nama Pasien',
			'value'=>'$data->nama_pasien',
		),
		array(
			'header'=>'Tanggal Lahir',
			'value'=>'isset($data->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($data->tanggal_lahir) : ""',
		),
		array(
			'header'=>'Warna Dokumen',
			'value'=>'$data->warnadokrm_namawarna',
		),
		array(
			'header'=>'Lokasi Rak',
			'value'=>'$data->lokasirak_nama',
		),
	),
)); 
?>