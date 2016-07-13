<div class="white-container">
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <style>
        label.checkbox{display:inline-block;width:150px;}
        ul.classInline{display:inline-block; list-style: none;}
        ul.classInline li{display:inline-block;margin-right:5px;}
    </style>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penjadwalan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#instalasi',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>
    <table>
        <tr>
            <td colspan="4"><div class='errorTable2'></div></td>
        </tr>
        <tr>
            <td width="120px">Periode Jadwal</td>
            <td class="span4">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name'=>'jadwalDokter[txtStartDate]',
                        'mode'=>'date',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'showAnim'=>'fold',
                            'beforeShow'=>'js:function(){customRange(this);}',
                            'dateFormat'=>"yy-mm-dd",
                            'changeFirstDay'=>false,
                            'changeMonth'=>true,
                            'numberOfMonths'=>3,
                        ),
                        'htmlOptions'=>array(
                            'id'=>'txtStartDate',
                            'onchange'=>'$("#inputForm").html("");',
                            //'onclick'=>"return $(this).focusNextInputField(event);",
                            'class'=>'dtPicker3',
                            'readonly'=>true,
                        ),
                    ));
                ?>
            </td>
            <td width="120px">Sampai dengan</td>
            <td>
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name'=>'jadwalDokter[txtEndDate]',
                        'mode'=>'date',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'showAnim'=>'fold',
                            'beforeShow'=>'js:function(){customRange(this);}',
                            'dateFormat'=>"yy-mm-dd",
                            'changeFirstDay'=>false,
                            'changeMonth'=>true,
                            'numberOfMonths'=>3,
                        ),
                        'htmlOptions'=>array(
                            'id'=>'txtEndDate',
                            'onchange'=>'$("#inputForm").html("");',
							'class'=>'dtPicker3',
                            'readonly'=>true,
                        ),
                    ));
                ?>
            </td>
        </tr>
		<tr>
            <td>Instalasi</td>
            <td>
                <?php
                    echo CHtml::dropDownList('jadwalDokter[instalasi]', '', CHtml::listData(InstalasirevenuecostV::model()->findAll(array('condition'=>"instalasi_id IN ('".Params::INSTALASI_ID_RJ."','".Params::INSTALASI_ID_RD."','".Params::INSTALASI_ID_REHAB."')" ,'order'=>'instalasi_nama ASC')), 'instalasi_id', 'instalasi_nama'), 
                                            array('empty'=>'-- Pilih --',
                                                  'id'=>'instalasi',
                                                  'class' => 'required',
                                                  'onchange'=>'$("#inputForm").html("");',
                                                  'ajax'=>array('url'=>$this->createUrl('ajaxListPoli'),
                                                                'type'=>'POST',
                                                                'update'=>'#inputPoli')));
                ?>
                <br/><br/>
                
            </td>
            <td>Poliklinik</td>
            <td rowspan="2">
                <div id="inputPoli" ></div><br/><br/><br/>
            </td>
        </tr>
        </table>
    <!--    <tr><td></td>
            <td colspan="2"><div id='submitForm'></div></td>
        </tr>-->                   
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Buat Jadwal',array('{icon}'=>'<i class="icon-list-alt icon-white"></i>')),
                                                    array('class'=>'btn btn-blue', 'type'=>'button', 'onClick'=>'generateInput();'));?>                         
                    <?php
                        echo  CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                     array('class'=>'btn btn-primary', 'type'=>'submit'));
                    ?>
                            
                                   <?php
                                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                            $this->createUrl('admin'), 
                                                array('class'=>'btn btn-danger',
                                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;',
                                                    ));
                                   ?>                          
                         <?php
                            echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Dokter',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));
                           ?>
                           <?php
                            $content = $this->renderPartial('../tips/tipsaddeditjadwal',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                        ?>
                            
                
        <table>
        <tr>
            <td colspan="4"><div id='inputForm'></div></td>
        </tr>

    </table>
                       
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

function generateInput()
{
    $.post('<?php echo $this->createUrl('ajaxGenerateInputForm') ?>', $('#penjadwalan-form').serialize(), function(data){
        $('#inputForm').html(data.form);
        $("#inputForm .classInline li .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
        $("#inputForm .classInline li .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','beforeShow':function(){customRange(this);},'dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
        $('#submitForm').html(data.submit);
        $('#batalForm').html(data.batal);
    },'json');
}

function insertInputDokter(idTabel, idRuangan, obj)
{
    //var jmlBaris = $('#div_'+idTabel+'_'+idBaris+' input').length;
    parent = $(obj).parents("#tabelForm_"+idTabel+" tr td");
    var jmlBaris = parent.find(".inputDokter").length;
    var input = '<li><select style="display:inline-block;" name="jadwalDokter[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][pegawai_id]" id="jadwalDokter_'+idTabel+'_'+idRuangan+'_'+jmlBaris+'" type="text" class="inputDokter span3" ></select></li>';
    input += '<li><div style="display:inline-block;margin-bottom:-7px;" class="input-append"><input style="float:left" type="text" name="jadwalDokter[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][jadwaldokter_mulai]" class="span1 timePickerTest"><span class="add-on"><i class="icon-time"></i></span></div></li>';
    input += '<li>s/d</li>';
    input += '<li><div style="display:inline-block;margin-bottom:-7px;" class="input-append"><input style="float:left" type="text" name="jadwalDokter[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][jadwaldokter_tutup]" class="span1 timePickerTest"><span class="add-on"><i class="icon-time"></i></span></div></li>';
    input += '<li>max</li>';
    input += '<li><input style="display:inline-block;" type="text" name="jadwalDokter[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][maximumantrian]" class="span1 numbersOnly"></li>';
    input += '<li><a href="javascript:void(0)" onclick="removeThis(this)"><i class="icon icon-minus"></i></a></li>';
    
    input = '<ul class="div_'+idTabel+'_'+jmlBaris+' classInline">'+input+'</ul>';
    if (parent.find(""))
    $('#div_'+idTabel+'_'+idRuangan).append(input);
    
    $.post( "<?php echo $this->createUrl('ajaxListDokter') ?>", {idRuangan:idRuangan},function( data ) {
        $('#jadwalDokter_'+idTabel+'_'+idRuangan+'_'+jmlBaris).html(data.options);
    },'json');
    $("#div_"+idTabel+"_"+idRuangan+" ul.div_"+idTabel+'_'+jmlBaris+".classInline li .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
    $("#div_"+idTabel+"_"+idRuangan+" ul.div_"+idTabel+'_'+jmlBaris+".classInline li .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','beforeShow':function(){customRange(this);},'dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
}
    
function customRange(input) 
{ 
        var min = new Date(2008, 11 - 1, 1); //Set this to your absolute minimum date
        var dateMin = min;
        var dateMax = null;
        var dayRange = 6;  // Set this to the range of days you want to restrict to
    
//        myAlert($(input).attr('id'));
        if ($(input).attr('id') == "txtStartDate") 
        {
            if ($("#txtEndDate").datepicker("getDate") !== null)
            {
                dateMax = $("#txtEndDate").datepicker("getDate");
                dateMin = $("#txtEndDate").datepicker("getDate");
                dateMin.setDate(dateMin.getDate() - dayRange);
                if (dateMin < min)
                {
                        dateMin = min;
                }
             }
             else
             {
                dateMax = new Date(); //Set this to your absolute maximum date
             }   
             $("#txtStartDate").datepicker("option", "minDate",dateMin);
             
             if ($("#txtEndDate").val() !== null){
                  $("#txtStartDate").datepicker("option", "maxDate",$("#txtEndDate").datepicker("getDate"));
             }
             
        }
        else if ($(input).attr('id') == "txtEndDate")
        {
                dateMax = new Date(); //Set this to your absolute maximum date
                if ($("#txtStartDate").datepicker("getDate") !== null) 
                {
                        dateMin = $("#txtStartDate").datepicker("getDate");
                        var rangeMax = new Date(dateMin.getFullYear(), dateMin.getMonth(), dateMin.getDate() + dayRange);

                        if(rangeMax < dateMax)
                        {
                            dateMax = rangeMax; 
                        }
                }else{
                    
                }
                $("#txtEndDate").datepicker("option", "minDate",dateMin);
        }
            return {
                minDate: dateMin, 
                maxDate: dateMax
            }; 

}

function clientValidationFunc(obj){
    url = $("form").attr("action");
    error = "<div class='alert alert-block alert-error blockAlert'><p>Silahkan perbaiki kesalahan input berikut:</p><ul></ul></div>";
    $.ajax({
        type : 'post',
        dataType : 'json',
        data : $("form").serialize(),
        success : function(result){
            myAlert('Jadwal Berhasil dibuat !');
            if (result.error == 'no'){
                $("form").submit();
            }else{
                myAlert('Isikan data yg belum lengkap , dan Buat Jadwal terlebih dahulu !')
                $("form").find(".error").removeClass("error");
                $(".errorTable .blockAlert").remove();
                $(".errorTable2 .blockAlert").remove();
                for (var i in result.error){
                    $('[name="'+i+'"]').addClass("error");
                    for(var x=0;x<result.error[i].length;x++){
                        if ($('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable .blockAlert").length < 1){
                            $('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable").append(error);
                            $('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>'+result.error[i][x]+'</li>');
                        }
                        else{
                            $('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>'+result.error[i][x]+'</li>');
                        }
                    }
                }   
                if (result.error2.length > 0){
                    for(var i=0;i<result.error2.length;i++){
                        $('[name="'+result.error2[i]+'"]').addClass("error");
                        if ($('form table tr:first').find(".errorTable2 .blockAlert").length < 1){
                            $('form table tr:first').find(".errorTable2").append(error);
                            $('form table tr:first').find(".errorTable2 ul").append('<li>'+result.error2[i]+'</li>');
                        }
                        else{
                            $('form table tr:first').find(".errorTable2 ul").append('<li>'+result.error2[i]+'</li>');
                        }
                    }
                }
            }
        }
     });
}

function removeThis(obj){
    $(obj).parents(".classInline").remove();
}

function clearTransaksi(){
    $('#txtStartDate').val('');
    $('#txtEndDate').val('');
    $('#instalasi').val('');
}
function pilihSemua(obj){
	if($(obj).is(':checked')){
		$('#jadwalDokter_poliklinik input[name*="poliklinik"]').each(function(){
			 $(this).attr('checked',true);
		});
	 }else{
		  $('#jadwalDokter_poliklinik input[name*="poliklinik"]').each(function(){
			 $(this).removeAttr('checked');
		});
	 }
}
</script>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

