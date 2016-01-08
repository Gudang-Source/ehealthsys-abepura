<div class="white-container">
    <legend class="rim2">Lihat Body <b>Mass Index</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rmbody Mass Indexes'=>array('index'),
            $model->bodymassindex_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').'  Body Mass Index', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKBodyMassIndex', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKBodyMassIndex', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKBodyMassIndex', 'icon'=>'pencil','url'=>array('update','id'=>$model->bodymassindex_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKBodyMassIndex','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->bodymassindex_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Body Mass Index', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'bodymassindex_id',
                    'bmi_range',
                    'bmi_minimum',
                    'bmi_maksimum',
                    'bmi_sign',
                    'bmi_defenisi',
                    'bmi_pesan',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->bodymassindex_aktif==1)? "Ya" : "Tidak")
                                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Body Mass Index', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('bodyMassIndex/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>