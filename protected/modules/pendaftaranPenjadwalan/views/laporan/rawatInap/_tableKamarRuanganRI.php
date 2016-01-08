<?php
  $table = 'ext.bootstrap.widgets.BootGridView';
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = '{items}';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTableLaporan();
  $template = "{summary}{pager}\n{items}";
}
?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
<div style='width:100%;overflow-x: scroll;'>
<?php } ?>
<?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
              'header'=>'Perawatan Per Blok',
              'type'=>'raw',
              'value'=>'$data->ruangan_nama',
            ),
            array(
              'header'=>'Per Kamar Ruangan ',
              'type'=>'raw',
              'value'=>'"No. Kamar : ".$data->kamarruangan_nokamar." No. Bed ".$data->kamarruangan_nobed',
            ),
            array(
              'header'=>'Per Kelas ',
              'type'=>'raw',
              'value'=>'$data->kelaspelayanan_nama',
            ),
            array(
              'header'=>'Nama Pasien / Alias',
              'type'=>'raw',
              'value'=>'$data->NamaNamaBIN',
            ),
            
            array(
              'header'=>'No. Rekam Medik',
              'type'=>'raw',
              'value'=>'$data->no_rekam_medik',
            ),
            
            array(
              'header'=>'No. Pendaftaran',
              'type'=>'raw',
              'value'=>'$data->no_pendaftaran',
            ),
            array(
              'header'=>'Tanggal Masuk',
              'type'=>'raw',
              'value'=>'$data->tgladmisi',
            ),
            array(
              'header'=>'Tanggal Keluar',
              'type'=>'raw',
              'value'=>'$data->tglpulang',
            ),
//            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
</div>
<?php } ?>
<br/>