
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAPegawaiM_nama_pegawai',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'method'=>'POST',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        
    <div class="row-fluid">
        <div class="span12">
            <?php echo $form->radioButtonListInlineRow($model, 'jenispemakai', array('pegawai'=>'Pegawai', 'pasien'=>'Pasien'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'pilihPemakai(this);')); ?>
            <div class="pegawai">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegawai_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                            echo CHtml::activeHiddenField($model, 'pegawai_id');
                                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'SAPegawaiM[nama_pegawai]',
                                    'value'=>$model->pegawai_id,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.$this->createUrl('autoCompletePegawai').'",
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
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'pegawai_id').'").val(ui.item.pegawai_id)
                                                return false;
                                            }',
                                    ),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
                                        'htmlOptions'=>array("rel"=>"tooltip","title"=>"Klik untuk mencari pegawai",'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
            
                    </div>
                </div>
            </div>
            <div class="pasien">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pasien_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                            echo CHtml::activeHiddenField($model, 'pasien_id');
                                    $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'SAPegawaiM[nama_pasien]',
                                    'value'=>$model->pegawai_id,
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.$this->createUrl('AutocompletePasien').'",
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
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'pasien_id').'").val(ui.item.pasien_id)
                                                return false;
                                            }',
                                    ),
                                        'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                        'htmlOptions'=>array("rel"=>"tooltip","title"=>"Klik untuk mencari pasien",'onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketikan no. rekam medik'),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php  
//            echo $form->errorSummary($model); 
            echo $form->textFieldRow($model,'nama_pemakai',array('onblur'=>'nospaces(this);','hint'=>$model->getAttributeLabel('nama_pemakai').' tidak boleh menggunakan "spasi"','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20,'onkeyup'=>"return $(this).focusNextInputField(event)")); 
            echo $form->passwordFieldRow($model,'new_password',array('class'=>'span3',  'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); 
            echo $form->passwordFieldRow($model,'new_password_repeat',array('class'=>'span3',  'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>200)); 
        ?>
        <div class="ruangan">
        <div class="control-group">
            <?php echo $form->labelex($model,'ruangan',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php 
                                                                   
                        $this->widget('application.extensions.emultiselect.EMultiSelect',
                              array('sortable'=>true, 'searchable'=>true)
                        );
                        echo CHtml::dropDownList(
                            'ruangan_id[]',
                            '',
                            CHtml::listData(RuanganM::model()->findAll(array('condition'=>'ruangan_aktif = TRUE','order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                            array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
                ?>
                <?php echo $form->error($model,'ruangan') ?>
            </div>
         </div>        
            <div class="control-group">
                <?php echo $form->labelex($model,'modul',array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 

                            $this->widget('application.extensions.emultiselect.EMultiSelect',
                                  array('sortable'=>true, 'searchable'=>true)
                            );
                            echo CHtml::dropDownList(
                                'modul_id[]',
                                '',
                                CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama')), 'modul_id', 'modul_nama'),
                                array('multiple'=>'multiple','key'=>'modul_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                            );
                    ?>
                    <?php echo $form->error($model,'modul') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                              array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                              Yii::app()->createUrl($this->module->id.'/loginpemakaiK/admin'), 
                                              array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php
            $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
        <?php 
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Login Pemakai', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                 $this->createUrl('/sistemAdministrator/loginpemakaiK/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    </div>
<?php $this->endWidget(); ?>
           
<?php

$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;

Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);

 ?>
<?php 
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Data Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));

$modPegawai =new SAPegawaiM();
$modPegawai->attributes = isset($_GET['SAPegawaiM'])?$_GET['SAPegawaiM']:null;
$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'sapegawai-m-grid', 
    'dataProvider'=>$modPegawai->searchPegawaiNoUser(), 
    'filter'=>$modPegawai, 
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'',

            'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                          "onClick"=>"
                                            $(\"#idPegawai\").val(\"$data->pegawai_id\");
                                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                            $(\"#SAPegawaiM_nama_pegawai\").val(\"$data->NamaLengkap\");
                                            $(\"#dialogPegawai\").dialog(\"close\");    
                                            "
                                     ))',
        ), 
         'nomorindukpegawai',         
            array(
             'header' => 'Gelar Depan',
             'name' => 'gelardepan',
             'value' => '$data->gelardepan',
             'filter' => CHtml::dropDownList('SAPegawaiM[gelardepan]', $modPegawai->gelardepan,  LookupM::getItems('gelardepan'),array('empty'=>'-- Pilih --'))
         ),
         'nama_pegawai',           
         array(
             'header' => 'Jenis Kelamin',
             'name' => 'jeniskelamin',
             'value' => '$data->jeniskelamin',
             'filter' => CHtml::dropDownList('SAPegawaiM[jeniskelamin]', $modPegawai->jeniskelamin,  LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --'))
         ),
         'tempatlahir_pegawai',
         array(
             'header' => 'Tanggal Lahir',
             'value' => '$data->tgl_lahirpegawai',
             'filter' => false,
         ),
         'alamat_pegawai',
         ),
         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
         )); 
?>
<?php $this->endWidget(); ?>
<?php 
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));

$modPasien =new SAPasienM('searchDialog');
if(isset($_GET['SAPasienM'])){
    $modPasien->attributes = $_GET['SAPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'sapasien-m-grid', 
    'dataProvider'=>$modPasien->searchPasienNoUser(), 
    'filter'=>$modPasien, 
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'',

            'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                "onClick"=>"
                                  $(\"#pasien_id\").val(\"$data->pasien_id\");
                                  $(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
                                  $(\"#SAPegawaiM_nama_pasien\").val(\"$data->nama_pasien\");
                                  $(\"#dialogPasien\").dialog(\"close\");    
                                  "
                           ))',
        ), 
         'no_rekam_medik',
         'nama_pasien',
         array(
             'header' => 'Jenis Kelamin',
             'name' => 'jeniskelamin',
             'value' => '$data->jeniskelamin',
             'filter' => CHtml::dropDownList('SAPasienM[jeniskelamin]', $modPegawai->jeniskelamin,  LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --'))
         ),
        array(
             'header' => 'Tanggal Lahir',
             'value' => '$data->tanggal_lahir',

         ),        
         'alamat_pasien',                 
         
        ),
         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
         )); 
?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function nospaces(t){
    if(t.value.match(/\s/g)){
        myAlert('Maaf, inputan tidak diperbolehkan menggunakan spasi');
        t.value=t.value.replace(/\s/g,'');
    }
}

function pilihPemakai(obj){
    var jenis_pemakai = $('#<?php CHtml::activeId($model,'jenispemakai'); ?>').val();
    $('input[name$="[jenispemakai]"][type="radio"]').each(function(){
        if($(obj).is(':checked')){
            if(obj.value == 'pegawai'){
                $('.pegawai').show();
                $('.pasien').hide();
                $('.ruangan').show();
            }else{
                $('.pegawai').hide();
                $('.pasien').show();
                $('.ruangan').hide();
            }
        }
    });
}

$(document).ready(function(){
    var jenis_pemakai = $('#<?php CHtml::activeId($model,'jenispemakai'); ?>').val();
    $('input[name$="[jenispemakai]"][type="radio"]').each(function(){
        if($(this).is(':checked')){
            if(this.value == 'pegawai'){
                $('.pegawai').show();
                $('.pasien').hide();
                $('.ruangan').show();
            }else{
                $('.pegawai').hide();
                $('.pasien').show();
                $('.ruangan').hide();
            }
        }
    });
   
});
</script>
