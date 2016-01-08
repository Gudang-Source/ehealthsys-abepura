<div class="white-container">
    <legend class="rim2">Pelayanan <b>Pasien</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pelayananpasien-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#instalasi_id',
    )); ?>
    <?php echo $form->errorSummary($modKunjungan); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modTandabukti); ?>

    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset>
        <?php 
        
//      RND-3402 >>  $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
//                'id'=>'riwayatpasien',
//                'content'=>array(
//                    'content-riwayatpasien'=>array(
//                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).'<b> Riwayat Pasien</b>',
//                        'isi'=>"<iframe id='frame-riwayatpasien' src='' width='100%' height='100%'></iframe>",
//                        'active'=>false,
//                        ),   
//                    ),
//        )); ?>
        
    </fieldset>
    <?php echo $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
    <div>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
    </div>
    <fieldset>
        <div class="row-fluid">
            <div class="form-actions">
                    <?php
//                      BELUM JELAS FUNGSINYA >>  echo CHtml::link(Yii::t('mds', '{icon} Verifikasi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-success','onclick'=>"printRincianSudahBayar();return false",'disabled'=>FALSE  ));
                        echo CHtml::link(Yii::t('mds', '{icon} Pembayaran', array('{icon}'=>'<i class="icon-file icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-success','onclick'=>"pembayaranTagihanPasien();return false",'disabled'=>FALSE  ));
                    ?>
                    <?php 
                        $content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                    ?> 
            </div>
        </div>
    </fieldset>
    <?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model,'modTandabukti'=>$modTandabukti)); ?>
    <?php $this->endWidget(); ?>
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-verifikasi',
        'options'=>array(
            'title'=>'Verifikasi Pembayaran',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>960,
            'minHeight'=>480,
            'resizable'=>false,
        ),
    ));

    echo '<div class="dialog-content"></div>';
    ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); $("#pelayananpasien-form").submit();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php
    //========= Dialog Detail dari riwayat pasien
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDetailData',
        'options' => array(
            'title' => 'Detail Data',
            'autoOpen' => false,
            'modal' => true,
            'width' => 500,
            'height' => 600,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="detailDialog" width="100%" height="500">
    </iframe>
    <?php
    $this->endWidget();
    ?>
</div>