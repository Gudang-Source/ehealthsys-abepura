<div class="white-container">
    <legend class="rim2">Lihat <b>Paket Pelayanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapaketpelayanan Ms'=>array('index'),
            $model->paketpelayanan_id,
    );
    $arrMenu = array();
    //	array_push($arrMenu,array('label'=>Yii::t('mds','View').' Paket Pelayanan #'.$model->paketpelayanan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'tipepaket.tipepaket_nama',
                    array(
                            'label'=>'Daftar Tindakan',
                            'type'=>'raw',
                            'value'=>$this->renderPartial($this->path_view.'_daftarTindakan',array('tipepaket_id'=>$model->tipepaket_id),true),
                     ),
                    'ruangan.ruangan_nama',
            ),
    )); ?>

    <?php 
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Paket Pelayanan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $this->widget('UserTips',array('type'=>'view'));
    ?>
</div>