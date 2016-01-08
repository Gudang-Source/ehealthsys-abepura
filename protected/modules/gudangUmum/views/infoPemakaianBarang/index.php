<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Pemakaianbarang Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipemakaianbarang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <legend class="rim2">Informasi <b>Pemakaian Barang</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Pemakaian Barang</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipemakaianbarang-grid',
			'dataProvider'=>$model->search(),
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
					'name'=>'instalasi_nama',
					'type'=>'raw',
					'value'=>'$data->instalasi_nama',
				),
				array(
					'name'=>'ruangan_nama',
					'type'=>'raw',
					'value'=>'$data->ruangan_nama',
				),
				array(
					'name'=>'tglpemakaianbrg',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpemakaianbrg)',
				),
				array(
					'name'=>'nopemakaianbrg',
					'type'=>'raw',
					'value'=>'$data->nopemakaianbrg',
				),
				array(
					'name'=>'untukkeperluan',
					'type'=>'raw',
					'value'=>'$data->untukkeperluan',
				),
				array(
					'name'=>'keteranganpakai',
					'type'=>'raw',
					'value'=>'$data->keteranganpakai',
				),
				array(
					'header'=>'Lihat',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/infoPemakaianBarang/detail",array("id"=>$data->pemakaianbarang_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pemakaian Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
				array(
					'header'=>Yii::t('zii','Batal'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPemakaianBarang",array("id"=>$data->pemakaianbarang_id))',
								'click'=>'function(){batalPemakaianBarang(this);return false;}',
								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
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
        'title' => 'Detail Pemakaian Barang',
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
	function batalPemakaianBarang(obj){
		myConfirm("Yakin akan membatalkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasipemakaianbarang-grid');
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