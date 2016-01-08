<div class="white-container">
    <legend class="rim2">Lihat <b>Propinsi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapropinsi Ms'=>array('index'),
            $model->propinsi_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Propinsi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Propinsi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Propinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Propinsi', 'icon'=>'pencil','url'=>array('update','id'=>$model->propinsi_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Propinsi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->propinsi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Propinsi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
            <div class="span4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                            'propinsi_id',
                            'propinsi_nama',
                            'propinsi_namalainnya',
                    ),
            )); ?>
            </div>
            <div class="span4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$model,
                    'attributes'=>array(
                            'longitude',
                            'latitude',
                            array(            
                                                                                                    'label'=>'Aktif',
                                                                                                    'type'=>'raw',
                                                                                                    'value'=>(($model->propinsi_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                                                                            ),
                    ),
            )); ?>
            </div>
    </div>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->propinsi_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>        
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Propinsi', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                    $this->createUrl('PropinsiM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>