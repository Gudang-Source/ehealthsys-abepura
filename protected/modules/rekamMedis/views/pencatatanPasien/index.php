<div class="white-container">
    <legend class="rim2">Pencatatan <b>Pasien</b></legend>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pasien-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return validasiInput()'),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#'.CHtml::activeId($modPasien,'no_rekam_medik'),
    )); ?>
    <?php 
    $model = new PPPendaftaranT;
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    
    <?php echo $form->errorSummary($modPasien); ?>
    <fieldset class="box" id="form-pasien">
        <legend class="rim"><span class='judul'>Data Pasien Baru </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPasienBaru();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk kembali ke Pasien Baru')); ?></span></legend>
        <div class="row-fluid">    
            <?php $this->renderPartial($this->path_view.'_formPasien', array('form'=>$form,'modPasien'=>$modPasien));?>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); ?>
                <?php 
                if($modPasien->isNewRecord){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); //formSubmit(this,event)
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                }
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'return refreshForm(this);'));  ?>
                <?php
                    if($modPasien->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKartuPasien('$modPasien->pasien_id');return false",'disabled'=>FALSE  )).'&nbsp;';
                    }
                ?>

                <?php 
                //$content = $this->renderPartial($this->path_view.'tips/tipsPendaftaranRawatJalan',array(),true);
                //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
    <hr />
    <?php $this->endWidget(); ?>
    
    <?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('modPasien'=>$modPasien, 'model'=>$model)); ?>

</div>
