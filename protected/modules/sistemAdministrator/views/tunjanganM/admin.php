<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$this->breadcrumbs=array(
	'Kptunjangan Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kptunjangan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Pengaturan <b>Tunjangan</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut2 search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<!--<div class="block-tabel">-->
		<!--<h6 class="rim2">Tabel Tunjangan</h6>-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'kptunjangan-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model, //dikarenakan komponen berupa id dari tabel lain
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:center; width:10px;'),
			),
			array(
				'name'=>'pangkat_id',
				'type'=>'raw',
				'value'=>'isset($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
				'filter'=> CHtml::dropDownList('SATunjanganM[pangkat_id]',$model->pangkat_id,CHtml::listData(PangkatM::model()->findAll('pangkat_aktif = true ORDER BY pangkat_nama ASC'),'pangkat_id','pangkat_nama'),array('empty'=>'-- Pilih --')),
			),
			array(
				'name'=>'jabatan_id',
				'type'=>'raw',
				'value'=>'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
				'filter'=> CHtml::dropDownList('SATunjanganM[jabatan_id]',$model->jabatan_id,CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true ORDER BY jabatan_nama ASC'),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --')),
			),
			array(
				'name'=>'komponengaji_id',
				'type'=>'raw',
				'value'=>'isset($data->komponengaji_id)?$data->komponengaji->komponengaji_nama:"-"',
				'filter'=> CHtml::dropDownList('SATunjanganM[komponengaji_id]',$model->komponengaji_id,CHtml::listData(KomponengajiM::model()->findAll('komponengaji_aktif = true ORDER BY komponengaji_nama ASC'),'komponengaji_id','komponengaji_nama'),array('empty'=>'-- Pilih --')),
			),
			array(
				'name'=>'nominaltunjangan',
				'type'=>'raw',
				'value'=>'"Rp".number_format($data->nominaltunjangan,0,"",".")',
                                'htmlOptions' => array('style'=>'text-align:right;'),
				'filter'=>CHtml::activeTextField($model,'nominaltunjangan',array('class'=>'numbers-only','style'=>'text-align:right;')),
			),
			array(
				'header'=>'Status',
				'type'=>'raw',
				'value'=>'(($data->tunjangan_aktif) ? "Aktif" : "Tidak Aktif")',
			),
			array(
				'header'=>Yii::t('zii','View'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
					'view' => array(),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Update'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update' => array(),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{remove}{add}{delete}',
				'buttons'=>array(
					'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->tunjangan_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'(($data->tunjangan_aktif) ? TRUE : FALSE)',
					),
					'add' => array (
									'label'=>"<i class='icon-form-check'></i>",
									'options'=>array('title'=>Yii::t('mds','Add Temporary')),
									'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->tunjangan_id))',
									'click'=>'function(){active(this);return false;}',
									'visible'=>'(($data->tunjangan_aktif) ? FALSE : TRUE)',
					),
					'delete'=> array(),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
<!--</div>-->
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Tunjangan',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#kptunjangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('kptunjangan-m-grid');
							if(data.sukses > 0){
								myAlert('Data Sukses dinonaktifkan!');
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
	
	function active(obj){
		myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('kptunjangan-m-grid');
							if(data.sukses > 0){
								myAlert('Data Sukses diaktifkan!');
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>