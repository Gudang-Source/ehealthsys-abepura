<div class="white-container">
    <legend class="rim2">Register Inventarisasi <b>Gedung dan Bangunan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvgedung Ts'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    // $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang ));
    $arrMenu = array();
                  //  array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Inventarisasi Gedung dan Bangunan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvgedungT', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Gedung dan Bangunan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modBarang' => $modBarang)); ?>
</div>