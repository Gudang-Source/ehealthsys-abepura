<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<fieldset class="box">
    <legend class="rim">Data Pasien</legend>
<?php 
    echo $this->renderPartial('_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)) 
?>
</fieldset>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pasienpulang-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onSubmit'=>'return cekValidasi()'),
        'focus'=>'#',
)); ?>
<fieldset class="box">
        <legend class="rim">Tindak Lanjut</legend>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary(array($modelPulang,$modRujukanKeluar)); ?>
        <table>
            <tr>
                <td width="50%">
                    <?php //echo $form->textFieldRow($modelPulang,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php //echo $form->labelEx($modelPulang,'tglpasienpulang', array('class'=>'control-label')) ?>
                        <?php echo CHtml::label('Tgl. Pasien Keluar', 'tglpasienpulang', array('class'=>'control-label'))?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modelPulang,
                                                    'attribute'=>'tglpasienpulang',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                            )); ?>
                            <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?> 
                        </div>
                    </div>

                    <?php echo $form->hiddenfield($modelPulang,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <?php echo $form->hiddenfield($modelPulang,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modelPulang,'carakeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'carakeluar_id', CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'), 
                                        array('class'=>'span3 carakeluar_id','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>'cekCaraKeluar(this);',
                                                'ajax'=>array('type'=>'POST',
                                                            'url'=>$this->createUrl('SetDropDownKondisiKeluar',array('encode'=>false,'model_nama'=>get_class($modelPulang))),
                                                            'update'=>"#".CHtml::activeId($modelPulang, 'kondisikeluar_id'),
                                                ),));?>                            
                            <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Kondisi Pulang <font color=red>*</font>', 'kondisikeluar_id', array('class'=>'control-label'))?>
                        <?php //echo $form->labelEx($modelPulang,'kondisikeluar_id', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modelPulang,'kondisikeluar_id', CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'), 
                                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'cekKondisiKeluar(this);'));?>
                            <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modelPulang,'ruanganakhir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modelPulang,'penerimapasien',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    
                    <?php if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) { ?>
                        <?php echo $form->textFieldRow($modMasukKamar,'tglmasukkamar',array('readonly'=>true)) ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modMasukKamar,'lamadirawat_kamar', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modMasukKamar,'lamadirawat_kamar',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Hari
                                <?php echo $form->hiddenField($modelPulang,'lamarawat',array('class'=>'span1','value'=>$modMasukKamar->lamadirawat_kamar, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
						<div class="control-group ">
							<?php echo $form->labelEx($modelPulang,'hariperawatan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textField($modelPulang,'hariperawatan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Hari
							</div>
						</div>
                    <?php } else{ ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modelPulang,'lamarawat', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modelPulang,'lamarawat',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Jam
                            </div>
                        </div>
						<?php echo $form->error($modelPulang, 'lamarawat'); ?>
						<div class="control-group ">
							<?php echo $form->labelEx($modelPulang,'hariperawatan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textField($modelPulang,'hariperawatan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> Hari
							</div>
						</div>
                        
					<?php } ?>
                     <?php //echo $form->textFieldRow($modelPulang,'satuanlamarawat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td width="50%">
                   <fieldset class="box2 box-meninggal" hidden>
                        <legend class="rim">
                            <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress'=>"return $(this).focusNextInputField(event)", "readonly"=>true)) ?>
                            Pasien Meninggal
                        </legend>
                        <div class="control-group ">
                                <?php echo $form->labelEx($modelPulang,'tgl_meninggal', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$modelPulang,
                                                            'attribute'=>'tgl_meninggal',
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5 tgl_meninggal','readonly'=>true, 'disabled'=>true),
                                    )); ?>

                                </div>
                            </div>
                    </fieldset> 
                </td>
            </tr>
        </table>
</fieldset>

        <?php echo $this->renderPartial('_formRujukanKeluar',array('form'=>$form,'modelPulang'=>$modelPulang,'modRujukanKeluar'=>$modRujukanKeluar)); ?>

		
	<div class="form-actions">
                 <?php echo CHtml::htmlButton($modelPulang->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
    function cekCaraKeluar(obj){
        if(obj.value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>"){
            $('#pakeRujukan').attr('checked',true);
            $('#divRujukan input').removeAttr('disabled');
            $('#divRujukan select').removeAttr('disabled');
            $('#divRujukan textarea').removeAttr('disabled');
            $('#divRujukan').show(500);
        }else{
            $('#pakeRujukan').removeAttr('checked');
            $('#divRujukan input').attr('disabled','true');
            $('#divRujukan select').attr('disabled','true');
            $('#divRujukan textarea').attr('disabled','true');
            $('#divRujukan').hide(500);
        }
        
        if(obj.value == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>"){
            $("#isDead").prop("checked", true);
            $(".box-meninggal").show();
            $(".tgl_meninggal").prop("disabled", false).val("");
        } else {
            $("#isDead").prop("checked", false);
            $(".box-meninggal").hide();
            $(".tgl_meninggal").prop("disabled", true).val("");
        }
    }
    function cekKondisiKeluar(obj){
        if(obj.value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_1 ?>" || obj.value == "<?php echo Params::KONDISIKELUAR_ID_MENINGGAL_2 ?>")
        {
             $('#isDead').attr('checked',true);
             $('#RDPasienPulangT_tgl_meninggal').removeAttr('disabled');
        }
        else
        {
            $('#isDead').removeAttr('checked');
            $('#RDPasienPulangT_tgl_meninggal').attr('disabled',true);
        }
    }
    function konfirmasi()
    {
        myConfirm("<?php echo Yii::t('mds','Do You want to cancel?') ?>","Perhatian!",function(r) {
            if(r){
                window.location.href = window.location;
            }
            else
            {   
                $('#RDPasienPulangT_carakeluar_id').focus();
                return false;
            }
        });
    }
    
    function cekValidasi() {
        var keluar = $("#RDPasienPulangT_carakeluar_id").val();
        var kondisi = $("#RDPasienPulangT_kondisikeluar_id").val();
        var isd = $("#isDead").is(":checked");
        var tgld = $(".tgl_meninggal").val();
        
        if (keluar.trim() === "") {
            myAlert("Cara Keluar harus diisi.");
            return false;
        }
        if (kondisi.trim() === "") {
            myAlert("Kondisi Pulang harus diisi.");
            return false;
        }
        if (isd && tgld.trim() === "") {
            myAlert("Tanggal Meninggal harus diisi.");
            return false;
        }
        
        return true;
    }
    
    $(document).ready(function(){
        // Notifikasi Pasien
        <?php 
            if(isset($smspasien)){
                if($smspasien==0){
        ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
            insert_notifikasi(params);
        <?php            
                }
            }
        ?>
    });
</script>
<?php if($tersimpan == true) {?>
<script>
    parent.location.reload();
</script>
<?php } ?>
