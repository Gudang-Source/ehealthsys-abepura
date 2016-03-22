<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'type'=>'horizontal',
                'id'=>'tarifambulance-m-search',
)); ?>
<table width="100%">
    <tr>
        <td width="33%">
            <div class="control-label"> Daftar Tindakan </div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'daftartindakan_id',array('id'=>'daftartindakan_id')) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
        //                                                                       'name'=>'daftartindakan_nama', 
                                                                   'model'=>$model,
                                                                   'attribute'=>'daftartindakan_nama',
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
                                                  array('empty'=>'-- Pilih --','id'=>'1TarifAmbulansM_kepropinsi_nama','onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                        'ajax'=>array('type'=>'POST',
                                                        'url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKabupaten',array('encode'=>false,'namaModel'=>'TarifAmbulansM')),
                                                                      'update'=>'#1TarifAmbulansM_kekabupaten_nama'))); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'kekabupaten_nama', array(), 
                                              array('empty'=>'-- Pilih --', 'id'=>'1TarifAmbulansM_kekabupaten_nama','onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                    'ajax'=>array('type'=>'POST',
                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKecamatan',array('encode'=>false,'namaModel'=>'TarifAmbulansM')),
                                                                  'update'=>'#1TarifAmbulansM_kekecamatan_nama'))); ?>
            <?php echo $form->dropDownListRow($model,'kekecamatan_nama', array(), 
                      array('empty'=>'-- Pilih --','id'=>'1TarifAmbulansM_kekecamatan_nama', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                            'ajax'=>array('type'=>'POST',
                                          'url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKelurahan',array('encode'=>false,'namaModel'=>'TarifAmbulansM')),
                                          'update'=>'#1TarifAmbulansM_kekelurahan_nama'))); ?>

            <?php echo $form->dropDownListRow($model,'kekelurahan_nama', array(), 
                      array('empty'=>'-- Pilih --', 'id'=>'1TarifAmbulansM_kekelurahan_nama','onkeypress'=>"return $(this).focusNextInputField(event)", 
                           )); ?>
        </td>
        <td>
            <?php //echo $form->textFieldRow($model,'tarifperkm',array('class'=>'span1')); ?>
            <?php echo $form->textFieldRow($model,'tarifambulans',array('class'=>'span1')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
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
                                                          \$(\"#TarifAmbulansM_daftartindakan_nama\").val(\"$data->daftartindakan_nama\");
                                                          \$(\"#dialogDaftartindakan\").dialog(\"close\");"
                             )
             )',
        ),
         array(
                    'name'=>'komponenunit_id',
                    'filter'=> CHtml::dropDownList('AMDaftartindakanM[komponenunit_id]',$modDaftartindakan->komponenunit_id,CHtml::listData($modDaftartindakan->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),array('empty'=>'--Pilih--')),
                    'value'=>'(isset($data->komponenunit->komponenunit_nama) ? $data->komponenunit->komponenunit_nama : "")',
            ),
         array(
                    'name'=>'kategoritindakan_id',
                    'filter'=> CHtml::dropDownList('AMDaftartindakanM[kategoritindakan_id]',$modDaftartindakan->kategoritindakan_id,CHtml::listData($modDaftartindakan->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('empty'=>'--Pilih--')),
                    'value'=>'(isset($data->kategoritindakan->kategoritindakan_nama) ? $data->kategoritindakan->kategoritindakan_nama : "")',
            ),
        array(
                    'name'=>'kelompoktindakan_id',
                    'filter'=> CHtml::dropDownList('AMDaftartindakanM[kelompoktindakan_id]',$modDaftartindakan->kelompoktindakan_id,CHtml::listData($modDaftartindakan->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),array('empty'=>'--Pilih--')),
                    'value'=>'(isset($data->kelompoktindakan->kelompoktindakan_nama) ? $data->kelompoktindakan->kelompoktindakan_nama : "")',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();?>