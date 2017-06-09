<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<div class="white-container">
    <legend class='rim2'>Retur Penerimaan <b>Persediaan Barang</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'gureturpenerimaan-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit' => 'return requiredCheck(this);'),
            'focus'=>'#',
    )); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    <?php if (isset($modTerima)) {
        $this->renderPartial('_dataTerima', array('modTerima'=>$modTerima, 'id'=>$id));
    }?>
    <hr />
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->hiddenField($model,'terimapersediaan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'noreturterima',array('class'=>'span3', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php //echo $form->textFieldRow($model,'tglreturterima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglreturterima', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglreturterima',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglreturterima'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'alasanreturterima',array('placeholder' => 'Ketik Alasan Retur','class'=>'span3 angkahuruf-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textAreaRow($model,'keterangan_retur',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'totalretur',array('style'=>'text-align: right; ','readonly'=>true,'class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'peg_retur_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'peg_mengetahui_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'peg_retur_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_retur_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute' => 'peg_retur_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                                            $(this).val( ui.item.label);
                                                                            return false;
                                                                        }',
                                'select' => 'js:function( event, ui ) {
                                                                            $("#'.Chtml::activeId($model, 'peg_retur_id') . '").val(pegawai_id); 
                                                                            return false;
                                                                        }',
                            ),
                            'htmlOptions' => array(
                                'class'=>'namaPegawai hurufs-only',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'peg_retur_id').'");'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_retur_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo Chtml::label("Pegawai Mengetahui <font style='color:red;'>*</font>", 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$model,
                            'attribute' => 'peg_mengetahui_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                                                            $(this).val( ui.item.label);
                                                                            return false;
                                                                        }',
                                'select' => 'js:function( event, ui ) {
                                                                            $("#'.Chtml::activeId($model, 'peg_mengetahui_id') . '").val(pegawai_id); 
                                                                            return false;
                                                                        }',
                            ),
                            'htmlOptions' => array(
                                'class'=>'namaPegawai hurufs-only required',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'peg_mengetahui_id').'");'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_mengetahui_id'); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <?php if (isset($modDetails)) {
        echo $form->errorSummary($modDetails);
    }?>
    <div class="block-tabel">
        <h6>Detail <b>Barang</b></h6>
        <?php $this->renderPartial('_tableDetailBarang', array('model'=>$model, 'form'=>$form, 'modDetails'=>$modDetails)); ?>
    </div>
    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php // echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('ReturpenerimaanT/index&id='.$modTerima->terimapersediaan_id), array('class'=>'btn btn-danger')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    "javascript:void(0);",array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
         <?php
                        $content = $this->renderPartial('../tips/informasi_returPenerimaan',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php 
$notif = Yii::t('mds','Do You want to cancel?');
$js = <<< JS
    
    function batal(obj){
        myConfirm("${notif}",'Perhatian!',function(r){
            if(!confirm("${notif}")) {
                return false;
            }else{
                $(obj).parents('tr').remove();
                rename();
            }
        });
    }
    
    function rename(){
        noUrut = 1;
        $('.cancel').each(function(){
            $(this).parents('tr').find('[name*="MutasibrgdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('MutasibrgdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','MutasibrgdetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
        });        
    }
    
    function cekRetur(obj){
        var terima = parseFloat($(obj).parents('tr').find('.terima').val());
        var retur = parseFloat($(obj).val());
            
        console.log(terima, retur);
            
        if (retur > terima){
            myAlert('Jumlah Retur tidak boleh lebih dari '+terima);
            $(obj).val(terima);
            hitungRetur();
            return false;
        }
            
        hitungRetur();
    }
    
    function openDialog(obj){
        $('#dialogPegawai').attr('parentClick',obj);
        $('#dialogPegawai').dialog('open');   
    }
JS;
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_HEAD);
?>

<?php 
Yii::app()->clientScript->registerScript('onready','
    $("form").submit(function(){
        retur = false;
        idRetur = $("#'.CHtml::activeId($model, 'peg_retur_id').'").val();
        alasan = $("#'.CHtml::activeId($model, 'alasanreturterima').'").val();

        $(".retur").each(function(){
            if ($(this).val() > 0){
                retur = true
            }
        });
        
        if (alasan == ""){
            myAlert("'.CHtml::encode($model->getAttributeLabel('alasanreturterima')).' harus diisi");
            return false;
        }
        else if (!jQuery.isNumeric(idRetur)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('peg_retur_id')).' harus diisi");
            return false;
        }
        
        if ($(".cancel").length < 0){
            myAlert("Detail Barang Harus Diisi");
            return false;
        }
        else if (retur == false){
            myAlert("'.CHtml::encode($model->getAttributeLabel('jmlretur')).' harus memiliki value yang lebih dari 0");
            return false;
        }
    });
',CClientScript::POS_READY);?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new GUPegawaiRuanganV('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GUPegawaiRuanganV']))
    $modPegawai->attributes = $_GET['GUPegawaiRuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->searchDialog(),
    'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'pegawai_id',
            array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    $(\"#\"+parent+\"\").val($data->pegawai_id);
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
            ),
            array(
                'header'=>'NIP',
                'name'=>'nomorindukpegawai',
                'value'=>'$data->nomorindukpegawai',
                'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
            ),
            array(
                'header'=>'Nama Pegawai',
                'name'=>'nama_pegawai',
                'value'=>'$data->namaLengkap',
                'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
            ),            
            array(
                'header' =>  'Jabatan',
                'name'=>'jabatan_id',
                'filter'=> CHtml::dropDownList('GUPegawaiRuanganV[jabatan_id]',$modPegawai->jabatan_id, Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
                'value'=> function($data){
                    $j = JabatanM::model()->findByPk($data->jabatan_id);
                    
                    if (count($j)>0){
                        return $j->jabatan_nama;
                    }else{
                        return '-';
                    }
                }
                ),
            //'alamat_pegawai',
            //'agama',
                    
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>


<script>

function hitungRetur() {
    var total = 0;
    $('#tableDetailBarang tbody tr').each(function()
    {
        var satuan = parseFloat(unformatNumber($(this).find(".satuan").val()));
        var retur = parseFloat($(this).find(".retur").val());
        
        total += (satuan * retur);
    });
    
    $("#GUReturpenerimaanT_totalretur").val(formatNumber(total));
}  

$(document).ready(function() {
    hitungRetur();
});

</script>