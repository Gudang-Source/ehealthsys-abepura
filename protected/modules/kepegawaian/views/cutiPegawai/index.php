<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data Cuti berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="box">
    <?php 
    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'data-riwayat',
        'content'=>array(
            'content-datariwayat'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'Pengorganisasidata()','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Cuti')).'<b> Riwayat Cuti</b>',
                'isi'=>$this->renderPartial('_riwayat',array(),true),
                'active'=>false,
                ),   
            ),
    )); 
    ?>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'sapegawai-m-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<?php echo $form->errorSummary($model); ?>
    <fieldset class="box" id="tablePegawaicuti">
        <legend class="rim">Cuti Pegawai</legend>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <table width="100%">
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->dropDownListRow($modPegawaicuti,'jeniscuti_id',CHtml::listData($modPegawaicuti->getJeniscutiItems(),'jeniscuti_id','jeniscuti_nama'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                            <div class="control-group">
                                <?php echo $form->labelEx($modPegawaicuti,'tglmulaicuti',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                            'model'=>$modPegawaicuti,
                                                            'attribute'=>'tglmulaicuti',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'showOn' => false,
                                                                // 'maxDate' => 'd',
                                                                'yearRange'=> "-150:+0",
                                                            ),
                                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                            ),
                                    )); ?>
                                </div>
                            </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPegawaicuti,'tglakhircuti',array('class'=>'control-label')); ?>
                            <div class="controls">
                                    <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                            'model'=>$modPegawaicuti,
                                                            'attribute'=>'tglakhircuti',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'showOn' => false,
                                                                // 'maxDate' => 'd',
                                                                'yearRange'=> "-150:+0",
                                                            ),
                                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                            ),
                                    )); ?>    
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPegawaicuti,'lamacuti',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPegawaicuti,'lamacuti',array('class'=>'span1','onkeypress'=>'$(this).focusNextInputField(event)')).' hari'; ?>
                            </div>
                        </div>
        </td>
        <td>
                <?php echo $form->textFieldRow($modPegawaicuti,'noskcuti',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')) ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPegawaicuti,'tglditetapkanskcuti',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php   
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPegawaicuti,
                                                'attribute'=>'tglditetapkanskcuti',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'showOn' => false,
                                                    // 'maxDate' => 'd',
                                                    'yearRange'=> "-150:+0",
                                                ),
                                                'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>    
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPegawaicuti,'keperluancuti',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')) ?>
                
        </td>
        <td>
				<?php echo $form->textAreaRow($modPegawaicuti,'keterangan',array('onkeypress'=>'$(this).focusNextInputField(event)')) ?>
                <?php echo $form->dropDownListRow($modPegawaicuti,'pejabatmengetahui',CHtml::listData($modPegawaicuti->getPegawaiItems(),'nama_pegawai','nama_pegawai'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php echo $form->dropDownListRow($modPegawaicuti,'pejabatmenyetujui',CHtml::listData($modPegawaicuti->getPegawaiItems(),'nama_pegawai','nama_pegawai'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)','name'=>'submitPegawaicuti')); ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),'#', 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        </div>
    </fieldset>

<?php
$this->endWidget();
$urlGetPegawaicuti = $this->createUrl('GetPegawaicuti');
$pegawai_id = $_GET['pegawai_id'];
$js= <<< JS

function Pegawaicutidata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetPegawaicuti}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatPegawaicuti").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewPegawaicuti() {
    
    if ($("#cekRiwayatPegawaicuti").is(":checked")) {
        Pegawaicutidata();
        $("#tableRiwayatPegawaicuti").slideDown(60);
    } else {
        $("#tableRiwayatPegawaicuti").children("tbody").children("tr").remove();
        $("#tableRiwayatPegawaicuti").slideUp(60);
    }
}
$(document).ready(function(){
    Pegawaicutidata();
});
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function hapus(obj){
        myConfirm('Anda yakin akan menghapus item ini?','Perhatian!',
        function(r){
            if(r){
                url = $(obj).attr('href');
                $(location).attr('href',url);
            }
        }); 
        
    }
</script>