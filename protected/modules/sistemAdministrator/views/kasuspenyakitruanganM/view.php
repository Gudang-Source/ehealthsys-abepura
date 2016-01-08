<div class="white-container">
    <legend class="rim2">Lihat Kasus <b>Penyakit Ruangan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rjkasuspenyakitruangan Ms'=>array('index'),
            $model->ruangan_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kasus Penyakit Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kasus Penyakit Ruangan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'ruangan.ruangan_nama',
                    array(
                            'label'=>'Jenis Kasus',
                            'type'=>'raw',
                            'value'=>$this->renderPartial($this->path_view.'_kasuspenyakit', array('ruangan_id'=>$model->ruangan_id), true),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kasus Penyakit Ruangan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>