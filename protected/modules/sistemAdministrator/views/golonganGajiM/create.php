<?php
    if ($this->hasTab):
?>
<fieldset class="box row-fluid">
    <legend class="rim">Tambah Golongan Gaji</legend>
<?php
    else:
?>
    <div class="white-container">
    <legend class="rim2">Tambah <b>Golongan Gaji</b></legend>
<?php
    endif;
?>

    <?php
    $this->breadcrumbs=array(
            'Golongan Gaji Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan Gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Gaji', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
<!--</div>-->
</fieldset>