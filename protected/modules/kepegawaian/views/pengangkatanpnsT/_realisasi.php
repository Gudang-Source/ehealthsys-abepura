<?php //echo $form->checkBoxRow($model,'pengangkatanpns_id', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model,'realisasipns_tglsk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<div class="control-group ">
    <?php echo $form->labelEx($model, 'realisasipns_tglsk', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'realisasipns_tglsk',
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
<?php echo $form->textFieldRow($model,'realisasipns_nosk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group">
    <?php echo CHtml::label('Masa Kerja','namapegawai',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'realisasipns_masakerjatahun', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tahun</label>
        <?php echo $form->textField($model, 'realisasipns_masakerjatahun', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Bulan</label>
    </div>    
</div>
<?php //echo $form->textFieldRow($model,'realisasipns_masakerjatahun',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model,'realisasipns_masakerjabulan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model,'realisasipns_gajipokok',array('class'=>'span3  integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<?php //echo $form->textFieldRow($model,'realisasipns_pejabatyangberwena',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>

<div class="control-group">
    <?php echo CHtml::label('Pejabat Berwenang','namapegawai',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model, 
//                                        'name'=>'namapegawai',
                                        'attribute'=>'realisasipns_pejabatyangberwena',
                                        'value'=>'namapegawai',
                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 4,
                                           'focus'=> 'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'realisasipns_pejabatyangberwena').'").val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#'.CHtml::activeId($model, 'realisasipns_pejabatyangberwena').'").val(ui.item.nama_pegawai);
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai4','idTombol'=>'tombolPasienDialog'),
                            )); ?>
    </div>    
</div>

<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai4',
    'options'=>array(
        'title'=>'Daftar Pejabat Berwenang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new KPRegistrasifingerprint('search');
$modPegawai->unsetAttributes();
if(isset($_GET['KPRegistrasifingerprint'])) {
    $modPegawai->attributes = $_GET['KPRegistrasifingerprint'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai2-m-grid',
	'dataProvider'=>$modPegawai->search(),
	//'filter'=>$modPegawai,
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
                                                      $(\"#'.CHtml::activeId($model, 'realisasipns_pejabatyangberwena').'\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogPegawai4\").dialog(\"close\");    
                                                      return false;
                                            "))',
                    ),
                'nomorindukpegawai',
                'nama_pegawai',
                'tempatlahir_pegawai',
                'tgl_lahirpegawai',
                array(
                    'header' => 'Jenis Kelamin',
                    'name' => 'jeniskelamin',
                    'filter' => CHtml::dropDownList('PegawaiM[jeniskelamin]', $modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                ),                
                array(
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'filter' => CHtml::dropDownList('PegawaiM[jabatan_id]', $modPegawai->jabatan_id, CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'), array('empty'=>'-- Pilih --')),
                ),
                'statusperkawinan',                
                'alamat_pegawai',
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>