<div class="white-container">
    <legend class="rim2">Tambah <b>Pendidikan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapendidikan Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pendidikan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pendidikan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pendidikan', 'icon'=>'folder-open', 'url'=>array('Admin')));

    $this->menu=$arrMenu;


    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>