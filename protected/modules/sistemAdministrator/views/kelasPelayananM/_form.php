
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelaspelayanan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAKelasPelayananM_jeniskelas_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
                
            <?php echo $form->dropDownListRow($model,'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        
        <table id="tbl-kelasPelayanan" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]kelaspelayanan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return nextFocus(this,event,'SAKelaspelayananM_kelaspelayanan_namalainnya','')", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kelaspelayanan_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]kelaspelayanan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'row1-plus','')", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kelaspelayanan_namalainnya'))); ?>
                </td>
                <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
            
            <?php //echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/kelasPelayananM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Pelayanan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
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
    renameInput('SAKelasPelayananM','kelaspelayanan_nama');
    renameInput('SAKelasPelayananM','kelaspelayanan_namalainnya');
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
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('SAKelasPelayananM','kelaspelayanan_nama');
			renameInput('SAKelasPelayananM','kelaspelayanan_namalainnya');
		}
	});
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKelasPelayananM_1_kelaspelayanan_namalainnya').value = nama.value.toUpperCase();
    }
</script>