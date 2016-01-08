<div class="white-container">
    <legend class="rim2">Lihat Bahan <b>Menu Diet</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gzbahanmenudiet Ms'=>array('index'),
            $model->bahanmenudiet_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bahan Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Bahan Menu Diet', 'icon'=>'pencil','url'=>array('update','id'=>$model->bahanmenudiet_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Bahan Menu Diet','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bahanmenudiet_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Menu Diet', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'bahanmenudiet_id',
                    'menudiet.menudiet_nama',
                    'bahanmakanan.namabahanmakanan',
                    'jmlbahan',
            ),
    )); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>