<?php
$this->breadcrumbs=array(
	'Pengumumen'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapengumuman-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!-- <legend class="rim2">Pengaturan Pengumuman</legend> -->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php 
// $this->renderPartial('_search',array(
// 	'model'=>$model,
// )); 
?>
</div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sapengumuman-grid',
	'dataProvider'=>$model->searchTabel(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                        'header'=>'No.',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
				array(
                    'header'=>'ID',
                    'type'=>'raw',
					'value'=>'$data->pengumuman_id',
                ),
				'judul',
                array(
                    'name'=>'isi',
                    'type'=>'raw',
					'value'=>'$data->isi',
                ),
                array(
                    'name'=>'status_publish',
                    'value'=>'($data->status_publish) ? "AKTIF":"NON AKTIF"',
                ),
                array(
                    'name'=>'create_time',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->create_time)',
                    'filter'=>false,
                ),
                array(
                    'name'=>'update_time',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->update_time)',
                    'filter'=>false,
                ),
				array(
					'header'=>'Login Pemakai (Create)',
					'type'=>'raw',
					'value'=>'$data->nama_pemakai',
				),
				array(
					'header'=>'Login Pemakai (Update)',
					'type'=>'raw',
					'value'=>'$data->nama_pemakai',
				),
				array(
					'header'=>'Login Pemakai (Publish)',
					'type'=>'raw',
					'value'=>'$data->nama_pemakai',
				),
				//'create_loginpemakai_id',
				//'update_loginpemakai_id',
				//'publish_loginpemakai_id',
		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
