
<style>
    .cols_hide{
        display:none;
    }
</style>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'satipe-paket-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'kelaspelayanan_id'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table class="table">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'SATipePaketM')), 
                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').'' //selector to update
                                                ),
                                            ));
                    ?>
                    <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData(SAPendaftaranT::model()->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    <?php echo $form->textFieldRow($model,'tipepaket_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'tipepaket_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'tipepaket_singkatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
                <td>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model,'tglkesepakatantarif', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglkesepakatantarif',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )); ?>
                            <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model,'nokesepakatantarif',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'nourut_tipepaket',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model,'keterangan_tipepaket',array('rows'=>2, 'cols'=>5, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->checkBoxRow($model,'tipepaket_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
                <table id="tableObatAlkes" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th><?php echo $form->labelEx($model,'tarifpaket'); ?></th>
                    <th><?php echo $form->labelEx($model,'paketsubsidiasuransi'); ?></th>
                    <th class="cols_hide"><?php echo $form->labelEx($model,'paketsubsidipemerintah'); ?></th>
                    <th><?php echo $form->labelEx($model,'paketsubsidirs'); ?></th>
                    <th><?php echo $form->labelEx($model,'paketiurbiaya'); ?></th>
                </tr>
            </thead>
            <tbody>   
                <tr>
                    <td>
                        <?php echo $form->textField($model, 'tarifpaket', array('class' => 'span2 numbersOnly', 'onblur'=>'validasiInputan(this);','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'paketsubsidiasuransi', array('class' => 'span2 numbersOnly harga','onblur'=>'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td class="cols_hide">
                        <?php echo $form->textField($model, 'paketsubsidipemerintah', array('class' => 'span2 numbersOnly harga','onblur'=>'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'paketsubsidirs', array('class' => 'span2 numbersOnly harga','onblur'=>'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($model, 'paketiurbiaya', array('class' => 'span2 numbersOnly harga','onblur'=>'validasiInputan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'tglkesepakatantarif'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
            

	<div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/tipePaketM/admin'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php
                $content = $this->renderPartial('sistemAdministrator.views.tips/tips',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tipe Paket', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
        </div>

<?php $this->endWidget(); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php 
$tarif = CHtml::activeId($model, 'tarifpaket'); 
Yii::app()->clientScript->registerScript('onheadaturan','
    function validasiInputan(obj){
        tarif = parseFloat($("#'.$tarif.'").val());
        tarifobj = parseFloat($(obj).val());
        id = $(obj).attr("id");
        totaltarif = 0;
        $(".harga").each(function(){
            totaltarif += parseFloat($(this).val());
        });
        if (id == "'.$tarif.'"){
            $(".harga").val(0);
        }
        else{
            
            if (totaltarif > tarif){
                if (tarifobj < tarif){
                    $(".harga").val(0);
                    $(obj).val(tarifobj);
                } else {
                    $(".harga").val(0);
                    $(obj).val(tarif);
                }
            }
        }
    }
',CClientScript::POS_HEAD); ?>

