<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Kppresensi Ts'=>array('index'),
            'Create',
    );

    $arrMenu = array();
//    array_push($arrMenu,array('label'=>' Presensi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;
    ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model, 'modPegawai'=>$modPegawai)); ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
</div>