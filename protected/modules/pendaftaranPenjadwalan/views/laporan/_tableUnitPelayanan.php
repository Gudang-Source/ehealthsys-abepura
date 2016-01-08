<?php
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
if (isset($caraPrint)){
  $data = $model->searchUnitPelayananPrint();
  $template = '{items}';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchUnitPelayanan();
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
//        'mergeColumns'=>array('ruangan_nama'),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
             array(
          'header'=>'<center>No.</center>',
          'value'=>'$row+1',
          'htmlOptions'=>array('style'=>'width:30px;'),
          'type'=>'raw',
        ),
        array(
          'header'=>'<center>Nama Ruangan</center>',
          'name'=>'ruangan_nama',
          'value'=>'$data->ruangan_nama',
          'htmlOptions'=>array('style'=>'text-align:left;'),
          'type'=>'raw',
        ),
        array(
          'header'=>'<center>Kunjungan Baru</center>',
          'value'=>'$data->getKunjungan("PENGUNJUNG BARU",$data->ruangan_id)',
          'htmlOptions'=>array('style'=>'width:30px;'),
          'type'=>'raw',
        ),
        array(
          'header'=>'<center>Kunjungan Lama</center>',
          'value'=>'$data->getKunjungan("PENGUNJUNG LAMA",$data->ruangan_id)',
          'htmlOptions'=>array('style'=>'width:30px;'),
          'type'=>'raw',
        ),
        array(
          'header'=>'<center>Jumlah</center>',
            'value'=>'$data->getJmlKunjungan($data->ruangan_id)',
//          'value'=>'number_format($data->jumlahkunjunganbaru)',
          'htmlOptions'=>array('style'=>'width:30px;'),
          'type'=>'raw',
        ),
       
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
</div>
<?php } ?>
<br/>