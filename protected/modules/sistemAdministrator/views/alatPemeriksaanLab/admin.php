<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlabmapping Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapemeriksaanlabmapping-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
  $this->widget('bootstrap.widgets.BootAlert'); 
?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<!--<div class="block-tabel">-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'sapemeriksaanlabmapping-m-grid',
		'dataProvider'=>$model->searchTabel(),
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
			'header'=>'Nama Pemeriksaan',
			'name'=>'pemeriksaanlabalat_nama',
			'value'=>'$data->pemeriksaanlabalat->pemeriksaanlabalat_nama',
			'filter'=>  CHtml::activeTextField($model,'pemeriksaanlabalat_nama'),
			),
		array(
			'header'=>'Kode Pemeriksaan',
			'name'=>'pemeriksaanlabalat_kode',
			'value'=>'$data->pemeriksaanlabalat->pemeriksaanlabalat_kode',
			'filter'=>  CHtml::activeTextField($model,'pemeriksaanlabalat_kode'),
			),
		
		array(
			'header'=>'Kelompok Detail',
			'name'=>'kelompokdet',
			'value'=>'$data->nilairujukan->kelompokdet',
			'filter'=>  CHtml::activeTextField($model,'kelompokdet'),
			),
		array(
			'header'=>'Pemeriksaan Detail',
			'name'=>'namapemeriksaandet',
			'value'=>'$data->nilairujukan->namapemeriksaandet',
			'filter'=>  CHtml::activeTextField($model,'namapemeriksaandet'),
			),
		array(
			'header'=>'Jenis Kelamin',
			'name'=>'nilairujukan_jeniskelamin',
			'value'=>'$data->nilairujukan->nilairujukan_jeniskelamin',
			'filter'=>LookupM::getItems('jeniskelamin'),
			),
		array(
			'header'=>'Nilai Rujukan',
			'name'=>'nilairujukan_nama',
			'value'=>'$data->nilairujukan->nilairujukan_nama',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_nama'),
			),
		array(
			'header'=>'Nilai Minimum',
			'name'=>'nilairujukan_min',
			'value'=>'$data->nilairujukan->nilairujukan_min',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_min'),
			),
		array(
			'header'=>'Nilai Maksimum',
			'name'=>'nilairujukan_max',
			'value'=>'$data->nilairujukan->nilairujukan_max',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_max'),
			),
		array(
			'header'=>'Satuan',
			'name'=>'satuan',
			'value'=>'$data->nilairujukan->nilairujukan_satuan',
			'filter'=>  CHtml::activeTextField($model,'nilairujukan_satuan'),
			),
		/*
		'pemeriksaanalatrad_aktif',
		*/
			/**array(
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
					'update' => array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
			 * 
			 */
			array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>' {delete}',
				'buttons'=>array(
					/*'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pemeriksaanalatrad_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
					),
					 * 
					 */
					'delete'=> array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
					),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			$("table").find("input[type=text]").each(function(){
				cekForm(this);
			})
			$("table").find("select").each(function(){
				cekForm(this);
			})
		}',
	)); ?>
<!--</div>-->
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Pemeriksaan Alat Lab.',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$this->widget('UserTips',array('content'=>''));
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
	//$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sapemeriksaanlabmapping-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemeriksaanlabmapping-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
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
							$.fn.yiiGridView.update('sapemeriksaanlabmapping-m-grid');
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
</script>