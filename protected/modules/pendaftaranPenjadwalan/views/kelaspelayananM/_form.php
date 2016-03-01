
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppkelaspelayanan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'jeniskelas_id'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropDownListRow($model,'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>
        
        <table id="tbl-kelasPelayanan" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]kelaspelayanan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25,'placeholder'=>$model->getAttributeLabel('kelaspelayanan_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]kelaspelayanan_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25, 'placeholder'=> $model->getAttributeLabel('kelaspelayanan_namalainnya'))); ?>
                </td>
                <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('onkeyup'=>"return $(this).focusNextInputField(event);", 'class'=>'btn btn-primary','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/kelaspelayananM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
						
                           <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Pelayanan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                        $this->createUrl('/pendaftaranPenjadwalan/kelaspelayananM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit2b',array(),true);
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
    var tr = $('#tbl-kelasPelayanan tr:first').html();
    $('#tbl-kelasPelayanan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kelasPelayanan tr:last td:last').append('$buttonMinus');
    renameInput('PPKelaspelayananM','kelaspelayanan_nama');
    renameInput('PPKelaspelayananM','kelaspelayanan_namalainnya');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kelasPelayanan tr').length;
    var i = 1;
    $('#tbl-kelasPelayanan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('PPKelaspelayananM','kelaspelayanan_nama');
        renameInput('PPKelaspelayananM','kelaspelayanan_namalainnya');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('PPKelaspelayananM_1_kelaspelayanan_namalainnya').value = nama.value.toUpperCase();
    }
</script>