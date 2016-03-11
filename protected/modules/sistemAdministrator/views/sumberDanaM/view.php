<fieldset class="box">
    <legend class="rim">Lihat Asal Barang</legend>
    <?php
    $this->breadcrumbs=array(
            'GfAsal Barang Ms'=>array('index'),
            $model->sumberdana_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Asal Barang', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Asal Barang', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Asal Barang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Asal Barang', 'icon'=>'pencil','url'=>array('update','id'=>$model->sumberdana_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Asal Barang','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->sumberdana_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Asal Barang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'sumberdana_id',
                    'sumberdana_nama',
                    'sumberdana_namalainnya',
                     array(               // related city displayed as a link
                        'name'=>'sumberdana_aktif',
                        'type'=>'raw',
                        'value'=>(($model->sumberdana_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>
   
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Asal Barang', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>