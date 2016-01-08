<div class="white-container">
    <legend class="rim2">Lihat Jenis <b>Alat Medis</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajenisalatmedis Ms'=>array('index'),
            $model->jenisalatmedis_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Alat Medis '.$model->jenisalatmedis_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAJenisalatmedisM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAJenisalatmedisM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAJenisalatmedisM', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenisalatmedis_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAJenisalatmedisM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenisalatmedis_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Alat Medis', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'jenisalatmedis_id',
                    'jenisalatmedis_nama',
                    'jenisalatmedis_namalain',
                    'jenisalatmedis_aktif',
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->jenisalatmedis_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Alat Medis', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/JenisalatmedisM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>