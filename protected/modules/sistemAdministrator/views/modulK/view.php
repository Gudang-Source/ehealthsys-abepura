<div class="white-container">
    <legend class="rim2">Lihat <b>Modul</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Samodul Ks'=>array('index'),
            $model->modul_id,
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','View').' Modul ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Modul', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Modul', 'icon'=>'file', 'url'=>array('create')),
    //        array('label'=>Yii::t('mds','Update').' Modul', 'icon'=>'pencil','url'=>array('update','id'=>$model->modul_id)),
    //	array('label'=>Yii::t('mds','Delete').' Modul','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->modul_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
    //	array('label'=>Yii::t('mds','Manage').' Modul', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    //'icon_modul',
                    array(
                        'name'=>'icon_modul',
                        'type'=>'raw',
                        'value'=>CHtml::image(Params::urlIconModulDirectory().$model->icon_modul),
                    ),
                    'modul_id',
                    'modul_kategori',
                    'kelompokModul',
                    'modul_nama',
                    'modul_namalainnya',
                    'modul_fungsi',
                    'tglrevisimodul',
                    'tglupdatemodul',
                    'url_modul',
                    'modul_key',
                    'modul_urutan',
                    //'modul_aktif',
                    array(        
                        'name'=>'modul_aktif',
                        'type'=>'raw',
                        'value'=>(($model->modul_aktif==true)? Yii::t('mds','Yes') : Yii::t('mds','No')),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->modul_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Modul', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));?>
</div>