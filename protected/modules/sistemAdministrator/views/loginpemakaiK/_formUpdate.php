
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($model,'nama_pemakai'),
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        
            <?php 
                        echo $form->errorSummary($model); 
                     //   echo $form->textFieldRow($model,'nama_pemakai',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_old_password','LoginpemakaiK_new_password_repeat')", 'maxlength'=>200)); 
            ?>
<!--            <div class="control-group">
                <?php //echo $form->labelEx($model,'old_password',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php //echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password','LoginpemakaiK_nama_pemakai')", 'maxlength'=>200)); ?><?php //echo CHtml::link('<i class="icon-info-sign icon-white"></i>', '#', array('class'=>'btn btn-primary', 'data-title'=>Yii::t('mds','Tips'), 'data-content'=>Yii::t('mds','fill this field in case to change the password'), 'rel'=>'popover')); ?>
                    <?php //echo $form->error($model,'old_password'); ?>
                </div>
            </div>-->
        
            <?php  
//                        echo $form->PasswordFieldRow($model,'new_password',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password_repeat','LoginpemakaiK_old_password')", 'maxlength'=>200));
//                        echo $form->PasswordFieldRow($model,'new_password_repeat',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_loginpemakai_aktif','LoginpemakaiK_new_password')", 'maxlength'=>50));
            ?>
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
                                            'model'=>$model,
                                             'attribute'=>'nama_pegawai',
//                                            'name'=>'SAPegawaiM[nama_pegawai]',
//                                            'value'=>isset($model->pegawai_id) ? $model->pegawai->pegawai_nama  : null,
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
                                            'model'=>$model,
                                             'attribute'=>'nama_pasien',
