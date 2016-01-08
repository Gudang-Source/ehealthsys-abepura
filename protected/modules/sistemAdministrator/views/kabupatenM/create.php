<div class="white-container">
    <legend class="rim2">Lihat <b>Kabupaten</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakabupaten Ms'=>array('index'),
            'Create',
    );


    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kabupaten ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kabupaten', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kabupaten', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;


    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>