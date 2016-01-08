<?php
$this->breadcrumbs=array(
	'Kpindikatorperilaku Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kpindikatorperilaku-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Pengaturan <b>Indikator Perilaku</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut2 search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<!--<div class="block-tabel">-->
		<!--<h6 class="rim2">Tabel Indikator Perilaku</h6>-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'kpindikatorperilaku-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
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
				'header'=>'Jabatan',
				'name'=>'jabatan_id',
				'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
				'filter'=> CHtml::activeDropDownList($model,'jabatan_id',CHtml::listData(SAJabatanM::model()->findAll("jabatan_aktif is true"), "jabatan_id", "jabatan_nama"),array('empty'=>'--Pilih--')),
			),
			array(
				'header'=>'Jenis Penilaian',
				'name'=>'jenispenilaian_id',
				'value'=>'(isset($data->jenispenilaian->jenispenilaian_nama) ? $data->jenispenilaian->jenispenilaian_nama : "-")',
				'filter'=> CHtml::activeDropDownList($model,'jenispenilaian_id',CHtml::listData(SAJenispenilaianM::model()->findAll("jenispenilaian_aktif is true"), "jenispenilaian_id", "jenispenilaian_nama"),array('empty'=>'--Pilih--')),
			),
			array(
				'header'=>'Kompetensi',
				'name'=>'kompetensi_id',
				'value'=>'(isset($data->kompetensi->kompetensi_nama) ? $data->kompetensi->kompetensi_nama : "-")',
				'filter'=> CHtml::activeDropDownList($model,'kompetensi_id',CHtml::listData(SAKompetensiM::model()->findAll("kompetensi_aktif is true"), "kompetensi_id", "kompetensi_nama"),array('empty'=>'--Pilih--')),
			),
			'indikatorperilaku_nama',
			array(
				'name'=>'indikatorperilaku_aktif',
				'value'=>'(($data->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif")',
				'filter'=>array(1=>'Aktif',0=>'Tidak Aktif'),
				'htmlOptions'=>array('style'=>'text-align:left;'),
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
				'template'=>'{remove} {add} {delete}',
				'buttons'=>array(
					'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->indikatorperilaku_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'(($data->indikatorperilaku_aktif == 1) ? TRUE : FALSE)',
					),
					'add' => array (
							'label'=>"<i class='icon-form-check'></i>",
							'options'=>array('title'=>Yii::t('mds','Add Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->indikatorperilaku_id))',
							'click'=>'function(){active(this);return false;}',
							'visible'=>'(($data->indikatorperilaku_aktif == 1) ? FALSE : TRUE)',
					),
					'delete'=> array(),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
<!--</div>-->
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Indikator Perilaku',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#kpindikatorperilaku-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
</div>
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
							$.fn.yiiGridView.update('kpindikatorperilaku-m-grid');
							if(data.sukses > 0){
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
							$.fn.yiiGridView.update('kpindikatorperilaku-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal diaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>