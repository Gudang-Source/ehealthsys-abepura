<fieldset class="box" id="form-pegawai">  
        <legend class='rim'><span class='judul'>Data Pegawai </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPegawaiReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data pegawai')); ?></span></legend>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <div class="row-fluid">
            <div class="span4">
                    <div class="control-group">
                        <?php echo CHtml::label('NIP','nomorindukpegawai',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php

                                    $modul = ModulK::model()->findByAttributes(
                                        array('modul_key'=>$this->module->id)
                                    );
                                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
                                    $this->widget('MyJuiAutoComplete',array(
                                            'name'=>'nomorindukpegawai',
                                            'value'=>$model->nomorindukpegawai,
                                            'sourceUrl'=> $this->createUrl('PegawairiwayatNip'),
                                            'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 4,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $("#pegawai_id").val( ui.item.value );
                                                    $("#namapegawai").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
                                               'select'=>'js:function( event, ui ) {
                                                    $("#pegawai_id").val( ui.item.value );
                                                    setDataPegawai(ui.item.value);
                                                    return false;
                                                }',

                                            ),
                                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                            'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
                                )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama pegawai','namapegawai',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                                <?php

                                    $modul = ModulK::model()->findByAttributes(
                                        array('modul_key'=>$this->module->id)
                                    );
                                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
                                    $this->widget('MyJuiAutoComplete',array(
                                            'name'=>'namapegawai',
                                            'value'=>$model->nama_pegawai,
                                            'sourceUrl'=> $this->createUrl('Pegawairiwayat'),
                                            'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 4,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $("#pegawai_id").val( ui.item.value );
                                                    $("#namapegawai").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
                                               'select'=>'js:function( event, ui ) {
                                                    $("#pegawai_id").val( ui.item.value );
                                                    setDataPegawai(ui.item.value);
                                                    return false;
                                                }',

                                            ),
                                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                            'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
                                )); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
                    <?php 
                    $model->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai);
                    echo $form->textFieldRow($model, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
            </div>
            <div class="span4">
                <?php echo $form->textFieldRow($model, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
                <?php echo $form->textFieldRow($model,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan')); ?>
                <?php echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                <?php echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
            </div>
            <div class="span4">
                <?php 
                    if(file_exists(Params::pathPegawaiTumbsDirectory().'kecil_'.$model->photopegawai)){
                        echo CHtml::image(Params::pathPegawaiTumbsDirectory().'kecil_'.$model->photopegawai, 'photo pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </div>
        </div>
    </fieldset>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM;
if (isset($_GET['PegawaiM']))
    $modPegawai->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
	'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
                                          setDataPegawai(\"$data->pegawai_id\");
                                          $(\"#dialogPegawai\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        array(
            'header'=>'Jabatan',
            'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
