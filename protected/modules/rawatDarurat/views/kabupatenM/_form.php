
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakabupaten-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#SAKabupatenM_propinsi_id',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
                
            <?php echo $form->dropDownListRow($model,'propinsi_id',  CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        
        <table id="tbl-kabupaten" class="table table-striped table-bordered table-condensed">
            <tr>
                <td>
                    <?php echo $form->textField($model,'[1]kabupaten_nama',array('class'=>'span3 required', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kabupaten_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'[1]kabupaten_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kabupaten_namalainnya'))); ?>
                </td>                
                <td>

                        <?php echo $form->textField($model,'[1]latitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                                                    array(
                                                            'class'=>'btn btn-primary btn-location',
                                                            'rel'=>'tooltip',
                                                            'id'=>'yw1',
                                                            'onclick' =>'changeSize()',
                                                            'title'=>'Klik untuk mencari Longitude & Latitude',)); ?>


                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'[1]longitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
               
                    <!--Extension location-picker latitude & longitude-->
                   <?php               

                           $this->widget('ext.LocationPicker2.CoordinatePicker', array(
                                   'model' => $model,
                                   'latitudeAttribute' => '[1]latitude',
                                   'longitudeAttribute' => '[1]longitude',
                                   //optional settings
                                   'editZoom' => 12,
                                   'pickZoom' => 7,
                                   'defaultLatitude' => $model->latitude,
                                   'defaultLongitude' => $model->longitude,
                           ));
                   ?>    
                </td>
                <td>
                    <?php echo CHtml::htmlButton( '<i class="icon-plus-sign icon-white"></i>', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
            
            <?php //echo $form->checkBoxRow($model,'kabupaten_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/kabupatenM/admin'), 
                                    array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelurahan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp"; ?>
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
    var tr = $('#tbl-kabupaten tr:first').html();
    $('#tbl-kabupaten tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kabupaten tr:last td:last').append('$buttonMinus');
    renameInput('RDKabupatenM','kabupaten_nama');
    renameInput('RDKabupatenM','kabupaten_namalainnya');
    renameInput('RDKabupatenM','latitude');
    renameInput('RDKabupatenM','longitude');    
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kabupaten tr').length;
    var i = 1;
    $('#tbl-kabupaten tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('RDKabupatenM','kabupaten_nama');
        renameInput('RDKabupatenM','kabupaten_namalainnya');
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKabupatenM_1_kabupaten_namalainnya').value = nama.value.toUpperCase();
    }
    
    function registerJSlocation(id,modelName,i)
     {
        $('#'+id).on('click', function(){ 
                $('#'+id).coordinate_picker({'lat_selector':'#'+modelName+'_'+i+'_latitude','long_selector':'#'+modelName+'_'+i+'_longitude','default_lat':'-7.091932','default_long':'107.672491','edit_zoom':12,'pick_zoom':7})                                
            });
                
    }
        
    function changeSize()
    {            
        window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
    }
</script>