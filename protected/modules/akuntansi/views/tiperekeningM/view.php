<div class='white-container'>
    <legend class='rim2'>Lihat <b>Tipe Rekening</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Tiperekening Ms'=>array('index'),
                $model->tiperekening_id,
        );

        $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tipe Rekening '.$model->tiperekening_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Rekening ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 

    ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'tiperekening_id',
                    'tiperekening',
                    'keterangan',
                    array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->tiperekening_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tipe Rekening',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>