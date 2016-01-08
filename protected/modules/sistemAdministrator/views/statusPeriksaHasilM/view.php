<div class="white-container">
    <legend class="rim2">Lihat <b>Status Hasil Periksa Laboratorium</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rdkeadaan Masuk Ms'=>array('index'),
            $model->lookup_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Status Periksa Hasil '/*.$model->lookup_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Status Periksa Hasil', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Status Periksa Hasil', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Status Periksa Hasil', 'icon'=>'pencil','url'=>array('update','id'=>$model->lookup_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Status Periksa Hasil','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->lookup_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Status Periksa Hasil', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'lookup_id',
                    'lookup_name',
                    'lookup_urutan',
                    'lookup_kode',
                    array(            
                            'label'=>'Aktif',
                            'type'=>'raw',
                            'value'=>(($model->lookup_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                          ),
            ),
    )); ?>

    <?php 
     echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Status Hasil Periksa', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
    $this->widget('UserTips',array('type'=>'view'));?>
</div>