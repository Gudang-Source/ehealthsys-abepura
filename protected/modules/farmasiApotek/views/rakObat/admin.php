<fieldset class="box">
    <legend class="rim">Pengaturan Rak Obat</legend>
<?php
$this->breadcrumbs=array(
	'Farakobat Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('farakobat-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
    <!--<h6>Tabel <b>Rak Obat</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'farakobat-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:right;'),
		),
		'rakobat_nama',
		'rakobat_namalain',
		'rakobat_label',
		array(
			'header'=>'<center>Status</center>',
			'value'=>'($data->rakobat_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
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
			'template'=>'{remove} {delete}',
			'buttons'=>array(
				'remove' => array (
						'label'=>"<i class='icon-form-silang'></i>",
						'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->rakobat_id))',
						'click'=>'function(){nonActive(this);return false;}',
				),
				'delete'=> array(),
			)
		),
	),
	'afterAjaxUpdate'=>'function(id, data){
		jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
		$("table").find("input[type=text]").each(function(){
			cekForm(this);
		})
	}',
    )); ?>
<!--</div>-->
<?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Rak Obat',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#farakobat-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#farakobat-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
							$.fn.yiiGridView.update('farakobat-m-grid');
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