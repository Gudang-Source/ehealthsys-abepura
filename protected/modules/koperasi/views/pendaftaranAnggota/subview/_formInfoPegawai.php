<div class="span4">
    <?php echo $form->textFieldRow($modPegawai,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama pegawai','namapegawai',array('class'=>'control-label')) ?>
            <div class="controls">
                    <?php echo $form->hiddenField($anggota,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id','onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
                    <?php $this->widget('MyJuiAutoComplete',array(
                        'model'=>$modPegawai, 
                        'attribute'=>'nama_pegawai',
                        'sourceUrl'=> $this->createUrl('AutocompletePegawai'),
                        'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 4,
                           'focus'=> 'js:function( event, ui ) {
                                $("#pegawai_id").val( ui.item.value );
                                $("#namapegawai").val( ui.item.nama_pegawai );
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                setPegawai( ui.item.pegawai_id);
                                totalbobot();
                                totalscore();
                                return false;
                            }',
                        ),
                        'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 '),
                        'tombolDialog'=>array('idDialog'=>'dialogPegawai', 'jsFunction'=>'tampilDialogPegawai(1, "#dialogPegawai"); return false;',
                        ),
                    )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modPegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modPegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modPegawai,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
</div>
<div class="span4">
    <div class="control-group">
        <?php //echo $form->labelEx($model, 'jabatan_id',array('class'=>'control-label')) ?>
        <div class="controls">
            <?php //echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPegawai,'jabatan_id',array('readonly'=>true,'id'=>'jabatan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'pangkat_id',array('readonly'=>true,'id'=>'pangkat','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'gajipokok',array('readonly'=>true,'id'=>'gajipokok','onkeyup'=>"return $(this).focusNextInputField(event)", 'style'=>'text-align: right;')); ?>
    <?php echo $form->textFieldRow($modPegawai,'kategoripegawai',array('readonly'=>true,'id'=>'kategoripegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'kategoripegawaiasal',array('readonly'=>true,'id'=>'kategoripegawaiasal','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPegawai,'kelompokpegawai_id',array('readonly'=>true,'id'=>'kelompokpegawai','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php // echo $form->textFieldRow($modPegawai,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan')); ?>
    <?php //echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
</div>
<div class = "span4">
    <div align="center">
        <?php 
        $url_photopegawai = (!empty($modPegawai->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$modPegawai->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopegawai?>"width="128px"/> 
    </div>
</div>
