<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data Mutasi Kerja berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="box">
    <?php 
    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'data-riwayat',
        'content'=>array(
            'content-datariwayat'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'Pengorganisasidata()','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Mutasi Kerja')).'<b> Riwayat Mutasi Kerja</b>',
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
<fieldset class="box" id="tablePegawaimutasi">
    <legend class="rim">Mutasi pegawai</legend>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <table style="width:100%;">
        <tr>
            <td colspan="2" style="width:100%;">
                  
            </td>
		</tr>
        <tr>
            <td style="width:50%;">
				<?php echo $form->textFieldRow($modPegmutasi,'nomorsurat',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php echo $form->dropDownListRow($modPegmutasi,'jabatan_nama',CHtml::listData($modPegmutasi->getJabatanItems(),'jabatan_nama','jabatan_nama'),array('class' => 'span3','empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php echo $form->dropDownListRow($modPegmutasi,'unitkerja',CHtml::listData($modPegmutasi->getRuanganItems(),'ruangan_nama','ruangan_nama'),array('class' => 'span3','empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php //echo $form->dropDownListRow($modPegmutasi,'pangkat_nama',CHtml::listData($modPegmutasi->getPangkatItems(),'pangkat_nama','pangkat_nama'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
				<?php echo $form->dropDownListRow($modPegmutasi, 'jenispromosi_mutasi', LookupM::getItems('jenispromosi_mutasi'), array('empty' => '-- Pilih --', 'class' => 'span3','onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td style="width:50%;">
                <?php echo $form->dropDownListRow($modPegmutasi,'jabatan_baru',CHtml::listData($modPegmutasi->getJabatanItems(),'jabatan_nama','jabatan_nama'),array('class' => 'span3','empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
				<?php echo $form->textFieldRow($modPegmutasi,'lokasikerja_baru',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php echo $form->dropDownListRow($modPegmutasi,'unitkerja_baru',CHtml::listData($modPegmutasi->getRuanganItems(),'ruangan_nama','ruangan_nama'),array('class' => 'span3','empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php //echo $form->dropDownListRow($modPegmutasi,'pangkat_baru',CHtml::listData($modPegmutasi->getPangkatItems(),'pangkat_nama','pangkat_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
            </td>
        </tr>
    </table>
</fieldset>
<fieldset class="box" id="tableSuratKeputusan">
    <legend class="rim">Surat Keputusan</legend>
    <table style="width:100%;">
        <tr>
            <td>
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <?php echo $form->textFieldRow($modPegmutasi,'nosk',array('class'=>'span3','onkeypress'=>'return $(this).focusNextInputField(event)','value'=>date('Ymd'))) ?>
            </td>
		</tr>
        <tr>
			<td>
				<div class="control-group">
                    <?php echo $form->labelEx($modPegmutasi,'tglsk',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php   
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPegmutasi,
                                                'attribute'=>'tglsk',
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
                    <?php echo $form->labelEx($modPegmutasi,'tmtsk',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php   
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPegmutasi,
                                                'attribute'=>'tmtsk',
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
            </td>
            <td>
                <?php echo $form->dropDownListRow($modPegmutasi,'mengetahui_nama',CHtml::listData($modPegmutasi->getMengetahuiItems(),'nama_pegawai','nama_pegawai'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
                <?php echo $form->dropDownListRow($modPegmutasi,'pimpinan_nama',CHtml::listData($modPegmutasi->getMengetahuiItems(),'nama_pegawai','nama_pegawai'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)')) ?>
            </td>
        </tr>
    </table>
</fieldset>

    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)','name'=>'submitPegmutasi')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),'#', 
            array('class'=>'btn btn-danger',
                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
<?php
$this->endWidget();
$urlGetPegmutasi = $this->createUrl('GetPegmutasi');
$pegawai_id = $_GET['pegawai_id'];
$js= <<< JS

function Pegmutasidata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetPegmutasi}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatPegmutasi").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewPegmutasi() {
    
    if ($("#cekRiwayatPegawaimutasi").is(":checked")) {
        Pegmutasidata();
        $("#tableRiwayatPegmutasi").slideDown(60);
    } else {
        $("#tableRiwayatPegmutasi").children("tbody").children("tr").remove();
        $("#tableRiwayatPegmutasi").slideUp(60);
    }
}
$(document).ready(function(){
    Pegmutasidata();
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