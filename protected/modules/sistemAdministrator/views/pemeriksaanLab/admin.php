<fieldset class="box">
    <legend class="rim">Pengaturan Pemeriksaan</legend>
<!--<div class="white-container">-->
    <!--<legend class="rim2">Pengaturan <b>Pemeriksaan Raboratorium</b></legend>-->
<?php
$this->breadcrumbs=array(
	'Sapemeriksaanlab Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapemeriksaanlab-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<legend class="rim2">Pengaturan Pemeriksaan Lab</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial($this->path_view.'_search',array(
            'model'=>$model,
    )); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Pemeriksaan Raboratorium</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sapemeriksaanlab-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped  table-condensed',
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
			'name'=>'pemeriksaanlab_id',
			'value'=>'$data->pemeriksaanlab_id',
			'filter'=>false,
		),
		array(
			'name'=>'jenispemeriksaanlab_id',
			'value'=>'$data->jenispemeriksaan->jenispemeriksaanlab_nama',
			'filter'=>CHtml::activeDropDownList($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order'=>'jenispemeriksaanlab_urutan', 'condition'=>'jenispemeriksaanlab_aktif = true'),'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty'=>'--Pilih--')),
		),
		array(
			'name'=>'daftartindakan_id',
			'value'=>'$data->daftartindakan->daftartindakan_nama',
			'filter'=>CHtml::activeTextField($model,'daftartindakan_nama'),
		),
		'pemeriksaanlab_kode',
		'pemeriksaanlab_urutan',
		'pemeriksaanlab_nama',
		'pemeriksaanlab_namalainnya',
		array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->pemeriksaanlab_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
			'template'=>'{remove} {add} {delete}',
			'buttons'=>array(
				'remove' => array (
						'label'=>"<i class='icon-form-silang'></i>",
						'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pemeriksaanlab_id))',
						'click'=>'function(){nonActive(this);return false;}',
						'visible'=>'$data->pemeriksaanlab_aktif',
				),
                                'add' => array (
                                                'label'=>"<i class='icon-form-check'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Active Temporary')),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pemeriksaanlab_id))',
                                                'visible'=>'($data->pemeriksaanlab_aktif) ? FALSE : TRUE',
                                                'click'=>'function(){active(this,1);return false;}',
                                ),
				'delete'=> array(),
			)
		),
	),
	//'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	'afterAjaxUpdate'=>'function(id, data){
			   jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			   $("table").find("input[type=text]").each(function(){
				   cekForm(this);
			   })
			   $("table").find("select").each(function(){
				   cekForm(this);
			   })
			}'
)); ?>
<!--</div>-->
<?php 
	//echo CHtml::link(Yii::t('mds','{icon} Tambah Pemeriksaan Lab',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
        echo CHtml::link(Yii::t('mds','{icon} Tambah Pemeriksaan',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
	$this->widget('UserTips',array('type'=>'admin','content'=>$content));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
           function cekForm(obj)
{
    $("#sapemeriksaanlab-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemeriksaanlab-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=1');
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
							$.fn.yiiGridView.update('sapemeriksaanlab-m-grid');
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
        
        function active(obj, add){
		myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {add:add},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sapemeriksaanlab-m-grid');
							if(data.sukses > 0){
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
</fieldset>