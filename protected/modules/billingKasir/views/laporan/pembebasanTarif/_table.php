<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'htmlOptions'=>array(
            'style'=>'font-size',
            
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'Nama Dokter',
                    // 'name'=>'nobuktibayar',
                    'type'=>'raw',
                    'value'=>'$data->nama_pegawai',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
// //                'nobuktibayar',
                array(
                    'header'=>'Tanggal <br> Pembebasan',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpembebasan))',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Tanggal <br> Pelayanan',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_tindakan))',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'No. RM <br> No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik ."<br>".$data->no_pendaftaran',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Nama Pasien / Alias',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien ." / ".$data->nama_bin',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Ruangan Peluayanan',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Jumlah Tarif',
                    'type'=>'raw',
                    'value'=>'$data->tarif_satuan',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Nama Tindakan',
                    'type'=>'raw',
                    'value'=>'$data->daftartindakan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Kompora Tarif',
                    'type'=>'raw',
                    'value'=>'0',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Jumlah Pembebasan',
                    'type'=>'raw',
                    'value'=>'$data->jmlpembebasan',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),                                                                

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>