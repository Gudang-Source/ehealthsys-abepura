<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabarang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'bidang_id'),
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<table width='100%'>
    <tr>
        <td>            
            <?php //golongan
                  echo $form->dropDownListRow($model,'golongan_id', CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('/ActionDynamic/GetBidang',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'bidang_id'),
                                ),
                                'onchange'=>"setClearBidang();setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",));?>
            
            <?php //bidang //CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama')
                  echo $form->dropDownListRow($model,'bidang_id', array(), 
                        array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('/ActionDynamic/GetKelompok',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'kelompok_id'),
                                ),
                                'onchange'=>"setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",));?>
            
             <?php //kelompok //CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama')
                    echo $form->dropDownListRow($model,'kelompok_id', array(), 
                        array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('/ActionDynamic/GetSubKelompok',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'subkelompok_id'),
                                ),
                                'onchange'=>"setClearSubKelompok();setClearSubSubKelompok();",));?>
            
            <?php //subkelompok //CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama')
                    echo $form->dropDownListRow($model,'subkelompok_id', array(), 
                        array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('/ActionDynamic/GetSubSubKelompok',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'subsubkelompok_id'),
                                ),
                                'onchange'=>"setClearSubSubKelompok();",));?>
            
            <?php //subsubkelompok //CHtml::listData($model->SubSubKelompokItems, 'subsubkelompok_id', 'subsubkelompok_nama')
                    echo $form->dropDownListRow($model,'subsubkelompok_id',array(),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)"));                    
                    ?>
            <!--            <div class="control-group ">
                                <label class="control-label" for="bidang">Bidang</label>
                                <div class="controls">-->
            <?php //echo $form->hiddenField($model,'bidang_id'); ?>
            <?php /*
              $this->widget('MyJuiAutoComplete', array(

              'name'=>'bidangNama',
              'source'=>'js: function(request, response) {
              $.ajax({
              url: "'.Yii::app()->createUrl('ActionAutoComplete/getBidang').'",
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
              'minLength' => 2,
              'focus'=> 'js:function( event, ui ) {
              $(this).val( ui.item.label);
              return false;
              }',
              'select'=>'js:function( event, ui ) {
              $("#'.CHtml::activeId($model, 'bidang_id').'").val(ui.item.bidang_id);
              $("#bidangNama").val(ui.item.bidang_nama);
              return false;
              }',
              ),
              'htmlOptions'=>array(
              'onkeypress'=>"return $(this).focusNextInputField(event)",
              ),
              'tombolDialog'=>array('idDialog'=>'dialogBidang'),
              ));
             */ ?>

            <?php           
            echo $form->dropDownListRow($model, 'barang_type', LookupM::getItems('barangumumtype'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'));
            ?>   
            <?php Echo CHtml::hiddenField('tempKode', $model->barang_kode); ?>            
            <?php echo $form->textFieldRow($model, 'barang_kode', array('class' => 'span2 ',  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,)); //'onkeyup' => 'setKode(this);',?>            
            <?php echo $form->textFieldRow($model, 'barang_nama', array('class' => 'span2', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'barang_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>   
            <?php echo $form->textFieldRow($model, 'barang_merk', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>    
            <?php echo $form->textFieldRow($model, 'barang_noseri', array('class' => 'span2 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>    
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'barang_ukuran', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->textFieldRow($model, 'barang_bahan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            <?php echo $form->textFieldRow($model, 'barang_thnbeli', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5, 'style'=>'text-align:right;')); ?>    
            <?php echo $form->textFieldRow($model, 'barang_warna', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>    
            <?php //echo $form->checkBoxRow($model,'barang_statusregister', array('onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>    
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'barang_ekonomis_thn', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'barang_ekonomis_thn', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style'=>'text-align:right;')) . ' tahun '; ?> 
                </div>
            </div>

            <?php
                echo $form->dropDownListRow($model, 'barang_satuan', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
            ));
            ?>   
            <?php echo $form->textFieldRow($model, 'barang_jmldlmkemasan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align:right;')); ?>
        </td>
        <td>   
            <?php echo $form->textFieldRow($model, 'barang_harganetto', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
            <?php echo $form->textFieldRow($model, 'barang_persendiskon', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
            <?php echo $form->textFieldRow($model, 'barang_ppn', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
            <?php echo $form->textFieldRow($model, 'barang_hpp', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
            <?php echo $form->textFieldRow($model, 'barang_hargajual', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>    
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'barang_image', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                <div class="controls">  
                    <?php echo Chtml::activeFileField($model, 'barang_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
                </div>
            </div>
        </td>                   
        <?php //echo $form->checkBoxRow($model,'barang_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
    </tr>
</table>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo "&nbsp;";
    ?>
    
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('/gudangUmum/BarangMGU', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php
    $content = $this->renderPartial($this->path_tips.'tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
/*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBidang',
    'options' => array(
        'title' => 'Bidang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modBidang = new GUBidangM('search');
$modBidang->unsetAttributes();
if (isset($_GET['GUBidangM']))
    $modBidang->attributes = $_GET['GUBidangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modBidang->search(),
    'filter' => $modBidang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'bidang_id') . '\").val(\'$data->bidang_id\');
                                    $(\"#bidangNama\").val(\'$data->bidangNama\');
                                    $(\'#dialogBidang\').dialog(\'close\');return false;"))'
        ),
        array(
            'header' => 'Golongan',
            'filter' => CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
            'value' => '$data->subkelompok->kelompok->golongan->golongan_nama',
        ),
        array(
            'header' => 'Kelompok',
            'filter' => CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
            'value' => '$data->subkelompok->kelompok->kelompok_nama',
        ),
        array(
            'header' => 'Sub Kelompok',
            'filter' => CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
            'value' => '$data->subkelompok->subkelompok_nama',
        ),
        array(
            'name' => 'bidang_id',
            'filter' => CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
            'value' => '$data->bidang_nama',
        ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();*/
?>

<?php Yii::app()->clientScript->registerScript('head', '
    function setKode(obj){
        var value = $("#tempKode").val();
        var objValue = $(obj).val();
        if (objValue < value){
           $(obj).val(value);
        }
    }
', CClientScript::POS_HEAD); ?>
<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SABarangM_barang_namalainnya').value = nama.value.toUpperCase();
    }
    
    function setClearBidang()
    {
        $("#<?php echo CHtml::activeId($model,"bidang_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    
    function setClearKelompok()
    {
        $("#<?php echo CHtml::activeId($model,"kelompok_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    
    function setClearSubKelompok()
    {
        $("#<?php echo CHtml::activeId($model,"subkelompok_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    
    function setClearSubSubKelompok()
    {
        $("#<?php echo CHtml::activeId($model,"subsubkelompok_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
</script>