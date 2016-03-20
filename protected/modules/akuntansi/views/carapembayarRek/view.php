<div class='white-container'>
    <legend class='rim2'>Lihat Jurnal <b>Rekening Cara Pembayaran</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Jurnal Rekening Cara Pembayaran'=>array('index'),
        $model->carapembayaran,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Cara Pembayaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Cara Pembayaran', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
        'data'=>$model,
        'attributes'=>array(

            array(
                        'label'=>'Cara Pembayaran',
                        'type'=>'raw',
                        'value'=>$model->carapembayaran,
                    ),
            array(
                        'label'=>'Rekening Debit',
                        'type'=>'raw',
                        'value'=>$this->renderPartial('_viewDebit',array('carapembayaran'=>$model->carapembayaran,'debitkredit'=>'D'),true),
                     ),
            array(
                        'label'=>'Rekening Kredit',
                        'type'=>'raw',
                        'value'=>$this->renderPartial('_viewDebit',array('carapembayaran'=>$model->carapembayaran,'debitkredit'=>'K'),true),
                     ),
        ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jurnal Rekening Cara Pembayaran',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>