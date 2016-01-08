<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0){
    Yii::app()->user->setFlash('success',"Transaksi Pengambilan Jenazah berhasil disimpan !");
}

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="white-container">
    <legend class="rim2">Transaksi <b>Pengambilan Jenazah</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'ambiljenazah-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
    )); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php //echo $form->errorSummary(array($model,$modPenyBarangs[0])); ?>
            
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model,'pasien_id',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<!--                <div class="control-group ">
                    <?php //echo CHtml::activeLabel($model, 'no_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
//                            $this->widget('MyJuiAutoComplete', array(
//                                'model' => $model,
//                                'attribute' => 'no_pendaftaran',
//                                'value' => '',
//                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/NoPendaftaranJenazah'),
//                                'options' => array(
//                                    'showAnim' => 'fold',
//                                    'minLength' => 2,
//                                    'focus' => 'js:function( event, ui ) {
//                                            $(this).val( ui.item.label);
//
//                                            return false;
//                                        }',
//                                    'select' => 'js:function( event, ui ) {
//                                              $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);
//                                              $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
//                                              $("#' . CHtml::activeId($model, 'no_rekam_medik') . '").val(ui.item.no_rekam_medik);
//                                              setRuanganMeninggal(ui.item.instalasiasal_id,ui.item.ruanganasal_id);
//                                          }',
//                                ),
//                                'tombolDialog'=>array('idDialog'=>'dialogPendaftaran'),
//                                'htmlOptions'=>array('class'=>'span2','placeholder'=>'Ketik No. Pendaftaran'),
//                            ));
//                        ?>
                    </div>
                </div>-->
                <?php //echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'no_rekam_medik',array('class'=>'control-label required')); ?>
                    <div class="controls">
                     <?php 
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienJenazah'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                          $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.nama_pasien);
                                          $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.jeniskelamin);
                                          $("#' . CHtml::activeId($model, 'no_pendaftaran') . '").val(ui.item.nama_bin);
                                      }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array(
                                    'class'=>'span2',
                                    'placeholder'=>'Ketikan No. Rekam Medis',
                                ),
                        ));
                    
                ?>
           
                    </div>
                </div>
                
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglmeninggal',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tglmeninggal',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                'maxDate' => 'd',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>false,'class'=>'dtPicker2-5'),
                                    )); 
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'tglpengambilan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglpengambilan',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tglpengambilan',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                'maxDate' => 'd',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>false,'class'=>'dtPicker2-5'),
                                    )); 
                        ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model,'keterangan_pengambilan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'ruanganmeninggal_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td width="33%">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'ruanganmeninggal_id',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'instalasi_id', $instalasi, 
                                        array('class'=>'span3','empty' =>'-- Instalasi --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                                        'ajax'=>array('type'=>'POST',
                                                                                'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                                                                'update'=>"#".CHtml::activeId($model, 'ruanganmeninggal_id'),
                                                        )));?>
                    <br />
                        <?php echo $form->dropDownList($model,'ruanganmeninggal_id',$ruanganMeninggal,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty' =>'-- Ruangan --')); ?>   
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'nama_pengambiljenazah',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <div class="control-group ">
                        <?php echo $form->labelEx($model,'hubungan_pengjenazah', array('class'=>'control-label refreshable')) ?>
                        <div class="controls">
                                <?php echo $form->dropDownList($model,'hubungan_pengjenazah', LookupM::getItems('hubungankeluarga'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
                        </div>
                </div>
            </td>
            <td>                
                <?php echo $form->textFieldRow($model,'noidentitas_pengjenazah',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textAreaRow($model,'alamat_pengjenazah',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'notelepon_pengjenazah',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            </td>
        </tr>
    </table>
    
    <table id="tblPenyBarang" class="table table-striped">
        <thead>
            <tr>
                <th>No. Urut <span class="required">*</span></th>
                <th>Jenis Jenazah</th>
                <th>Nama Jenazah<span class="required">*</span></th>
                <th>Keadaan Jenazah</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php $this->renderPartial('_formPenyBarang',array('modPenyBarang'=>$modPenyBarang,'modPenyBarangs'=>$modPenyBarangs,'removeButton'=>false)); ?>
        </tbody>
    </table>
    
    <div class="form-actions">
        <?php echo 

            CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekDetail();', 'onkeypress'=>'cekDetail();')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl('Index'), 
                array('class'=>'btn btn-danger',
                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('Index').'";}); return false;'));  ?>
        <?php 
            $content = $this->renderPartial('../pemakaianMobil/tips/transaksi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
var trPenyBarang=new String(<?php echo CJSON::encode($this->renderPartial('_formPenyBarang',array('modPenyBarang'=>$modPenyBarang,'removeButton'=>true),true));?>);
var trPenyBarangFirst=new String(<?php echo CJSON::encode($this->renderPartial('_formPenyBarang',array('modPenyBarang'=>$modPenyBarang,'removeButton'=>false),true));?>);

function addPenyBarang(obj)
{
    $(obj).parents('table').children('tbody').append(trPenyBarang.replace());
    <?php 
        $attributes = $modPenyBarang->attributeNames();
        foreach($attributes as $i=>$attribute){
            echo "renameInput('".get_class($modPenyBarang)."','$attribute');";
        }
    ?>
    buatNoUrut();
}

function buatNoUrut()
{
    var i = 0;
    $('input[name$="[no_urutbrg]"]').each(function(){
        i++; $(this).val(i);
    });
}

function batalPenyBarang(obj)
{
    myConfirm("Apakah anda yakin akan membatalkan?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').detach();
            buatNoUrut();
        }
    });
}

function renameInput(modelName,attributeName)
{
    var i = -1;
    $('#tblPenyBarang tr').each(function(){
        if($(this).has('input[name$="[no_urutbrg]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function setRuanganMeninggal(instalasiasalId,ruanganasalId)
{
    $("#instalasi").val(instalasiasalId);
    $("#instalasi").change();
    myAlert('Otomatis mengambil dari instalasi/ruangan/unit pasien terakhir diperiksa');$("#<?php echo CHtml::activeId($model, 'ruanganmeninggal_id') ?>").val(ruanganasalId);
}

function cekDetail(){
    if(requiredCheck($("form"))){
        var pasien_id = $('#pasien_id').val();
        var nama_barang = '';
        $('#tblPenyBarang tr').each(function(){
            nama_barang = $(this).find('input[name$="[namabarang_pasien]"]').val();
        });
        
        if(nama_barang == ''){
                myAlert('Isikan detail jenazah terlebih dahulu.');
            return false;
        }else{
            $('#ambiljenazah-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;    
}
</script>
   
<?php
//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPasien = new PasienmasukpenunjangV('searchJenazah');
$modPasien->unsetAttributes();
if (isset($_GET['PasienmasukpenunjangV'])) {
    $modPasien->attributes = $_GET['PasienmasukpenunjangV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchJenazah(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#PJAmbiljenazahT_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                                          $(\"#PJAmbiljenazahT_jeniskelamin\").val(\"$data->jeniskelamin\");
                                                          $(\"#PJAmbiljenazahT_nama_pasien\").val(\"$data->nama_pasien\");                                                        
                                                          $(\"#PJAmbiljenazahT_pendaftaran_id\").val(\"$data->pendaftaran_id\");                                                        
                                                          $(\"#PJAmbiljenazahT_pasien_id\").val(\"$data->pasien_id\");                                                        
                                                          $(\"#dialogPasien\").dialog(\"close\");    
                                                          
                                                "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Dialog Pasien =============================
?>

<?php
////========= Dialog buat cari data Pendaftaran=========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogPasien',
//    'options' => array(
//        'title' => 'Pencarian Pasien',
//        'autoOpen' => false,
//        'modal' => true,
//        'width' => 900,
//        'height' => 600,
//        'resizable' => false,
//    ),
//));
//
//$modPasien = new PasienmasukpenunjangV('searchJenazah');
//$modPasien->unsetAttributes();
//if (isset($_GET['PasienmasukpenunjangV'])) {
//    $modPasien->attributes = $_GET['PasienmasukpenunjangV'];
//}
//$this->widget('ext.bootstrap.widgets.BootGridView', array(
//    'id' => 'pasien-m-grid',
//    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
//    'dataProvider' => $modPasien->searchJenazah(),
//    'filter' => $modPasien,
//    'template' => "{summary}\n{items}\n{pager}",
//    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//    'columns' => array(
//        array(
//            'header' => 'Pilih',
//            'type' => 'raw',
//            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//                                            "id" => "selectPasien",
//                                            "onClick" => "$(\"#PJAmbiljenazahT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
//                                                          $(\"#PJAmbiljenazahT_jeniskelamin\").val(\"$data->jeniskelamin\");
//                                                          $(\"#PJAmbiljenazahT_nama_pasien\").val(\"$data->nama_pasien\");                                                        
//                                                          $(\"#dialogPasien\").dialog(\"close\");    
//                                                          
//                                                "))',
//        ),
//        'no_pendaftaran',
//        'nama_pasien',
//        'alamat_pasien',
//       
//    ),
//    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
//));
//
//$this->endWidget();
////========= end Dialog Pendaftaran =============================
//?>