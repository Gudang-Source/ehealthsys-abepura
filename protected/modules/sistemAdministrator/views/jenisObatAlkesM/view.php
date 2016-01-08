<fieldset class="box">
    <legend class="rim">Lihat Jenis Obat Alkes</legend>
    <?php
    $this->breadcrumbs=array(
            'Gfjenis Obat Alkes Ms'=>array('index'),
            $model->jenisobatalkes_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Obat Alkes', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Obat Alkes', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Obat Alkes', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Obat Alkes', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenisobatalkes_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Jenis Obat Alkes','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenisobatalkes_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Obat Alkes', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jenisobatalkes_id',
                    'jenisobatalkes_nama',
                    'jenisobatalkes_namalain',
                     array(               // related city displayed as a link
                        'name'=>'jenisobatalkes_aktif',
                        'type'=>'raw',
                        'value'=>(($model->jenisobatalkes_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Obat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                    $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>