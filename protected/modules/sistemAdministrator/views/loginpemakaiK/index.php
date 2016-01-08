<?php
$this->breadcrumbs=array(
	'Loginpemakai Ks',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Login Pemakai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Login Pemakai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Login Pemakai', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php $this->widget('UserTips',array('type'=>'list'));?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Login Pemakai', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/sistemAdministrator/loginpemakaiK/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>