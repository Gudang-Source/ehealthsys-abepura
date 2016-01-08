<fieldset class="box">
    <legend class="rim">Lihat Transportasi</legend>
    <?php
    $this->breadcrumbs=array(
            'Rdtransportasi Ms'=>array('index'),
            $model->lookup_id,
    );

    $arrMenu = array();
					(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Transportasi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'lookup_id',
		'lookup_name',
		'lookup_urutan',
		'lookup_kode',
		array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->lookup_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                      ),
	),
    )); ?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Transportasi', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
    $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>