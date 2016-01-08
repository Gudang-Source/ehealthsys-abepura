
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'mobil-ambulans-m-form',
        'type'=>'horizontal',
	'enableAjaxValidation'=>false,
        'focus'=>'#inventarisaset',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p><br>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-label">Inventaris Aset *</div>
            <div class="controls">
                <?php echo $form->hiddenField($model,'inventarisaset_id',array('id'=>'inventarisaset_id')) ?>
                <?php $barang = BarangM::model()->find("barang_id='$model->inventarisaset_id'"); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                                                                   'name'=>'inventarisaset',
                                                                    'value'=>$barang->barang_nama,
                                                                    'source'=>'js: function(request, response) {
                                                                           $.ajax({
                                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/Barang').'",
                                                                               dataType: "json",
                                                                               data: {
                                                                                   term: request.term,
                                                                               },
                                                                               success: function (data) {
                                                                                       response(data);
                                                                               }
                                                                           })
                                                                        }',
                                                                    'options'=>array(
                                                                               'showAnim'=>'fold',
                                                                               'minLength' => 1,
                                                                               'focus'=> 'js:function( event, ui )
                                                                                   {
                                                                                    $(this).val(ui.item.barang_nama);
                                                                                    return false;
                                                                                    }',
                                                                               'select'=>'js:function( event, ui ) {
                                                                                   $("#alatmedis_noaset").val(ui.item.barang_id);
                                                                                    return false;
                                                                                }',
                                                                    ),
                                                                    'htmlOptions'=>array(
                                                                        'readonly'=>false,
                                                                        'placeholder'=>'No. Aset',
                                                                        'size'=>13,
                                                                        'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                    ),
                                                                    'tombolDialog'=>array('idDialog'=>'dialogbarang'),
                                                            )); ?>
            </div>
            <?php echo $form->textFieldRow($model,'mobilambulans_kode',array('size'=>20,'maxlength'=>20,'class'=>'span2')); ?>
            <?php echo $form->textFieldRow($model,'nopolisi',array('size'=>20,'maxlength'=>20,'class'=>'span1')); ?>
            <?php echo $form->dropDownListRow($model,'jeniskendaraan',
            CHtml::listData($model->JenisKendaraanItems, 'lookup_name', 'lookup_value'),
            array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'isibbmliter',array('class'=>'span1 numbers-only')); ?>
            <?php echo $form->textFieldRow($model,'kmterakhirkend',array('class'=>'span1 numbers-only')); ?>
            <?php echo $form->FileFieldRow($model,'photokendaraan',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->textFieldRow($model,'hargabbmliter',array('class'=>'span2 integer')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'formulajasars',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'formulajasaba',array('size'=>50,'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'formulajasapel',array('size'=>50,'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'mobilambulans_aktif'); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit', 
                'onKeypress'=>'return formSubmit(this,event)',
                'id'=>'btn_simpan','onclick'=>'do_upload()',
       )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
            Yii::app()->createUrl($this->module->id.'/mobilAmbulansM/admin'), 
            array('class'=>'btn btn-danger',
                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
    ?>	
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Mobil Ambulans',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php 
        $content = $this->renderPartial('../mobilAmbulansM/tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
</div>

<?php $this->endWidget(); ?>

<?php

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogbarang',
    'options'=>array(
        'title'=>'Pencarian No. Aset',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
        ),
    ));
   
$modBarang = new AMBarangM('search');
$modBarang->unsetAttributes();
if(isset($_GET['AMBarangM'])) {
    $modBarang->attributes = $_GET['AMBarangM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'barang-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modBarang->search(),
	'filter'=>$modBarang,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectbarang",
                                                    "onClick" => "\$(\"#inventarisaset_id\").val($data->barang_id);
                                                                          \$(\"#inventarisaset\").val(\"$data->barang_nama\");
                                                                          \$(\"#dialogbarang\").dialog(\"close\");"
                                             )
                             )',
                        ),
                'barang_type',
                'barang_kode',
                'barang_nama',
                'barang_satuan',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget(); ?>
<!-- ------------------------------------------------------------------- endWidget BarangM ----------------------------------------------------------------- */ -->