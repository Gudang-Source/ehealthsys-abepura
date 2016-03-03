<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data Pengalaman Organisasi berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="box">
    <?php 
    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'data-riwayat',
        'content'=>array(
            'content-datariwayat'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Pengalaman Organisasi')).'<b> Riwayat Pengalaman Organisasi</b>',
                'isi'=>$this->renderPartial('_riwayat',array(),true),
                'active'=>false,
                ),   
            ),
    )); 
    ?>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'kppengorganisasi-r-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($modPengorganisasi); ?>

<div class="block-tabel" id="formOrganisasi">
    <h6>Pengalaman <b>Organisasi</b></h6>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <table class="table table-striped table-condensed" id="tablePengalamanOrganisasi" style="padding-left:0px; padding-right:0px;">
        <thead>
            <tr>
                <th rowspan="2">Nama Organisasi *</th>
                <th rowspan="2">Kedudukan</th>
                <th rowspan="2">Tanggal Mulai</th>
                <th rowspan="2">Lama *</th>
                <th rowspan="2">Tempat</th>
                <th rowspan="2">Tambah / Batal</th>
            </tr>
        </thead>
        
        <?php
        $nourut_pend = 1;
        $i = 0;
        ?>
        <tbody>
            <?php
            if (count($detailPengorganisasiPegawai)>0){
            foreach ($detailPengorganisasiPegawai as $i=>$detail) :
            $i++;
            ?>
            
            <tr>
                
                
                <?php //echo $form->hiddenField($detail,'['.$i.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $detail->pegawai_id)), array('readonly' => TRUE)); ?>
                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <td style="padding-right:0px;">
                    <?php echo $form->hiddenField($detail,'['.$i.']pengorganisasi_id',array('class'=>'span1 pegawai ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->hiddenField($detail,'['.$i.']pegawai_id',array('class'=>'span1 pegawai ', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textField($detail,'['.$i.']pengorganisasi_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    
                </td>
                <td>
                    <?php echo $form->textField($detail,'['.$i.']pengorganisasi_kedudukan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                    <?php
                    $this->widget('MyDateTimePicker',array(
                    'model'=>$detail,
                    'attribute'=>'['.$i.']pengorganisasi_tahun',
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
                    <?php echo $form->textField($detail,'['.$i.']pengorganisasi_lamanya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                    <?php echo $form->dropDownList($detail,'['.$i.']lamanya',array('tahun'=>'tahun','bulan'=>'bulan','hari'=>'hari'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:55px;')) ?>
                </td>
                <td>
                    <?php echo $form->textField($detail,'['.$i.']pengorganisasi_tempat',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                    <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                </td>
            </tr>
            <?php endforeach;
            }
            $x = 0;?>
            <tr>
                
                <?php // echo $form->hiddenField($modPengorganisasi,'pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->hiddenField($modPengorganisasi,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                
                <td style="padding-right:0px;">
                    
                    <?php echo $form->textField($modPengorganisasi,'['.$x.']pengorganisasi_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                    <?php echo $form->textField($modPengorganisasi,'['.$x.']pengorganisasi_kedudukan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                    <?php
                    $this->widget('MyDateTimePicker',array(
                    'model'=>$modPengorganisasi,
                    'attribute'=>'['.$x.']pengorganisasi_tahun',
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
                    <?php echo $form->textField($modPengorganisasi,'['.$x.']pengorganisasi_lamanya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                    <?php echo $form->dropDownList($modPengorganisasi,'['.$x.']lamanya',array('tahun'=>'tahun','bulan'=>'bulan','hari'=>'hari'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:55px;')) ?>
                </td>
                <td>
                    <?php echo $form->textField($modPengorganisasi,'['.$x.']pengorganisasi_tempat',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                    <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                    <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($modPengorganisasi->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),'#',
        array('class'=>'btn btn-danger',
        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
<?php
$this->endWidget();
$urlGetPengOrganisasi = $this->createUrl('GetPengOrganisasi');
$pegawai_id = $_GET['pegawai_id'];
?>
<script type="text/javascript">
var trPendidikanpegawai=new String(<?php echo CJSON::encode($this->renderPartial('_rowOrganisasi',array('form'=>$form,'model'=>$modPengorganisasi,),true));?>);

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
    var obj_table = '#tablePengalamanOrganisasi';
    $(obj_table).find("tbody > tr").each(function(){

    $(this).find('input,select,textarea').each(function(){ //element <input>
        var old_name = $(this).attr("name").replace(/]/g,"");
        var old_name_arr = old_name.split("[");
        if(old_name_arr.length == 3){
            $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
            $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            if(old_name_arr[2] === 'pengalamankerja_nourut'){
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
    $(".datemask").mask("99/99/9999");
}

function Pengorganisasidata()
{
    pegawai_id =<?php echo $pegawai_id ?>;
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("<?php echo $urlGetPengOrganisasi ?>", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatJabatan").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewRiwayatOrganisasi() {
    
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

