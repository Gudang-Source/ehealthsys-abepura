<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Pemeliharaan Aset'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipermintaanaset-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <legend class="rim2">Informasi <b>Pemeliharaan Aset</b></legend>
 <div class="block-tabel">
	<h6>Tabel <b>Pemeliharaan Aset</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipermintaanaset-grid',
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
					'name'=>'pemeliharaanaset_no',
					'type'=>'raw',
					'value'=>'$data->pemeliharaanaset_no',
				),
				array(
					'name'=>'pemeliharaanaset_ket',
					'type'=>'raw',
					'value'=>'$data->pemeliharaanaset_ket',
				),				
				array(
					'name'=>'pemeliharaanaset_tgl',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->pemeliharaanaset_tgl)',
				),
				array(
					'header'=>'Nama Pegawai Menegetahui',					
					'name'=>'pegawaimengetahui_nama',
					'type'=>'raw',
					'value'=>'$data->pegawaimengetahui_nama',
				),
				array(
					'header'=>'Nama Petugas 1',
					'name'=>'pegtugas1_nama',
					'type'=>'raw',
					'value'=>'$data->pegtugas1_nama',
				),
				array(
					'header'=>'Nama Petugas 2',					
					'name'=>'pegtugas2_nama',
					'type'=>'raw',
					'value'=>'$data->pegtugas2_nama',
				),
				array(
					'header'=>'Lihat',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/manajemenAset/infoPemeliharaanAset/detail",array("id"=>$data->pemeliharaanaset_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pemakaian Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
				array(
					'header'=>Yii::t('zii','Batal'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPemeliharaanAset",array("id"=>$data->pemeliharaanaset_id))',
								'click'=>'function(){batalPemeliharaanAset(this);return false;}',
								//'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
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
//========= Dialog untuk Melihat detail Permintaan Aset=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pemeliharaan Aset',
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
							$.fn.yiiGridView.update('informasipermintaanaset-grid');
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