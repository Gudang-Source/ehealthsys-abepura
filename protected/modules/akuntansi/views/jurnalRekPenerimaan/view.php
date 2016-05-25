<div class='white-container'>
    <legend class='rim2'>Lihat Jurnal <b>Rekening Penerimaan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jenispenerimaan Ms'=>array('index'),
            $model->jenispenerimaan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rek Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    array(
                        'label'=>'Jenis Penerimaan',
                        'type'=>'raw',
                        'value'=>$model->jenispenerimaan_nama,
                    ),
                    array(
                        'label'=>'Nama Lain',
                        'type'=>'raw',
                        'value'=>$model->jenispenerimaan_namalain,
                    ),

                    array(
                        'label'=>'Kode',
                        'type'=>'raw',
                        'value'=>$model->jenispenerimaan_kode,
                    ),
                     array(
                         'label'=>'Rekening Debit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_viewDebit',array('jenispenerimaan_id'=>$model->jenispenerimaan_id,'saldonormal'=>'D'),true),
                     ),
                     array(
                         'label'=>'Rekening Kredit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_viewKredit',array('jenispenerimaan_id'=>$model->jenispenerimaan_id,'saldonormal'=>'K'),true),
                     ),
                    array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->jenispenerimaan_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jurnal Rekening Penerimaan',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>