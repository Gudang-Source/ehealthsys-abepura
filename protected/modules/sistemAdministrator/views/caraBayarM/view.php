<div class="white-container">
    <legend class="rim2">Lihat <b>Cara Bayar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sacara Bayar Ms'=>array('index'),
            $model->carabayar_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Cara Bayar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Cara Bayar', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Bayar', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Cara Bayar', 'icon'=>'pencil','url'=>array('update','id'=>$model->carabayar_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Cara Bayar','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->carabayar_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Bayar', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'carabayar_id',
                    'carabayar_nama',
                    'carabayar_namalainnya',
                    'metode_pembayaran',
                    array(               // related city displayed as a link
                        'name'=>'carabayar_aktif',
                        'type'=>'raw',
                        'value'=>(($model->carabayar_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Cara Bayar', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/CaraBayarM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
</div>