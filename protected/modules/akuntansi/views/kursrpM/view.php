<div class='white-container'>
    <legend class='rim2'>Lihat <b>Kurs Rp.</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Kursrp Ms'=>array('index'),
                $model->kursrp_id,
        );

        $arrMenu = array();
    //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kurs Rp. ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kurs Rp. ', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kurs Rp. ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kurs Rp. ', 'icon'=>'pencil','url'=>array('update','id'=>$model->kursrp_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kurs Rp. ','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kursrp_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kurs Rp. ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php 
        $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                        'kursrp_id',
                        'matauang.matauang',
                        'tglkursrp',
                        'nilai',
                        'rupiah',
                        array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->kursrp_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
                ),
        )); 
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kurs Rp.',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>                        
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>