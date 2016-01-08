<div class="white-container">
    <legend class="rim2">Lihat <b>Kelompok Menu</b></legend>
    <?php
    //$this->widget('bootstrap.widgets.BootMenu', array(
    //    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    //    'stacked'=>false, // whether this is a stacked menu
    //    'items'=>array(
    //        array('label'=>'Kelompok Menu',  'url'=>$this->createUrl('/sistemAdministrator/kelompokMenuK')),
    //        array('label'=>'Menu', 'url'=>$this->createUrl('/sistemAdministrator/menuModulK')),
    //
    //    ),
    //)); ?>
    <?php
    $this->breadcrumbs=array(
            'Sakelompok Menu Ks'=>array('index'),
            $model->kelmenu_id,
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','View').' Kelompok Menu ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Kelompok Menu', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Kelompok Menu', 'icon'=>'file', 'url'=>array('create')),
    //        array('label'=>Yii::t('mds','Update').' Kelompok Menu', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelmenu_id)),
    //	array('label'=>Yii::t('mds','Delete').' Kelompok Menu','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelmenu_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?'))),
    //	array('label'=>Yii::t('mds','Manage').' Kelompok Menu', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'kelmenu_id',
		'kelmenu_nama',
		'kelmenu_namalainnya',
		'kelmenu_key',
		'kelmenu_url',
		'kelmenu_urutan',
		'kelmenu_aktif',
            array(
                                            'label'=>'Aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->kelmenu_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                        ),
	),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="icon-pencil icon-white"></i>')),$this->createUrl('update',array('id'=>$model->kelmenu_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Menu', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/sistemAdministrator/kelompokMenuK/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>