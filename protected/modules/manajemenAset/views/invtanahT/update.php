<div class="white-container">
    <legend class="rim2">Ubah <b>Inventarisasi Tanah</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvtanah Ts'=>array('index'),
            $model->invtanah_id=>array('view','id'=>$model->invtanah_id),
            'Update',
    );
    $this->widget('bootstrap.widgets.BootAlert');
    //$this->renderPartial('/_dataBarang', array('modBarang' => $modBarang));
    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Inventarisasi Tanah','header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvtanahT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' MAInvtanahT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' MAInvtanahT', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->invtanah_id))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Tanah', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model, 'modBarang' => $modBarang, 'data'=>$data,'dataAsalAset'=>$dataAsalAset , 'dataLokasi'=>$dataLokasi)); ?>
</div>