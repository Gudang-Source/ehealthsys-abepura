<div class='white-container'>
    <legend class='rim2'>Lihat Jurnal <b>Rekening Penjamin</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jurnal Rekening Penjamin'=>array('index'),
            $model->penjamin_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Penjamin', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    array(
                        'label'=>'Cara Bayar',
                        'type'=>'raw',
                        'value'=>$model->penjamin->carabayar->carabayar_nama,
                    ),
                    array(
                        'label'=>'Penjamin',
                        'type'=>'raw',
                        'value'=>$model->penjamin->penjamin_nama,
                    ),
                     array(
                         'label'=>'Rekening Debit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_viewDebit',array('penjamin_id'=>$model->penjamin_id,'saldonormal'=>'D'),true),
                     ),
                     array(
                         'label'=>'Rekening Kredit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_viewKredit',array('penjamin_id'=>$model->penjamin_id,'saldonormal'=>'K'),true),
                     ),
                    array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->penjamin->penjamin_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jurnal Rekening Penjamin',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>