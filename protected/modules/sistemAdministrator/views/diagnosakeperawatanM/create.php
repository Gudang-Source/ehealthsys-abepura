<div class="white-container">
    <legend class="rim2">Tambah <b>Diagnosa Keperawatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadiagnosakeperawatan Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa Keperawatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RIDiagnosakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Keperawatan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model, 'modKriteriaHasil'=>$modKriteriaHasil,'modDiagnosa'=>$modDiagnosa)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
</div>