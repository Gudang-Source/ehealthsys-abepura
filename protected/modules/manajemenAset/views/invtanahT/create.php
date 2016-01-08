<div class="white-container">
    <legend class="rim2">Register <b>Inventarisasi Tanah</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvtanah Ts'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    // $this->renderPartial('/_dataBarang', array('modBarang' => $modBarang ));
    $arrMenu = array();
                   // array_push($arrMenu,array('label'=>Yii::t('mds','').' Inventarisasi Tanah ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvtanahT', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Tanah', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model,'modBarang'=>$modBarang)); ?>
</div>