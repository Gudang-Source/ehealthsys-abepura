<div class="white-container">
    <legend class="rim2">Lihat <b>Interpretasi Skor</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Psinterpretasiskor Ms'=>array('index'),
            $model->interpretasiskor_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Interpretasi Skor ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAInterpretasiskorM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAInterpretasiskorM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAInterpretasiskorM', 'icon'=>'pencil','url'=>array('update','id'=>$model->interpretasiskor_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAInterpretasiskorM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->interpretasiskor_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Interpretasi Skor', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'interpretasiskor_id',
                    'intepretasi_nama',
                    'interpretasijmlskor',
                    'interpretasimin',
                    'interpretasimax',
                    'catatan',
                    'interpretasiskor_aktif',
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Interpretasi Skor', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));?>
</div>