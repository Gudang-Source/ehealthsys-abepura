<?php
$this->breadcrumbs=array(
	'Samkategoriberita Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('samkategoriberita-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<legend class="rim">Pengaturan Kategori Berita</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
</div><!-- search-form -->
<div class="block-tabel">
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'samkategoriberita-m-grid',
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
		////'mkategoriberita_id',
		array(
                        'name'=>'mkategoriberita_id',
                        'value'=>'$data->mkategoriberita_id',
                        'filter'=>false,
                ),
		'kategoriberita',
		'ketkategoriberita',
		'urutankategori',
		// 'kategoriberita_aktif',
        array(
                    'name'=>'kategoriberita_aktif',
                    'value'=>'($data->kategoriberita_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
			'template'=>'{delete}', /* Fungsi remove dihilangkan karena kategoriberita_aktif tidak bisa false */
			'buttons'=>array(
			
//				'remove' => array (
//						'label'=>"<i class='icon-remove'></i>",
//						'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->mkategoriberita_id))',
//						'click'=>'function(){removeTemporary(this);return false;}',
//				),
				'delete'=> array(),
			)
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<?php 
 
        echo CHtml::link(Yii::t('mds','{icon} Tambah Kategori Berita',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $content = $this->renderPartial('tips/admin',array(),true);
        $this->widget('UserTips',array('type'=>'admin', 'content'=>$content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#samkategoriberita-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(obj){
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('samkategoriberita-m-grid');
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