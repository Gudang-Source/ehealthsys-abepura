
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'tarif-ambulans-m-form',
        'type'=>'horizontal',
	'enableAjaxValidation'=>false,
        'focus'=>'#daftartindakan',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p><br>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td width="33%">
            <div class="control-label"> Daftar Tindakan <font style="color:red">*</font> </div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'daftartindakan_id',array('id'=>'daftartindakan_id')); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                                                                   'name'=>'daftartindakan',
                                                                   'value'=>$model->daftartindakan->daftartindakan_nama,
                                                                    'source'=>'js: function(request, response) {
                                                                           $.ajax({
                                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/Daftartindakan').'",
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
                                                                                    $(this).val(ui.item.daftartindakan_nama);
                                                                                    return false;
                                                                                    }',
                                                                               'select'=>'js:function( event, ui ) {
                                                                                   $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                                                                                    return false;
                                                                                }',
                                                                    ),
                                                                    'htmlOptions'=>array(
                                                                        'readonly'=>false,
                                                                        'placeholder'=>'Daftar Tindakan',
                                                                        'size'=>13,
                                                                        'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                    ),
                                                                    'tombolDialog'=>array('idDialog'=>'dialogDaftartindakan'),
                                                            )); ?>
            </div>
            <?php echo $form->textFieldRow($model,'tarifambulans_kode',array('size'=>20,'maxlength'=>20,'class'=>'span2')); ?>
            <?php echo $form->dropDownListRow($model,'kepropinsi_nama', CHtml::listData($model->getPropinsiItems(), 'propinsi_nama', 'propinsi_nama'), 
                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                            'ajax'=>array('type'=>'POST',
                                          'url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKabupaten',array('encode'=>false,'namaModel'=>'TarifAmbulansM')),
                                          'update'=>'#TarifAmbulansM_kekabupaten_nama'))); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'kekabupaten_nama',CHtml::listData($model->getKabupatenItems(), 'kabupaten_nama', 'kabupaten_nama'),  
                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                            'ajax'=>array('type'=>'POST',
                                          'url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKecamatan',array('encode'=>false,'namaModel'=>'TarifAmbulansM')),
                                          'update'=>'#TarifAmbulansM_kekecamatan_nama'))); ?>

            <?php echo $form->dropDownListRow($model,'kekecamatan_nama', CHtml::listData($model->getKecamatanItems(), 'kecamatan_nama', 'kecamatan_nama'), 
                                 array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                       'ajax'=>array('type'=>'POST',
                                                     'url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKelurahan',array('encode'=>false,'namaModel'=>'TarifAmbulansM')),
                                                     'update'=>'#TarifAmbulansM_kekelurahan_nama'))); ?>

            <?php echo $form->dropDownListRow($model,'kekelurahan_nama', CHtml::listData($model->getKelurahanItems(),'kelurahan_nama','kelurahan_nama'), 
                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                           )); ?>
        </td>
        <td>
            <?php  echo $form->textFieldRow($model,'jmlkilometer',array('class'=>'span1 numbers-only')); ?>
            <?php echo $form->textFieldRow($model,'tarifperkm',array('class'=>'span2 integer')); ?>
            <?php echo $form->textFieldRow($model,'tarifambulans',array('class'=>'span2 integer')); ?>
        </td>
    </tr>
</table>
            
            <?php // echo $form->textFieldRow($model,'kepropinsi_nama',array('size'=>60,'maxlength'=>100)); ?>
            <?php // echo $form->textFieldRow($model,'kekabupaten_nama',array('size'=>60,'maxlength'=>100)); ?>
            <?php // echo $form->textFieldRow($model,'kekecamatan_nama',array('size'=>60,'maxlength'=>100)); ?>
            <?php // echo $form->textFieldRow($model,'kekelurahan_nama',array('size'=>60,'maxlength'=>100)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
    array('class'=>'btn btn-primary', 'type'=>'submit', 
        'onKeypress'=>'return formSubmit(this,event)',
        'id'=>'btn_simpan','onclick'=>'do_upload()',
       )); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
    Yii::app()->createUrl($this->module->id.'/tarifAmbulansM/admin'), 
    array('class'=>'btn btn-danger',
          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tarif Ambulans',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
    <?php
        $content = $this->renderPartial('../tarifAmbulansM/tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>

<?php

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDaftartindakan',
    'options'=>array(
        'title'=>'Pencarian Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
        ),
    ));
   
$modDaftartindakan = new AMDaftartindakanM('search');
$modDaftartindakan->unsetAttributes();
if(isset($_GET['AMDaftartindakanM'])) {
    $modDaftartindakan->attributes = $_GET['AMDaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftartindakan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modDaftartindakan->search(),
	'filter'=>$modDaftartindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectDaftartindakan",
                                        "onClick" => "\$(\"#daftartindakan_id\").val($data->daftartindakan_id);
                                                              \$(\"#daftartindakan\").val(\"$data->daftartindakan_nama\");
                                                              \$(\"#dialogDaftartindakan\").dialog(\"close\");"
                                 )
                 )',
            ),
             array(
                        'name'=>'komponenunit_id',
                        'filter'=>  CHtml::listData($modDaftartindakan->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),
                        'value'=>'(isset($data->komponenunit->komponenunit_nama) ? $data->komponenunit->komponenunit_nama : "")',
                ),
             array(
                        'name'=>'kategoritindakan_id',
                        'filter'=>  CHtml::listData($modDaftartindakan->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),
                        'value'=>'(isset($data->kategoritindakan->kategoritindakan_nama) ? $data->kategoritindakan->kategoritindakan_nama : "")',
                ),
            array(
                        'name'=>'kelompoktindakan_id',
                        'filter'=>  CHtml::listData($modDaftartindakan->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),
                        'value'=>'(isset($data->kelompoktindakan->kelompoktindakan_nama) ? $data->kelompoktindakan->kelompoktindakan_nama : "")',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ------------------------------------------------------------------- endWidget BarangM ----------------------------------------------------------------- */