
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapangkat-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAPangkatM_golonganpegawai_id',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),

)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
                
            <?php echo $form->dropDownListRow($model,'golonganpegawai_id',  CHtml::listData($model->GolonganPegawaiItems, 'golonganpegawai_id', 'golonganpegawai_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        
        <table id="tbl-pangkat" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]pangkat_nama',array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('pangkat_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]pangkat_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('pangkat_namalainnya'))); ?>
                </td>
                <td>
                    <?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
            
            <?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button','onKeypress'=>'formSubmit(this,event)','onclick'=>'formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.pangkatM.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-pangkat tr:first').html();
    $('#tbl-pangkat tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-pangkat tr:last td:last').append('$buttonMinus');
    renameInput('SAPangkatM','pangkat_nama');
    renameInput('SAPangkatM','pangkat_namalainnya');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-pangkat tr').length;
    var i = 1;
    $('#tbl-pangkat tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('SAPangkatM','pangkat_nama');
        renameInput('SAPangkatM','pangkat_namalainnya');
    }
}


JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>


