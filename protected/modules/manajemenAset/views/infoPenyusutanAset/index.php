<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Penyusutanaset Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipenyusutanaset-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim2">Informasi Penyusutan Aset</legend>
 <div class="block-tabel">
	<h6>Tabel <b>Penyusutan Aset</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipenyusutanaset-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:right;'),
				),
				array(
					'name'=>'tgl_penyusutan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_penyusutan)',
				),
				array(
					'name'=>'no_penyusutan',
					'type'=>'raw',
					'value'=>'$data->no_penyusutan',
				),
				array(
					'name'=>'barang_nama',
					'type'=>'raw',
					'value'=>'$data->barang_nama',
				),
				array(
					'name'=>'hargaperolehan',
					'type'=>'raw',
					'value'=>'$data->hargaperolehan',
				),
				array(
					'name'=>'residu',
					'type'=>'raw',
					'value'=>'$data->residu',
				),
				array(
					'name'=>'umurekonomis',
					'type'=>'raw',
					'value'=>'$data->umurekonomis',
				),
				array(
					'name'=>'totalpenyusutan',
					'type'=>'raw',
					'value'=>'$data->totalpenyusutan',
				),
				array(
					'name'=>'penyusutanaset_periode',
					'type'=>'raw',
					'value'=>'$data->penyusutanaset_periode',
				),
				array(
					'name'=>'penyusutanaset_saldo',
					'type'=>'raw',
					'value'=>'$data->penyusutanaset_saldo',
				),
				array(
					'name'=>'penyusutanaset_persentase',
					'type'=>'raw',
					'value'=>'$data->penyusutanaset_persentase',
				),
				array(
					'header'=>'Lihat',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/detail",array("id"=>$data->penyusutanaset_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penyusutan Aset", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
					'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
				array(
					'header'=>Yii::t('zii','Batal'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPenyusutanAset",array("id"=>$data->penyusutanaset_id))',
								'click'=>'function(){batalPenyusutanAset(this);return false;}',
						),
					)
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
 </div>
<fieldset class="box search-form">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,'format'=>$format
	)); ?>
</fieldset><!-- search-form -->

<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penyusutan Aset',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>
<script type="text/javascript">	
	function batalPenyusutanAset(obj){
		myConfirm("Yakin akan membatalkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasipenyusutanaset-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dibatalkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dibatalkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>