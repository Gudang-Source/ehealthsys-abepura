<?php
/*$this->breadcrumbs=array(
	'Kelrem Ms',
);

$this->menu=array(
	array('label'=>'Create KelremM', 'url'=>array('create')),
	array('label'=>'Manage KelremM', 'url'=>array('admin')),
);*/
?>

<!--<h1>Kelrem Ms</h1>-->

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
<div class="white-container">
    <legend class="rim2">Master <b>Remunerasi</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <div>
        <iframe class='biru' id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
    </div>
</div>
