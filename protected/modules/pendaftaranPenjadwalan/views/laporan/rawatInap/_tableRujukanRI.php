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
  $template = "{summary}{items}{pager}";
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
              'header'=>'Nama Perujuk',
              'type'=>'raw',
              'value'=>'$data->nama_perujuk',
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