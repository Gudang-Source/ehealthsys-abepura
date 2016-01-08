
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pppenjaminpasien-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#carabayar_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <div class="control-group">
            <?php echo CHtml::label('Cara bayar','carabayar_id',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php echo CHtml::dropDownList('carabayar_id','',CHtml::listData($model->CarabayarItems, 'carabayar_id', 'carabayar_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        
        <table id="tbl-penjaminPasien" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]penjamin_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('penjamin_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]penjamin_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('penjamin_namalainnya'))); ?>
                </td>
                <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array( 'onkeyup'=>"return $(this).focusNextInputField(event);", 'class'=>'btn btn-primary','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/penjaminpasienM/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
						
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                            $this->createUrl('/pendaftaranPenjadwalan/penjaminpasienM/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
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
    var tr = $('#tbl-penjaminPasien tr:first').html();
    $('#tbl-penjaminPasien tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-penjaminPasien tr:last td:last').append('$buttonMinus');
    renameInput('PPPenjaminpasienM','penjamin_nama');
    renameInput('PPPenjaminpasienM','penjamin_namalainnya');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-penjaminPasien tr').length;
    var i = 1;
    $('#tbl-penjaminPasien tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('SAKelasPenjaminPasienM','penjamin_nama');
        renameInput('SAKelasPenjaminPasienM','penjamin_namalainnya');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('PPPenjaminpasienM_1_penjamin_namalainnya').value = nama.value.toUpperCase();
    }
</script>