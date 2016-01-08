<div class="white-container">
    <legend class="rim2">Lihat Kasus <b>Penyakit Obat</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rjkasuspenyakitdiagnosa Ms'=>array('index'),
            $model->jeniskasuspenyakit_id,
    );

    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Kasus Penyakit ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php 
    $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data'=>$model,
            'attributes'=>array(
    //		'jeniskasuspenyakit_nama',
                array(
                    'label'=>'Jenis Kasus Penyakit',
                    'type'=>'raw',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ),
                array(
                    'label'=>'Obat Alkes',
                    'type'=>'raw',
                    'value'=>$this->renderPartial('_obatalkes', array('jeniskasuspenyakit_id'=>$model->jeniskasuspenyakit_id), true),
                ),
            ),
    )); 
    ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>