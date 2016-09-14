<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'mobilambulance-m-search',
                'type'=>'horizontal',
                'focus'=>'#inventarisaset',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-label">Inventaris Aset</div>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'inventarisaset_id',array('id'=>'inventarisaset_id')) ?>
                <?php echo $form->textField($model, 'barang_nama',array('id'=>'brg_nama')) ?>
                <?php /*$this->widget('MyJuiAutoComplete', array(
                                                                   'name'=>'inventarisaset', 
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
                                                            ));*/ ?>
            </div>
        </td>  
        <td>    
                <?php //echo CHtml::label('Kode','mobilambulans_kode'); ?>
                <?php echo $form->textFieldRow($model,'mobilambulans_kode',array('size'=>20,'maxlength'=>20,'class'=>'span2')); ?>            
        </td>  
        <td>    
                <?php //echo CHtml::label('No Polisi','nopolisi'); ?>
                <?php echo $form->textFieldRow($model,'nopolisi',array('size'=>20,'maxlength'=>20,'class'=>'span1')); ?>
        </td>        
       <!-- <td>
            <?php //echo $form->textFieldRow($model,'kmterakhirkend',array('class'=>'span1')); ?>
        </td>-->
    </tr>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'jeniskendaraan',
                        CHtml::listData($model->JenisKendaraanItems, 'lookup_name', 'lookup_value'),
                        array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>            
        </td>
        <td>
            <?php //echo CHtml::label('harga BBM Liter','hargabbmliter'); ?>
            <?php echo $form->textFieldRow($model,'hargabbmliter',array('class'=>'span1')); ?>
        </td>
       <!-- <td>
            <?php //echo $form->textFieldRow($model,'isibbmliter',array('class'=>'span1')); ?>
        </td>-->
        <td>            
            <?php echo $form->checkBoxRow($model,'mobilambulans_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
    <tr>
        <td>
            
        </td>
        <td colspan="2">
            
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
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
                                                                          \$(\"#brg_nama\").val(\"$data->barang_nama\");
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

$this->endWidget();