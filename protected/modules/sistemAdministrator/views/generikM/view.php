<fieldset class="box">
    <legend class="rim">Lihat Generik</legend>
    <?php
    $this->breadcrumbs=array(
            'Gfgenerik Ms'=>array('index'),
            $model->generik_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Generik', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Generik', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Generik', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Generik', 'icon'=>'pencil','url'=>array('update','id'=>$model->generik_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Generik','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->generik_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Generik', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'generik_id',
                    'generik_nama',
                    'generik_namalain',
                     array(               // related city displayed as a link
                        'name'=>'generik_aktif',
                        'type'=>'raw',
                        'value'=>(($model->generik_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>
    
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Generik', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>