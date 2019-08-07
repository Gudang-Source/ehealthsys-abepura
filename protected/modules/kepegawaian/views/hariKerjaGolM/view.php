<fieldset class="white-container">
    <legend class="rim2">Lihat <b>Hari Kerja Golongan</b></legend>
<?php
$this->breadcrumbs=array(
	'Hari Kerja Golongan Ms'=>array('index'),
	$model->harikerjagol_id,
);

$arrMenu = array();
    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Hari Kerja Golongan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Hari Kerja Golongan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

//$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'harikerjagol_id',
		  'kelompokpegawai.kelompokpegawai_nama',
        array(
            'name' => 'periodeharikerjaawl',
            'value' => MyFormatter::formatDateTimeForUser($model->periodeharikerjaawl),
        ),    
        array(
            'name' => 'periodehariakhir',
            'value' => MyFormatter::formatDateTimeForUser($model->periodehariakhir),
        ),  
            array(
            'name' => 'periodeharikerjaakhir',
            'value' => MyFormatter::formatDateTimeForUser($model->periodeharikerjaakhir),
        ),  
	
             'jmlharibln',
        array(       
            'name'=>'harikerjagol_aktif',
            'type'=>'raw',
            'value'=>($model->harikerjagol_aktif==1)? "Aktif":"Tidak Aktif",
        ),
	),
)); ?>
<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Hari Kerja Golongan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('hariKerjaGolM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')).'&nbsp';?>
<?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>