<legend class="rim2">Ambil Karcis Kasir</legend>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="row-fluid">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'ambilkarciskasir-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
        'focus'=>'#instalasi_id',
)); ?>
    <?php echo $form->errorSummary($modKunjungan); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="span12">
        <fieldset id="form-datakunjungan">
            <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
            <div class="row-fluid box">
                <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
            </div>
        </fieldset>
    </div>
    <div class="span12">
            <legend class="rim">Buat Karcis</legend>
            <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
                <?php echo $form->textFieldRow($model,'tglantrian',array('class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'ruangan_id', $model->getListRuangans(),array('class'=>'span3','empty'=>'-- Pilih --') )?>
                <?php echo $form->textFieldRow($model,'noantrian',array('readonly'=>true,'placeholder'=>'Otomatis','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
            <div class="form-actions">
                    <?php 
                    if($model->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>true,'class'=>'btn btn-primary', 'type'=>'button','style'=>'cursor:not-allowed;')); 
                    }
                    ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('index').'";}); return false;'));  ?>
                    <?php 
                        if(isset($_GET['id'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn btn-info', 'type'=>'button','onclick'=>'printKarcisKasir('.$model->antrian_id.',\'PRINT\')')); 
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn btn-info', 'disabled'=>true,'type'=>'button','style'=>'cursor:not-allowed;')); 
                        }
                    ?>
                    <?php 
                        $content = $this->renderPartial('tips/tips',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                    ?> 
            </div>
    </div>
<?php $this->endWidget(); ?>
<div class="span12">
        <?php echo $this->renderPartial('_tableKarcisTerakhir'); ?>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model)); ?>
