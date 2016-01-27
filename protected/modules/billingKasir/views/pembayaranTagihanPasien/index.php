<div class="white-container">
    <legend class="rim2">Pembayaran <b>Tagihan Pasien</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'bkpembayaranpelayanan-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#instalasi_id',
    )); ?>
    <?php echo $form->errorSummary($modKunjungan); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modTandabukti); ?>
    <?php echo $form->errorSummary($modPemakaianuangmuka); ?>
    <?php /*
    <div class="control-group">
        <?php echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));?>
        <div class="controls">
            <?php //echo $form->hiddenField($model,'antrian_id',array('readonly'=>true));?>
            <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id,CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama'),array('class'=>'span2','empty'=>'-- Pilih --','onchange'=>'setFormAntrian("reset");') )?>
            <?php echo CHtml::textField('noantrian',$modAntrian->noantrian,array('readonly'=>true,'class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('id'=>'btn-panggilantrian','title'=>'Klik untuk menampilkan form antrian','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'$("#dialog-panggilantrian").dialog("open");')); ?>
        </div>
    </div>
     * 
     * 
     */ ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Rincian <b>Tagihan Tindakan</b> <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setRincianTindakan();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh rincian tagihan tindakan')); ?></h6>
        <div style="overflow-x: auto; max-width: 100%;" id="form-rinciantindakan">
            <?php $this->renderPartial('_formRincianTindakan', array('dataTindakans'=>$dataTindakans)); ?>
        </div>
    </div>
    <div class="block-tabel">
        <h6>Rincian Tagihan <b>Obat & Alkes</b> <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setRincianObatalkes();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh rincian tagihan obat dan alkes')); ?></h6>
        <div style="overflow-x: auto; max-width: 100%;" id="form-rincianobatalkes">
            <?php $this->renderPartial('_formRincianObatalkes', array('dataOas'=>$dataOas)); ?>
        </div><hr />
        <div id="form-rinciansemua">
            <?php $this->renderPartial('_formRincianTotal', array()); ?>
        </div>
    </div>
    <fieldset class="box">
        <legend class="rim">Data Pembayaran</legend>
        <?php 
            if(isset($_GET['sukses'])){
                Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan !");
                $this->widget('bootstrap.widgets.BootAlert');
            }
        ?>
        <?php $this->renderPartial('_formPembayaran', array('form'=>$form,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    if($model->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); //formSubmit(this,event)
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                    }
                ?>
                <?php
                    if(!isset($_GET['frame'])){
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'return refreshForm(this);'));
                    }
                ?>
                <?php
                    if($model->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincianBelumBayar();return false",'disabled'=>FALSE  ));
                        echo "&nbsp;";
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian RS', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincianSudahBayar();return false",'disabled'=>FALSE  ));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian RS', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincianRSSudahBayar();return false",'disabled'=>FALSE  ));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printBuktiKasMasuk();return false",'disabled'=>FALSE  ));
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKuitansi();return false",'disabled'=>FALSE  ));
                    }
                ?>
                <?php 
                    $content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
    <?php echo $this->renderPartial($this->path_view.'_jsFunctionsAntrian', array('modAntrian'=>$modAntrian)); ?>
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
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); $("#bkpembayaranpelayanan-t-form").submit();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <?php /*
    $autoopen = Yii::app()->user->getState('isantrian');
    if(!empty($model->pendaftaran_id)){
        $autoopen = false;
    }
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-panggilantrian',
        'options'=>array(
            'title'=>'No. Antrian',
            'autoOpen'=>$autoopen,
            'width'=>180,
            'resizable'=>false,
            'position'=>array("right",140),
        ),
    ));
    ?>
    <div class="dialog-content">
        <?php echo $this->renderPartial($this->path_view.'_formPanggilAntrian', array('modAntrian'=>$modAntrian)); ?>
    </div>

    <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-backward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian sebelumnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("prev");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-forward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian berikutnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("next");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('title'=>'Klik untuk mengulang antrian','rel'=>'tooltip','class'=>'btn btn-mini btn-danger','onclick'=>'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
        <br>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Panggil / Daftar',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian();}','style'=>'font-size:10px; width:128px; height:24px;')); ?>
    </div>
    <?php $this->endWidget(); */ ?>
</div>