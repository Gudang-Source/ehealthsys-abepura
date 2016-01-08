<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Rencana Lembur'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Buat Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Buat <b>Rencana Lembur</b></legend>
    <?php echo $this->renderPartial('_form', array('modRencanaLembur'=>$modRencanaLembur,'rencana'=>$rencana,'sukses'=>$sukses,)); ?>
</div>