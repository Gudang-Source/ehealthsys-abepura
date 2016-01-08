<div class="white-container">
    <legend class="rim2">Lihat <b>Sebab Abortus</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Pssebababortus Ms'=>array('index'),
            $model->sebababortus_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sebab abortus ','header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASebababortusM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SASebababortusM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SASebababortusM', 'icon'=>'pencil','url'=>array('update','id'=>$model->sebababortus_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SASebababortusM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->sebababortus_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sebab abortus', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'sebababortus_id',
                    'kelsebababortus_id',
                    'sebababortus_nama',
                    'sebababortus_namalain',
                    'sebababortus_aktif',
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Sebab Abortus', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));?>
</div>