<div class="white-container">
    <legend class="rim2">Pembayaran Resep <b>Obat Pasien</b></legend>
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

    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Rincian Tagihan <b>Obat & Alkes</b> <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setRincianObatalkes();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh rincian tagihan obat dan alkes')); ?></h6>
        <div id="form-rincianobatalkes">
            <?php $this->renderPartial($this->path_view.'_formRincianObatalkes', array('dataOas'=>$dataOas)); ?>
        </div>
        <fieldset class="box">
            <legend class="rim">Data Pembayaran</legend>
            <?php 
                if(isset($_GET['sukses'])){
                    Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan !");
                    $this->widget('bootstrap.widgets.BootAlert');
                }
            ?>
            <?php $this->renderPartial($this->path_view.'_formPembayaran', array('form'=>$form,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
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
                            echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincianOABelumBayar();return false",'disabled'=>FALSE  ));
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }else{
                            echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincianSudahBayar();return false",'disabled'=>FALSE  ));
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
    </div>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
    <?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
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
</div>
