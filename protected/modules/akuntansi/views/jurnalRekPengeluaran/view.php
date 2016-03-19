<div class='white-container'>
    <legend class='rim2'>Lihat Jurnal <b>Rekening Pengeluaran</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jenispengeluaran Ms'=>array('index'),
            $model->jenispengeluaran_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rek Pengeluaran ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Pengeluaran ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    array(
                        'label'=>'Jenis Pengeluaran',
                        'type'=>'raw',
                        'value'=>$model->jenispengeluaran->jenispengeluaran_nama,
                    ),
                    array(
                        'label'=>'Nama Lain',
                        'type'=>'raw',
                        'value'=>$model->jenispengeluaran->jenispengeluaran_namalain,
                    ),

                    array(
                        'label'=>'Kode',
                        'type'=>'raw',
                        'value'=>$model->jenispengeluaran->jenispengeluaran_kode,
                    ),
                    array(
                         'label'=>'Rekening Debit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_viewDebit',array('jenispengeluaran_id'=>$model->jenispengeluaran_id,'saldonormal'=>'D'),true),
                     ),
                     array(
                         'label'=>'Rekening Kredit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial('_viewKredit',array('jenispengeluaran_id'=>$model->jenispengeluaran_id,'saldonormal'=>'K'),true),
                     ),
                    array(            
                        'label'=>'Status',
                        'type'=>'raw',
                        'value'=>(($model->jenispengeluaran->jenispengeluaran_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jurnal Rekening Pengeluaran',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
</div>