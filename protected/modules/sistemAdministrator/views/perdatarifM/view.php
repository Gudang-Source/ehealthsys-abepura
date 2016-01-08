<div class="white-container">
    <legend class="rim2">Lihat <b>Perda Tarif</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Saperda Tarif Ms'=>array('index'),
            $model->perdatarif_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Perda Tarif ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Perda Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Perda Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Perda Tarif', 'icon'=>'pencil','url'=>array('update','id'=>$model->perdatarif_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Perda Tarif','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->perdatarif_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Perda Tarif', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'perdatarif_id',
                    'perdanama_sk',
                    'noperda',
                    'tglperda',
                    'perdatentang',
                    'ditetapkanoleh',
                    'tempatditetapkan',
                    array(            
                            'label'=>'Aktif',
                            'type'=>'raw',
                            'value'=>(($model->perda_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                         ),
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Perda Tarif', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                        $this->widget('UserTips',array('type'=>'view'));?>
</div>