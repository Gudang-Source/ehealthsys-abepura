<?php
$this->breadcrumbs=array(
	'Sakelompok Umur Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelompok Umur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Umur', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Umur', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sakelompok-umur-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sakelompok-umur-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'kelompokumur_id',
		array(
                        'name'=>'kelompokumur_id',
                        'value'=>'$data->kelompokumur_id',
                        'filter'=>false,
                ),
		'kelompokumur_nama',
		'kelompokumur_namalainnya',
		'kelompokumur_minimal',
		'kelompokumur_maksimal',
                
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->kelompokumur_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//                 array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->kelompokumur_aktif',
//                ), 
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->user->checkAccess("Update")',
                                        ),
                         ),
		),
		array(
                        'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{remove} {delete}',
                        'buttons'=>array(
                                        'remove' => array (
                                                'label'=>"<i class='icon-remove'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->kelompokumur_id"))',
                                                'visible'=>'($data->kelompokumur_aktif && Yii::app()->user->checkAccess("Update")) ? TRUE : FALSE',
                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                        ),
                                        'delete'=> array(
                                                'visible'=>'Yii::app()->user->checkAccess("Delete")',
                                        ),
                        )
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
      $content = $this->renderPartial('../tips/master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakelompok-umur-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>