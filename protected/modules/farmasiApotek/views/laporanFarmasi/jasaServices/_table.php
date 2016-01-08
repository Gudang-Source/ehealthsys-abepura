<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$mergeColumns = array('obatalkes_nama');
$data = $model->searchTabelServices();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrintServices();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
//    'mergeColumns'=>$mergeColumns,
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            
            array(
                    'header' => 'No',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),
            array(
                'header'=>'Tanggal Pendaftaran',
                'type'=>'raw',
                'value'=>'isset($data->tgl_pendaftaran) ? date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran)):"-"',
            ),
            array(
                'header'=>'No. Pendaftaran',
                'type'=>'raw',
                'value'=>'isset($data->no_pendaftaran) ? $data->no_pendaftaran:"-"',
            ),
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'isset($data->no_rekam_medik) ? $data->no_rekam_medik:"-"',
            ),
            array(
                'header'=>'Jenis Kelamin',
                'type'=>'raw',
                'value'=>'isset($data->jeniskelamin) ? $data->jeniskelamin:"-"',
            ),
            array(
                'header'=>'Nama / Bin',
                'type'=>'raw',
                'value'=>'$data->getNamaBin($data->pegawai_id)',
            ),
            array(
                'header'=>'Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->ruanganasal_nama',
            ),
            array(
                'header'=>'Tanggal Resep',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglresep))',
            ),
            array(
                'header'=>'No. Resep',
                'type'=>'raw',
                'value'=>'$data->noresep',
            ),
            array(
                'header'=>'Nama Dokter',
                'type'=>'raw',
                'value'=>'isset($data->nama_pegawai) ? $data->nama_pegawai:"-"',
            ),
            array(
                'header'=>'Tanggal Penjualan',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenjualan))',
            ),            
            array(
                'header'=>'Biaya Administrasi',
                'type'=>'raw',
                'value'=>'$data->biayaadministrasi',
            ),
            array(
                'header'=>'Biaya Konseling',
                'type'=>'raw',
                'value'=>'$data->biayakonseling',
            ),
            array(
                'header'=>'Total Tarif Service',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->totaltarifservice)',
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>