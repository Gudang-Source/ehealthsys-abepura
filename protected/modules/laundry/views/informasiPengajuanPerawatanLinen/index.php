<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Pengajuanperawatanlinen Ts'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasipengperawatanlinen-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <legend class="rim2">Informasi <b>Pengajuan Perawatan</b></legend>
    <div class="block-tabel">
	<h6>Tabel <b>Pengajuan Perawatan</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipengperawatanlinen-grid',
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
					'header'=>'No. Pengajuan',
					'type'=>'raw',
					'value'=>'$data->pengperawatanlinen_no',
				),
				array(
					'header'=>'Tanggal Pengajuan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengperawatanlinen)',
				),
				array(
					'header'=>'Instalasi',
					'type'=>'raw',
					'value'=>'$data->ruangan->instalasi->instalasi_nama',
				),
				array(
					'header'=>'Ruangan',
					'type'=>'raw',
					'value'=>'$data->ruangan->ruangan_nama',
				),
				array(
					'name'=>'keterangan_pengperawatanlinen',
					'type'=>'raw',
					'value'=>'$data->keterangan_pengperawatanlinen',
				),
				array(
					'header'=>'Terima Linen',
					'type'=>'raw',
					'value'=>'((Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_LAUNDRY) ? (($data->getSudahTerima($data->pengperawatanlinen_id)) ?  "SUDAH DITERIMA"  : CHtml::link("<button class=\'btn btn-success\'><i class=\'icon-ok icon-white\'></i> Proses</button>",  Yii::app()->controller->createUrl("/laundry/PenerimaanLinenT/index",array("id"=>$data->pengperawatanlinen_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Linen","disabled"=>true))) : "Tidak ada akses")',
				    'htmlOptions'=>array('style'=>'text-align: left; width:100px'),
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPengajuanPerawatanLinen/detail",array("pengperawatanlinen_id"=>$data->pengperawatanlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pengajuan Perawatan Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
					'htmlOptions'=>array('style'=>'text-align: left; width:40px')
				),
				array(
					'header'=>Yii::t('zii','Batal'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPengajuan",array("id"=>$data->pengperawatanlinen_id))',
								'click'=>'function(){batalPengajuan(this);return false;}',
//								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
						),
					),
					'htmlOptions'=>array('style'=>'text-align: left; width:40px')
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
//========= Dialog untuk Melihat detail Pengajuan Perawatan Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengajuan Perawatan Linen',
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
	function batalPengajuan(obj){
		myConfirm("Yakin akan membatalkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasipengperawatanlinen-grid');
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