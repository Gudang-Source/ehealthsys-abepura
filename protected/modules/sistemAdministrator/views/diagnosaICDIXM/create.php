<fieldset class="box row-fluid">
    <legend class="rim">Tambah Diagnosa ICD IX</legend>
    <?php
    $this->breadcrumbs=array(
            'Sadiagnosa Icdixms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa ICD IX ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SADiagnosaICDIXM', 'icon'=>'list', 'url'=>array('index'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa ICD IX', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</fieldset>