//                                            'name'=>'SAPegawaiM[nama_pasien]',
//                                            'value'=>isset($model->pasien_id) ? $model->pasien->nama_pasien  : null,
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
                                                'htmlOptions'=>array("rel"=>"tooltip","title"=>"Klik untuk mencari pasien",'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  
                    echo $form->errorSummary($model); 
                    echo $form->textFieldRow($model,'nama_pemakai',array('onblur'=>'nospaces(this);','hint'=>$model->getAttributeLabel('nama_pemakai').' tidak boleh menggunakan "spasi"','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20,'onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    echo $form->PasswordFieldRow($model,'new_password',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password_repeat','LoginpemakaiK_old_password')", 'maxlength'=>200));
                    echo $form->PasswordFieldRow($model,'new_password_repeat',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_loginpemakai_aktif','LoginpemakaiK_new_password')", 'maxlength'=>50));
                ?>
                <div class="ruangan">
                <div class="control-group">
                    <?php echo $form->labelex($model,'ruangan',array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 

                                $arrRuangan = array();
                                foreach($modRuanganPemakai as $ruanganPemakai){
                                   $arrRuangan[] = $ruanganPemakai['ruangan_id'];
                               }

                               $this->widget('application.extensions.emultiselect.EMultiSelect',
                                     array('sortable'=>true, 'searchable'=>true)
                               );
                               echo CHtml::dropDownList(
                                   'ruangan_id[]',
                                   $arrRuangan,
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

                                    $arrModul = array();
                                    foreach($modModulPemakai as $modulPemakai){
                                       $arrModul[] = $modulPemakai['modul_id'];
                                   }

                                   $this->widget('application.extensions.emultiselect.EMultiSelect',
                                         array('sortable'=>true, 'searchable'=>true)
                                   );
                                   echo CHtml::dropDownList(
                                       'modul_id[]',
                                       $arrModul,
                                       CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama')), 'modul_id', 'modul_nama'),
                                       array('multiple'=>'multiple','key'=>'modul_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                   );
                            ?>
                            <?php echo $form->error($model,'modul') ?>
                        </div>
                    </div>
                </div>
                <div>
                    <?php echo $form->checkBoxRow($model,'loginpemakai_aktif', array('onkeypress'=>"return nextFocus(this,event,'submitButton','LoginpemakaiK_new_password_repeat')")); ?>
                </div>
            </div>
<!--            <div class="control-group">
                <?php // echo $form->labelex($model,'ruangan',array('class'=>'control-label required')) ?>
                <div class="controls">
                    <?php 
//                             $arrRuangan = array();
//                             foreach($modRuanganPemakai as $ruanganPemakai){
//                                $arrRuangan[] = $ruanganPemakai['ruangan_id'];
//                            }
//
//                            $this->widget('application.extensions.emultiselect.EMultiSelect',
//                                  array('sortable'=>true, 'searchable'=>true)
//                            );
//                            echo CHtml::dropDownList(
//                                'ruangan_id[]',
//                                $arrRuangan,
//                                CHtml::listData(RuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
//                                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
//                            );
                    ?>
                </div>
            </div>-->
<!--            <div class="control-group">
                <?php // echo $form->labelex($model,'modul',array('class'=>'control-label required')) ?>
                <div class="controls">
                    <?php 
//                             $arrModul = array();
//                             foreach($modModulPemakai as $modulPemakai){
//                                $arrModul[] = $modulPemakai['modul_id'];
//                            }
//
//                            $this->widget('application.extensions.emultiselect.EMultiSelect',
//                                  array('sortable'=>true, 'searchable'=>true)
//                            );
//                            echo CHtml::dropDownList(
//                                'modul_id[]',
//                                $arrModul,
//                                CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama')), 'modul_id', 'modul_nama'),
//                                array('multiple'=>'multiple','key'=>'modul_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
//                            );
                    ?>
                    <?php // echo $form->error($model,'modul') ?>
                </div>
                
            </div>-->
            
            <div class="form-actions">
                                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                         array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton')); ?>
                                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                        Yii::app()->createUrl($this->module->id.'/loginpemakaiK/admin'), 
                                                                        array('class'=>'btn btn-danger',
                                                                         'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
     	<?php
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Login Pemakai', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/sistemAdministrator/loginpemakaiK/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            </div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JSCRIPT
   kosongkanPassword();
       
   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
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
    'dataProvider'=>$modPegawai->search(), 
    'filter'=>$modPegawai, 
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'',

            'value'=>'CHtml::link("<i class=\"icon-check\"></i>","#", array("id" => "selectPegawai",
                                          "onClick"=>"
                                            $(\"#idPegawai\").val(\"$data->pegawai_id\");
                                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                             $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->NamaLengkap\");
                                            $(\"#dialogPegawai\").dialog(\"close\");    
                                            "
                                     ))',
        ), 
         'nomorindukpegawai',
         'gelardepan',
         'nama_pegawai', 
         'jeniskelamin',                    
         'tempatlahir_pegawai',
         array(
             'header' => 'Tanggal Lahir',
             'value' => '$data->tgl_lahirpegawai',

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
    'dataProvider'=>$modPasien->searchDialog(), 
    'filter'=>$modPasien, 
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'',

            'value'=>'CHtml::link("<i class=\"icon-check\"></i>","#", array("id" => "selectPegawai",
                                "onClick"=>"
                                  $(\"#pasien_id\").val(\"$data->pasien_id\");
                                  $(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
                                   $(\"#'.CHtml::activeId($model,'nama_pasien').'\").val(\"$data->nama_pasien\");
                                  $(\"#dialogPasien\").dialog(\"close\");    
                                  "
                           ))',
        ), 
         'no_rekam_medik',
         'nama_pasien',
         'jeniskelamin', 
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
<script>
function nospaces(t){
    if(t.value.match(/\s/g)){
        alert('Maaf, inputan tidak diperbolehkan menggunakan spasi');
        t.value=t.value.replace(/\s/g,'');
    }
}
function pilihPemakai(obj){
    var jenis_pemakai = $('#<?php echo CHtml::activeId($model,'jenispemakai'); ?>').val();
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
   var jenis_pemakai = $('#<?php echo CHtml::activeId($model,'jenispemakai'); ?>').val();
   var pegawai_id = $('#<?php echo CHtml::activeId($model,'pegawai_id'); ?>').val();
   var pasien_id = $('#<?php echo CHtml::activeId($model,'pasien_id'); ?>').val();
   $('input[name$="[jenispemakai]"][type="radio"]').each(function(){
		if(pegawai_id !== ''){
			$('#LoginpemakaiK_jenispemakai_0').attr('checked',true);
			$('.pegawai').show();                
			$('.ruangan').show();
			$('.pasien').hide();
		} else if(pasien_id !== ''){
			$('#LoginpemakaiK_jenispemakai_1').attr('checked',true);                
			$('.pasien').show();
			$('.pegawai').hide();
			$('.ruangan').hide();
		}
    });
});    
</script>