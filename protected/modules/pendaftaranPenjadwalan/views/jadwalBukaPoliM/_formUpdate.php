<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppjadwal-buka-poli-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'ruangan_id'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table>
            <tr>
                <td>
                      <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                                          array('empty'=>'-- Pilih --',
                                                                                'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>    
                    <?php echo $form->dropDownListRow($model,'hari',  CustomFunction::getNamaHari() ,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'jmabuka',array('class'=>'span3','readonly'=>TRUE, 'onkeyup'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'jammulai', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'jammulai',
                                                        'mode'=>'time',
                                                        'options'=> array(
                                                            'onSelect'=>'js:function(){getJamBukaDariJamMulai(this);}',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                        ),
                                )); ?>
                                <?php echo $form->error($model, 'jammulai'); ?>
                            </div>
                     </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'jamtutup', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'jamtutup',
                                                        'mode'=>'time',
                                                        'options'=> array(
                                                            'onSelect'=>'js:function(){getJamBukaDariJamTutup(this);}',
                                                        ),    
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                        ),
                                )); ?>
                                <?php echo $form->error($model, 'jamtutup'); ?>
                            </div>
                     </div>
                    <?php echo $form->textFieldRow($model,'maxantiranpoli',array('class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
            
          
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/jadwalBukaPoliM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jadwal Buka Poli', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                        $this->createUrl('/pendaftaranPenjadwalan/jadwalBukaPoliM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit4',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    </div>

<?php $this->endWidget(); ?>

<?php
$idJamMulai=  CHtml::activeId($model, 'jammulai');
$idJamTutup=  CHtml::activeId($model, 'jamtutup');
$idJamBuka=  CHtml::activeId($model, 'jmabuka');
$jscript = <<< JS

function getJamBukaDariJamMulai(obj)
{
    jamMulai = obj.value;
    jamTutup = $('#${idJamTutup}').val();
    $('#${idJamBuka}').val(jamMulai+' s/d '+jamTutup);    
}  

function getJamBukaDariJamTutup(obj)
{
    jamMulai = $('#${idJamMulai}').val(); 
    jamTutup = obj.value;
    $('#${idJamBuka}').val(jamMulai+' s/d '+jamTutup);    
}

function numberOnly(obj)
{
    var d = $(obj).attr('numeric');
    var value = $(obj).val();
    var orignalValue = value;


    if (d == 'decimal') {
    value = value.replace(/\./, "");
    msg = "Only Numeric Values allowed.";
    }

    if (value != '') {
    orignalValue = orignalValue.replace(/([^1-9].*)/g, "")
    $(obj).val(orignalValue);
    }else{
    $(obj).val(1);
    }
}
JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>