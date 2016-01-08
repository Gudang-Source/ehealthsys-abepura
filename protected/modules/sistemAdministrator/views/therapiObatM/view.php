<fieldset class="box">
    <legend class="rim">Lihat Therapi Obat</legend>
    <?php
    $this->breadcrumbs=array(
            'Gftherapi Obat Ms'=>array('index'),
            $model->therapiobat_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Therapi Obat', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Therapi Obat', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Therapi Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Therapi Obat', 'icon'=>'pencil','url'=>array('update','id'=>$model->therapiobat_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Therapi Obat','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->therapiobat_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Therapi Obat', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'therapiobat_id',
                    'therapiobat_nama',
                    'therapiobat_namalain',
                     array(               // related city displayed as a link
                        'name'=>'therapiobat_aktif',
                        'type'=>'raw',
                        'value'=>(($model->therapiobat_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Therapi Obat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                    $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
</fieldset>