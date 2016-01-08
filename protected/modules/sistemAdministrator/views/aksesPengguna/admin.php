<?php
$this->breadcrumbs=array(
	'saaksespengguna Ks'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saaksespengguna-k-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
</div><!-- search-form -->
<div class="block-tabel">
    <!--<legend class="rim">Pengaturan Akses Pemakai</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
        'id'=>'saaksespengguna-k-grid',
        'mergeColumns'=>array('loginpemakai.nama_pemakai','peranpengguna.peranpenggunanama'),
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
				'loginpemakai.nama_pemakai',
				'peranpengguna.peranpenggunanama',
				'modul.modul_nama',
                array(
					'header'=>Yii::t('zii','View'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{view}',
					'buttons'=>array(
							'view' => array(
											'label'=>"<i class='icon-eye-open'></i>",
											'options'=>array('title'=>Yii::t('mds','Lihat')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->aksespengguna_id"))',
							),
					 ),
                ),
                array(
					'header'=>Yii::t('zii','Update'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{update}',
					'buttons'=>array(
							'update' => array(
											'label'=>"<i class='icon-pencil'></i>",
											'options'=>array('title'=>Yii::t('mds','Ubah')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->aksespengguna_id"))',
									),
					 ),
                ),
                array(
					'header'=>Yii::t('zii','Delete'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{delete}',
					'buttons'=>array(
							'delete'=> array(
											'label'=>"<i class='entypo-cancel-circled'></i>",
											'options'=>array('title'=>Yii::t('mds','Hapus')),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->aksespengguna_id"))',
											'click'=>'function(){return confirm("'.Yii::t("mds","Anda yakin akan menghapus data ini?").'");}',
									),
					)
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Akses Pemakai',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $this->widget('UserTips',array('type'=>'admin'));
?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saaksespengguna-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>