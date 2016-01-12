<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Penerimaanlinen Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipenerimaanlinen-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim2">Informasi Penerimaan Linen</legend>
 <div class="block-tabel">
	<h6>Tabel <b>Penerimaan Linen</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipenerimaanlinen-grid',
			'dataProvider'=>$modPenerimaanlinen->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:right; width:30px;'),
				),
				array(
					'header'=>'No. Penerimaan',
					'type'=>'raw',
					'value'=>'$data->nopenerimaanlinen',
				),
				array(
					'header'=>'Tanggal Penerimaan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenerimaanlinen)',
				),
				array(
					'name'=>'Instalasi',
					'type'=>'raw',
					'value'=>'$data->ruangan->instalasi->instalasi_nama',
				),
				array(
					'name'=>'Ruangan',
					'type'=>'raw',
					'value'=>'$data->ruangan->ruangan_nama',
				),
				array(
					'name'=>'keterangan_pengiriman',
					'type'=>'raw',
					'value'=>'$data->keterangan_penerimaanlinen',
				),
//				RND-8968
//				array(
//					'header'=>'Proses',
//					'type'=>'raw',
//					'value'=>'CHtml::link("<button class=\'btn btn-success\'><i class=\'icon-ok icon-white\'></i> Proses</button>",  Yii::app()->controller->createUrl("/laundry/PenerimaanLinenT/index",array("id"=>$data->pengperawatanlinen_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Linen","disabled"=>true));',    'htmlOptions'=>array('style'=>'text-align: center; width:100px')
//				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPenerimaanLinen/detail",array("penerimaanlinen_id"=>$data->penerimaanlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penerimaan Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
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
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPenerimaan",array("id"=>$data->pengperawatanlinen_id))',
								'click'=>'function(){batalPenerimaan(this);return false;}',
//								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
						),
					),
					'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
 </div>
<fieldset class="box search-form">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'modPenerimaanlinen'=>$modPenerimaanlinen,'format'=>$format
	)); ?>
</fieldset><!-- search-form -->

<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Linen',
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
	function batalPenerimaan(obj){
		myConfirm("Yakin akan membatalkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasipenerimaanlinen-grid');
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