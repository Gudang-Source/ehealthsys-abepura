<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data Susunan Keluarga berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="box">
    <?php 
    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'data-riwayat',
        'content'=>array(
            'content-datariwayat'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Susunan Keluarga')).'<b> Riwayat Susunan Keluarga</b>',
                    'isi'=>$this->renderPartial('_riwayat',array(),true),
                    'active'=>false,
                    ),   
            ),
    )); 
    ?>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kpsusunankel-m-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<?php // echo $form->errorSummary($modSusunanKeluarga); ?>

<div class="block-tabel" id="formOrganisasi">
    <h6>Susunan <b>Keluarga Pegawai</b></h6>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <div style="max-width:100%;overflow-x: scroll;">
        <table class="table table-striped table-condensed" id="tableSusunanKeluarga">
            <thead>
                <tr>                
                    <th>No. Urut <br> Keluarga<span class="required">*</span></th>
                    <th style="vertical-align: top">Hubungan Keluarga <span class="required">*</span></th>
                    <th style="vertical-align: top">Nama <span class="required">*</span></th>
                    <th style="vertical-align: top">Jenis Kelamin <span class="required">*</span></th>
                    <th style="vertical-align: top">Tempat Lahir</th>
                    <th style="vertical-align: top; width: 1000px;">Tanggal Lahir <span class="required">*</span></th>
                    <th style="vertical-align: top">Pekerjaan</th>
                    <th style="vertical-align: top">Pendidikan</th>
                    <th style="vertical-align: top">Tanggal Pernikahan</th>
                    <th style="vertical-align: top">Tempat Pernikahan</th>
                    <th style="vertical-align: top">NIP</th>
                    <th style="vertical-align: top">Tambah / Batal</th>
                </tr>
            </thead>
            <?php
            $nourut_pend = 1;
            $i = 0;
            ?>
            <tbody>
                <?php
                if (count($details)>0){
                foreach ($details as $i=>$detail) :
                $i++;
                ?>
                <tr>
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' =>$detail->pegawai_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php echo $form->hiddenField($detail,'['.$i.']susunankel_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($detail,'['.$i.']pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                    <td style="padding-right:0px;">

                        <?php echo $form->textField($detail,'['.$i.']nourutkel',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </td>
                    <td>
                        <?php echo $form->dropDownList($detail, '['.$i.']hubkeluarga', LookupM::getItems('hubungankeluarga'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                    </td>
                    <td>
                    <?php echo $form->textField($detail,'['.$i.']susunankel_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?></td>
                    <td>
                        <?php echo $form->dropDownList($detail, '['.$i.']susunankel_jk', LookupM::getItems('jeniskelamin'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                    </td>
                    <td>
                        <?php echo $form->textField($detail,'['.$i.']susunankel_tempatlahir',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$detail,
                        'attribute'=>'['.$i.']susunankel_tanggallahir',
                        'mode'=>'date',
                        'options'=> array(
                        'showOn' => false,
                        // 'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                        )); ?>
                    </td>
                    <td>
                        <?php echo $form->dropDownList($detail,'['.$i.']pekerjaan_nama',CHtml::listData(PekerjaanM::model()->findAll(), 'pekerjaan_nama', 'pekerjaan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                    </td>
                    <td>
                        <?php echo $form->dropDownList($detail,'['.$i.']pendidikan_nama',CHtml::listData(PendidikanM::model()->findAll(), 'pendidikan_nama', 'pendidikan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$detail,
                        'attribute'=>'['.$i.']susunankel_tanggalpernikahan',
                        'mode'=>'date',
                        'options'=> array(
                        'showOn' => false,
                        // 'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                        )); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($detail,'['.$i.']susunankel_tempatpernikahan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($detail,'['.$i.']susunankeluarga_nip',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                    <td>

                        <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                    </td>
                </tr>


                <?php endforeach;
                }else{
                $x = 0;?>

                <tr>                
                    <td style="padding-right:0px;">

                        <?php echo $form->textField($modSusunanKeluarga,'['.$x.']nourutkel',array('class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </td>
                    <td>
                        <?php echo $form->dropDownList($modSusunanKeluarga, '['.$x.']hubkeluarga', LookupM::getItems('hubungankeluarga'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                    </td>
                    <td>
                    <?php echo $form->textField($modSusunanKeluarga,'['.$x.']susunankel_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?></td>
                    <td>
                        <?php echo $form->dropDownList($modSusunanKeluarga, '['.$x.']susunankel_jk', LookupM::getItems('jeniskelamin'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                    </td>
                    <td>
                        <?php echo $form->textField($modSusunanKeluarga,'['.$x.']susunankel_tempatlahir',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$modSusunanKeluarga,
                        'attribute'=>'['.$x.']susunankel_tanggallahir',
                        'mode'=>'date',
                        'options'=> array(
                        'showOn' => false,
                         'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                        )); ?>
                    </td>
                    <td>
                        <?php echo $form->dropDownList($modSusunanKeluarga,'['.$x.']pekerjaan_nama',CHtml::listData(PekerjaanM::model()->findAll(), 'pekerjaan_nama', 'pekerjaan_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    </td>
                    <td>
                        <?php echo $form->dropDownList($modSusunanKeluarga,'['.$x.']pendidikan_nama',CHtml::listData(PendidikanM::model()->findAll(), 'pendidikan_nama', 'pendidikan_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>

                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$modSusunanKeluarga,
                        'attribute'=>'['.$x.']susunankel_tanggalpernikahan',
                        'mode'=>'date',
                        'options'=> array(
                        'showOn' => false,
                         'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                        )); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($modSusunanKeluarga,'['.$x.']susunankel_tempatpernikahan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($modSusunanKeluarga,'['.$x.']susunankeluarga_nip',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                        <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                    </td>
                </tr>
                            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($modSusunanKeluarga->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),'#',
        array('class'=>'btn btn-danger',
        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$urlGetSusunanKeluarga = $this->createUrl('GetSusunanKeluarga');
$pegawai_id = $_GET['pegawai_id'];
?>

<script type="text/javascript">
var trPendidikanpegawai=new String(<?php echo CJSON::encode($this->renderPartial('_rowSusunanKelM',array('form'=>$form,'model'=>$modSusunanKeluarga,),true));?>);

function tambahOrganisasi(obj) {
    $("#hapus").show();
    $(obj).hide();
    $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
    renameInput();
}

function hapusOrganisasi(obj) {
    $("#tambah").show();
    $(obj).hide();
    $(obj).parents("tr").remove();
    renameInput();
}

function renameInput(){
    var row = 0;
    var obj_table = '#tableSusunanKeluarga';
    $(obj_table).find("tbody > tr").each(function(){

    $(this).find('input,select,textarea').each(function(){ //element <input>
        var old_name = $(this).attr("name").replace(/]/g,"");
        var old_name_arr = old_name.split("[");
        if(old_name_arr.length == 3){
            $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
            $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            if(old_name_arr[2] === 'nourutkel'){
                $(this).attr('name',old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]").val(row+1);
            }
        }
    });
    $(this).find('span').each(function(){
        var old_name = $(this).parent('.input-append').find('input').attr("name").replace(/]/g,"");
        var old_name_arr = old_name.split("[");
        var id_span = '';
        if(old_name_arr.length == 3){
            id_span = old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_date";
            id = old_name_arr[0]+"_"+row+"_"+old_name_arr[2];
            $(this).attr("id",id_span);
            registerDateJs(id,id_span);
        }
    });
    row++;
    });
}
function registerDateJs(id,id_span){
    $('#'+id).datepicker(jQuery.extend({
    showMonthAfterYear:false},
    jQuery.datepicker.regional['id'],
    {'timeOnlyTitle':'Pilih Waktu',
    'changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
    $('#'+id_span).on('click', function(){$('#'+id).datepicker('show');});
}

function Pengorganisasidata()
{
    pegawai_id = <?php echo $pegawai_id ?>;
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("<?php echo $urlGetSusunanKeluarga ?>", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatJabatan").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewRiwayatJabatan() {
    
    if ($("#cekRiwayatpegawai").is(":checked")) {
        Pengorganisasidata();
        $("#tableRiwayatJabatan").slideDown(60);
    } else {
        $("#tableRiwayatJabatan").children("tbody").children("tr").remove();
        $("#tableRiwayatJabatan").slideUp(60);
    }
}

$('#cekRiwayatpegawai').change(function(){
        $('#divRiwayatpendidikanpegawai').slideToggle(500);
});

function hapus(obj){
    myConfirm('Anda yakin akan menghapus item ini?','Perhatian!',
    function(r){
        if(r){
            url = $(obj).attr('href');
            $(location).attr('href',url);
        }
    }); 
}

$(document).ready(function(){
    Pengorganisasidata();
});
</script>
