<?php //echo $form->textFieldRow($model, 'pengangkatanpns_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model, 'usulanpns_tglsk', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<div class="control-group ">
    <?php echo $form->labelEx($model, 'usulanpns_tglsk', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'usulanpns_tglsk',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,
                                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                  'class'=>'dtPicker3',
                             ),
    )); ?> 
    </div>
</div>
<?php echo $form->textFieldRow($model, 'usulanpns_nosk', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="control-group">
    <?php echo CHtml::label('Masa Kerja','namapegawai',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'usulanpns_masakerjatahun', array('class' => 'span1 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?><?php echo $form->error($model,'usulanpns_masakerjatahun');?> <label>Tahun</label>
        <?php echo $form->textField($model, 'usulanpns_masakerjabulan', array('class' => 'span1 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Bulan</label>
    </div>    
</div>
<?php //echo $form->textFieldRow($model, 'usulanpns_masakerjatahun', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model, 'usulanpns_masakerjabulan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'usulanpns_gajipokok', array('class' => 'span3 currency', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model, 'usulanpns_pejabatygberwenang', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="control-group">
    <?php echo CHtml::label('Pejabat Berwenang','namapegawai',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model, 
//                                        'name'=>'namapegawai',
                                        'attribute'=>'usulanpns_pejabatygberwenang',
                                        'value'=>'namapegawai',
                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 4,
                                           'focus'=> 'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'usulanpns_pejabatygberwenang').'").val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'usulanpns_pejabatygberwenang').'").val(ui.item.nama_pegawai);
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai2','idTombol'=>'tombolPasienDialog'),
                            )); ?>
    </div>    
</div>


<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai2',
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
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai1-m-grid',
	'dataProvider'=>$modPegawai->search(),
//	'filter'=>$modRencanaKebFarmasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#'.CHtml::activeId($model, 'usulanpns_pejabatygberwenang').'\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogPegawai2\").dialog(\"close\");    
                                                      return false;
                                            "))',
                    ),
                'nomorindukpegawai',
                'nama_pegawai',
                'tempatlahir_pegawai',
                'tgl_lahirpegawai',
                'jeniskelamin',
                'statusperkawinan',
                'jabatan.jabatan_nama',
                'alamat_pegawai',
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>