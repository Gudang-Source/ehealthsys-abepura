<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadaftar-tindakan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SADaftarTindakanM_komponenunit_id',
)); ?> 

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table width="100%">
            <tr>
                <td>   
                    <?php echo $form->dropDownListRow($model,'komponenunit_id',  CHtml::listData($model->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>                    
                    <?php echo $form->dropDownListRow($model,'kelompoktindakan_id',  CHtml::listData($model->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span3', 'onkeyup' => 'namaLain(this);','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'daftartindakan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                    <?php echo $form->dropDownListRow($model,'kategoritindakan_id',  CHtml::listData($model->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
                <td>   
                    <?php echo $form->textFieldRow($model,'tindakanmedis_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
                    <?php echo $form->textFieldRow($model,'daftartindakan_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    <div>
                        <?php echo $form->checkBoxRow($model,'daftartindakan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                   <?php  echo $form->labelEx($model,'Ruangan',array('class'=>'control-label required'));  ?>
                    <div class="control-group">
                       <div class="controls">

                            <?php 
                                     $arrRuangan = array();
                                      foreach($modRuangan as $Ruangan)
                                        {
                                           $arrRuangan[] = $Ruangan['ruangan_id'];
                                        }

                                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                array('sortable'=>true, 'searchable'=>true)
                                           );
                                   echo CHtml::dropDownList(
                                   'ruangan_id[]',
                                   $arrRuangan,
                                   CHtml::listData(SARuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                                   array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                           );
                             ?>

                        </div>  
                   </div>  
                </td>
                <td>
                    <fieldset class="box">
                        <legend class="rim">Tindakan</legend>
                        <table>
                            <tr>
                                <td>
                                    <?php echo $form->checkBoxRow($model,'daftartindakan_karcis', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td>
                                    <?php echo $form->checkBoxRow($model,'daftartindakan_visite', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td>
                                   <?php echo $form->checkBoxRow($model,'daftartindakan_konsul', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                                <td>
                                    <?php echo $form->checkBoxRow($model,'daftartindakan_akomodasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                </td>
                            </tr>
                            
                        </table>
                    </fieldset>
                    
                    <fieldset class="box">
                        <legend class="rim">Jenis Kegiatan</legend>
                        <table>
                            <tr>
                                <td>
                                    <?php //echo $form->dropDownListRow($model,'jeniskegiatan_id',  CHtml::listData($model->JenisKegiatanItems, 'jeniskegiatan_id', 'jeniskegiatan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>   
                                    <div class="control-group">
                                            <?php echo Chtml::label('Jenis Kegiatan', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
                                            <div class="controls">
                                                    <?php echo $form->hiddenField($model, 'jeniskegiatan_id'); ?>
                                                    <?php
                                                    $this->widget('MyJuiAutoComplete', array(
                                                            'model' => $model,
                                                            'attribute' => 'jeniskegiatan_nama',
                                                            'source' => 'js: function(request, response) {
                                                                        $.ajax({
                                                                                url: "' . $this->createUrl('/ActionAutoComplete/JenisKegiatan') . '",
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
                                                                                        $(this).val( ui.item.value);
                                                                                        return false;
                                                                                                            }',
                                                                    'select' => 'js:function( event, ui ) { 
                                                                                                                    $("#' . CHtml::activeId($model, 'jeniskegiatan_id') . '").val(ui.item.jeniskegiatan_id);
                                                                                                                    $("#' . CHtml::activeId($model, 'jeniskegiatan_nama') . '").val(ui.item.jeniskegiatan_nama);
                                                                                                                    return false;
                                                                                                            }',
                                                            ),
                                                            'htmlOptions' => array(
                                                                    'placeholder' => 'Jenis Kegiatan',
                                                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                    'class' => 'custom-only',
                                                                    'onchange' => 'cekJenisKegiatan();'
                                                            ),
                                                            'tombolDialog' => array('idDialog' => 'dialogJenisKegiatan'),
                                                    ));
                                                    ?>
                                            </div>
                                    </div>
                                </td>                               
                            </tr>
                            
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>

            <?php //echo $form->checkBoxRow($model,'daftartindakan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
               <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Tindakan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SADaftarTindakanM_daftartindakan_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('SADaftarTindakanM_tindakanmedis_nama').value = nama.value;
    }
</script>
<?php
/* ====================================== Widget Dialog Jenis Kegiatan ====================================== */
    
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogJenisKegiatan',
    'options'=>array(
        'title'=>'Pencarian Jenis Kegiatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>500,
        'resizable'=>false,
        ),
));
    
$modJenisKegiatan = new SAJenisKegiatanM('search');
$modJenisKegiatan->unsetAttributes();
if(isset($_GET['SAJenisKegiatanM'])){
    $modJenisKegiatan->attributes = $_GET['SAJenisKegiatanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'jeniskegiatan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider'=>$modJenisKegiatan->searchDialog(),
    'filter'=>$modJenisKegiatan,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectJenisKegiatan",
                                    "onClick" => "  $(\"#SADaftarTindakanM_jeniskegiatan_id\").val(\"$data->jeniskegiatan_id\");
                                                    $(\"#SADaftarTindakanM_jeniskegiatan_nama\").val(\"$data->jeniskegiatan_nama\");
                                                    $(\"#dialogJenisKegiatan\").dialog(\"close\");
                            "))',
                ),
             /*   array(
                    'header'=>'Kode Jenis Kegiatan',
                    'name'=>'jeniskegiatan_kode',
                    'value'=>'$data->jeniskegiatan_kode',
                    'filter' => Chtml::activeTextField($modJenisKegiatan, 'jeniskegiatan_kode', array('class'=>'custom-only'))
                ),*/
                array(
                    'header'=>'Jenis Kegiatan',
                    'name'=>'jeniskegiatan_nama',
                    'value'=>'$data->jeniskegiatan_nama',
                    'filter' => Chtml::activeTextField($modJenisKegiatan, 'jeniskegiatan_nama', array('class'=>'custom-only'))
                ),
                array(
                    'header'=>'Ruangan Jenis Kegiatan',
                    'name'=>'jeniskegiatan_ruangan',
                    'value'=>'$data->jeniskegiatan_ruangan',
                    'filter' => Chtml::activeDropDownList($modJenisKegiatan, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'),array('empty'=>'-- Pilih --'))
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".custom-only").keyup(function() {
            setCustomOnly(this);
        });'
    . '}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Jenis Kegiatan ====================================== */
?>
<script>
    function cekJenisKegiatan()
    {
        var jeniskegiatan = $("#<?php echo Chtml::activeId($model, 'jeniskegiatan_nama'); ?>").val();
        
        if (jeniskegiatan != ''){
            return true;
        }else{
            $("#<?php echo Chtml::activeId($model, 'jeniskegiatan_id'); ?>").val('')
        }
    }
</script>
