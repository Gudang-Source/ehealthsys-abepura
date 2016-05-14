<div class='white-container'>
    <legend class='rim2'>Lihat <b>Periode Akuntansi</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Rekperiod Ms'=>array('index'),
                $model->rekperiod_id,
        );

        $arrMenu = array();
    //                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','View').' Rekening Periode ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rekening Periode ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php 
        $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                        'rekperiod_id',
                        'perideawal',
                        'sampaidgn',
                        'deskripsi',
                        array(            
                        'label'=>'Status Closing Aktif',
                        'type'=>'raw',
                        'value'=>(($model->isclosing==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
                ),
        )); 
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Rekening Periode',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>