<div class="white-container">
    <legend class="rim2">Lihat <b>Bidang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sabidang Ms'=>array('index'),
            $model->bidang_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Bidang', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SABidangM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SABidangM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SABidangM', 'icon'=>'pencil','url'=>array('update','id'=>$model->bidang_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SABidangM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bidang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bidang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'bidang_id',
                    'golongan_id',
                    'bidang_kode',
                    'bidang_nama',
                    'bidang_namalainnya',
                    'bidang_aktif',
            ),
    )); ?>

    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bidang', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
    $this->widget('UserTips',array('type'=>'view'));
    ?>
</div>