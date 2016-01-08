<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data Izin Tugas Belajar berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="box">
    <?php 
    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'data-riwayat',
        'content'=>array(
            'content-datariwayat'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'Pengorganisasidata()','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Izin Tugas Belajar')).'<b> Riwayat Izin Tugas Belajar</b>',
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
<fieldset class="box" id="tableIjintugasbelajar">
    <legend class="rim">Izin tugas belajar pegawai</legend>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $modIzintugasbelajar->pegawai_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php echo $form->labelEx($modIzintugasbelajar,'tglmulaibelajar',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modIzintugasbelajar,
                                                'attribute'=>'tglmulaibelajar',
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
                    <?php echo $form->labelEx($modIzintugasbelajar,'tglselesaibelajar',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modIzintugasbelajar,
                                                'attribute'=>'tglselesaibelajar',
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
                <?php echo $form->textFieldRow($modIzintugasbelajar,'nomorkeputusan',array('class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modIzintugasbelajar,'tglditetapkan',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                        $this->widget('MyDateTimePicker',array(
                                                'model'=>$modIzintugasbelajar,
                                                'attribute'=>'tglditetapkan',
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
				<?php echo $form->textAreaRow($modIzintugasbelajar,'keteranganizin',array('rows'=>1,'class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')); ?>
				<?php echo $form->dropDownListRow($modIzintugasbelajar,'pejabatmemutuskan',CHtml::listData($modIzintugasbelajar->getPegawaiItems(),'nama_pegawai','nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>'$(this).focusNextInputField(event)')) ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event)','name'=>'submitIzintugasbelajar')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),'#', 
                array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
</fieldset>

<?php
$this->endWidget();
$urlGetIjintugasbelajar = $this->createUrl('GetIzintugasbelajar');
$pegawai_id = $_GET['pegawai_id'];
$js= <<< JS

function Ijintugasbelajardata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetIjintugasbelajar}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatIjintugasbelajar").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewIjintugasbelajar() {
    
    if ($("#cekRiwayatIjintugasbelajar").is(":checked")) {
        Ijintugasbelajardata();
        $("#tableRiwayatIjintugasbelajar").slideDown(60);
    } else {
        $("#tableRiwayatIjintugasbelajar").children("tbody").children("tr").remove();
        $("#tableRiwayatIjintugasbelajar").slideUp(60);
    }
}

$(document).ready(function(){
    Ijintugasbelajardata();
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