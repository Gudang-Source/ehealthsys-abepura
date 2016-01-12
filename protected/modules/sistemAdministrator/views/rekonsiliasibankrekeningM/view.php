<<<<<<< HEAD
<div class='white-container'>
    <legend class='rim2'>Lihat <b>Rekonsiliasi Bank Rekening</b></legend>
=======
<fieldset class="box">
    <legend class='rim'>Lihat Jurnal Rekening Penjamin</legend>
>>>>>>> 12f1e5a9c072640a387b6430d541776accbca7b2
    <?php
    $this->breadcrumbs=array(
            'Rekonsiliasi Bank Rekening'=>array('index'),
            $model->rekonsiliasibankrekening_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rekonsiliasi Bank Rekening', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    array(
                        'label'=>'Jenis Rekonsiliasi',
                        'type'=>'raw',
                        'value'=>$model->jenisrekonsiliasibank->jenisrekonsiliasibank_nama,
                    ),
                     array(
                         'label'=>'Rekening Debit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial($this->path_view.'_viewDebit',array('jenisrekonsiliasibank_id'=>$model->jenisrekonsiliasibank_id,'rekening5_nb'=>'D'),true),
                     ),
                     array(
                         'label'=>'Rekening Kredit',
                         'type'=>'raw',
                         'value'=>$this->renderPartial($this->path_view.'_viewKredit',array('jenisrekonsiliasibank_id'=>$model->jenisrekonsiliasibank_id,'rekening5_nb'=>'K'),true),
                     ),
                    array(            
                        'label'=>'Aktif',
                        'type'=>'raw',
                        'value'=>(($model->jenisrekonsiliasibank->jenisrekonsiliasibank_aktif==TRUE)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                    ),
            ),
    )); ?>

    <?php $this->widget('UserTips',array('type'=>'view'));?>
</fieldset>
