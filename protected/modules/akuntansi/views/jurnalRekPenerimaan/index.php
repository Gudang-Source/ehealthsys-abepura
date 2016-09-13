<?php
/*$this->breadcrumbs=array(
	'Matauang Ms',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jurnal Rek Penerimaan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list')); */ ?>

<div class="white-container">
    <legend class="rim2">Master <b>Jurnal Rekening</b></legend>
    <?php $this->renderPartial('_tabMenuPenerimaan',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <div>
        <iframe class='biru' id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
    </div>
</div>