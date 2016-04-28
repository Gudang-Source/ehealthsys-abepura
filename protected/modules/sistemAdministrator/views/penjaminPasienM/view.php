<div class="white-container">
    <legend class="rim2">Lihat <b>Penjamin Pasien</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapenjamin Pasien Ms'=>array('index'),
            $model->penjamin_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Penjamin Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Penjamin', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Penjamin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Penjamin', 'icon'=>'pencil','url'=>array('update','id'=>$model->penjamin_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Penjamin','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->penjamin_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penjamin Pasien', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'penjamin_id',
                    'carabayar.carabayar_nama',
                    'penjamin_nama',
                    'penjamin_namalainnya',
                    array(               // related city displayed as a link
                        'name'=>'penjamin_aktif',
                        'type'=>'raw',
                        'value'=>(($model->penjamin_aktif==1)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>
    
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/asuransi/PenjaminPasienMAS/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>