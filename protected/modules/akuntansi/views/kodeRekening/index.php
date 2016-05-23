<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.treeview.js"></script>
<script type="text/javascript">
    var id_form = new Array();
</script>

<!--
    referensi tree jquery
    http://jquery.bassistance.de/treeview/demo/
-->
<div class='white-container'>
    <legend class='rim2'>Master <b>Kode Akun</b></legend>
    <table width="100%">
        <tr>
            <td width="45%" id="ka-viewtree">
                <?php echo $this->renderPartial('__treeAkun', array(
                    'rekeningSatu' => $rekeningSatu,
                    'rekeningDua' => $rekeningDua,
                    'rekeningTiga' => $rekeningTiga,
                    'rekeningEmpat' => $rekeningEmpat,
                    'rekeningLima' => $rekeningLima,
                ), true); ?>
            </td>
            <td>
                <div id="content_form">
                    <div align="center">Klik Tombol Tambah untuk menampilkan<br>Form Inputan</div>
                </div>
            </td>
        </tr>
    </table>
    <hr />
    <?php
        echo $this->renderPartial('__dataGridRekening', array('model'=> $rekeningakuntansiV));
    ?>
</div>
<script type="text/javascript">
    var frmRekeningSatu = new String(<?php echo CJSON::encode($this->renderPartial('__formInputRekeningSatu',array('rekeningSatu'=>$rekeningSatu), true));?>);
    var frmRekeningDua = new String(<?php echo CJSON::encode($this->renderPartial('__formInputRekeningDua',array('rekeningDua'=>$rekeningDua), true));?>);
    var frmJenisRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputJenisRekening',array('jenisRekening'=>$rekeningTiga), true));?>);
    var frmObyekRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputObyekRekening',array('model'=>$rekeningEmpat), true));?>);
    var frmObyekDetailRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputObyekDetailRekening',array('model'=>$rekeningLima), true));?>);
function setTreeMenu()
{
    $("#browser").treeview({
        animated: "fast",
        collapsed: false,
        unique: true,
        persist: "cookie"
    });
}
setTreeMenu();

//function getTreeMenu()
//{
//    $.ajax({
//        url:"<?php echo Yii::app()->createUrl('ActionAjax/getTreeMenu')?>",
//        context:"#tree_rekening_satu"
//    }).done(
//        function(data){
//            data = jQuery.parseJSON(data);
//            $("#tree_rekening_satu").empty();
//            
//            setTimeout(function(){
//                $("#tree_rekening_satu").append(data);
//                setTreeMenu();
//                jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({'placement':'bottom'});
//            }, 50);
//        }
//    );
//}

function hapusIndexMenu()
{
    for(key in id_form)
    {
        delete id_form[key];
    }
    $('#content_form').empty();
}

function tambahStrukturRekening(obj)
{
    hapusIndexMenu();
    if (id_form['satu'] == undefined){
        $('#content_form').append(frmRekeningSatu.replace());
        id_form['satu'] = 'yes';
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;		
		if(!jQuery.isNumeric(max_kode)){
			max_kode = 1;
		}
		        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = //"0" + 
                    max_kode;
        }
        $('#fieldsetRekeningSatu').find("input[name$='[kdrekening1]']").val(max_kode);
    }
}

function editStrukturRekening(obj)
{
    hapusIndexMenu();
    if (id_form['satu'] == undefined){
        $('#content_form').append(frmRekeningSatu.replace());
        id_form['satu'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetRekeningSatu').find('legend[class="rim"]').text("Edit Komponen");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiStruktur');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-rekening-satu").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-rekening-satu").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-rekening-satu").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'rekening1_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-rekening-satu").find("input[type=radio][id='AKRekening1M_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function tambahKelompokRekening(obj)
{
    hapusIndexMenu();
    if (id_form['dua'] == undefined){
        $('#content_form').append(frmRekeningDua.replace());
        id_form['dua'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = //"0" + 
                    max_kode;
        }
        var kode_rek = $(obj).attr('kode_rek');
        var id_rek = $(obj).attr('id_rek');
        
        $('#fieldsetRekeningDua').find("input[name$='[rekening1_id]']").val(id_rek);
        $('#fieldsetRekeningDua').find("input[name$='[kdrekening1]']").val(kode_rek);
        $('#fieldsetRekeningDua').find("input[name$='[kdrekening2]']").val(max_kode);
    }
}

function editKelompokRekening(obj)
{
    hapusIndexMenu();
    if (id_form['satu'] == undefined){
        $('#content_form').append(frmRekeningDua.replace());
        id_form['satu'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetRekeningDua').find('legend[class="rim"]').text("Edit Unsur");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiKelompok');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-rekening-dua").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-rekening-dua").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-rekening-dua").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'rekening2_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-rekening-dua").find("input[type=radio][id='AKRekening2M_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}


function tambahJenisRekening(obj)
{
    hapusIndexMenu();
    if (id_form['tiga'] == undefined){
        $('#content_form').append(frmJenisRekening.replace());
        id_form['tiga'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = //"0" + 
                    max_kode;
        }        
        
        var kode_rek = $(obj).attr('kode_rek').split("_");
        var id_rek = $(obj).attr('id_rek').split("_");
        
        $('#fieldsetJenisRekening').find("input[name$='[rekening2_id]']").val(id_rek[1]);
        
        $('#fieldsetJenisRekening').find("input[name$='[kdrekening2]']").val(kode_rek[1]);
        $('#fieldsetJenisRekening').find("input[name$='[kdrekening3]']").val(max_kode);
    }
}

function editJenisRekening(obj)
{
    hapusIndexMenu();
    if (id_form['tiga'] == undefined){
        $('#content_form').append(frmJenisRekening.replace());
        id_form['tiga'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetJenisRekening').find('legend[class="rim"]').text("Edit Kelompok Pos");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiJenis');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-jenis-rekening").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-jenis-rekening").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-jenis-rekening").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'rekening3_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-jenis-rekening").find("input[type=radio][id='AKRekening3M_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function tambahObyekRekening(obj)
{
    hapusIndexMenu();
    if (id_form['empat'] == undefined){
        $('#content_form').append(frmObyekRekening.replace());
        id_form['empat'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = // "0" + 
                    max_kode;
        }
        
        var kode_rek = $(obj).attr('kode_rek').split("_");
        var id_rek = $(obj).attr('id_rek').split("_");
        
        $('#fieldsetObyekRekening').find("input[name$='[rekening3_id]']").val(id_rek[2]);
        
        $('#fieldsetObyekRekening').find("input[name$='[kdrekening3]']").val(kode_rek[2]);
        $('#fieldsetObyekRekening').find("input[name$='[kdrekening4]']").val(max_kode);
    }
}

function editObyekRekening(obj)
{
    hapusIndexMenu();
    if (id_form['empat'] == undefined){
        $('#content_form').append(frmObyekRekening.replace());
        id_form['empat'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetObyekRekening').find('legend[class="rim"]').text("Edit Pos");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiObyek');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-obyek-rekening").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-obyek-rekening").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-obyek-rekening").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'rekening4_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-obyek-rekening").find("input[type=radio][id='AKRekening4M_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function tambahObyekDetailRekening(obj, normal)
{
    hapusIndexMenu();
    if (id_form['empat'] == undefined){
        $('#content_form').append(frmObyekDetailRekening.replace());
        id_form['empat'] = 'yes';
        
        var max_kode = $(obj).attr('max_kode');
        max_kode = parseInt(max_kode);
        max_kode = max_kode+1;
        if(max_kode.length > 1){
            max_kode = max_kode;
        }else{
            max_kode = //"0" + 
                    max_kode;
        }        
        
        var kode_rek = $(obj).attr('kode_rek').split("_");
        var id_rek = $(obj).attr('id_rek').split("_");
        
        
        $('#fieldsetDetailObyekRekening').find("input[name$='[rekening4_id]']").val(id_rek[3]);
        
        
        $('#fieldsetDetailObyekRekening').find("input[name$='[kdrekening4]']").val(kode_rek[3]);
        $('#fieldsetDetailObyekRekening').find("input[name$='[kdrekening5]']").val(max_kode);
        $('#fieldsetDetailObyekRekening').find("select[name$='[rekening5_nb]']").val(normal);
    }
}

function editObyekDetailRekening(obj)
{
    hapusIndexMenu();
    if (id_form['lima'] == undefined){
        $('#content_form').append(frmObyekDetailRekening.replace());
        id_form['lima'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetDetailObyekRekening').find('legend[class="rim"]').text("Edit Akun");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiDetailObyek');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-detail-obyek-rekening").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-detail-obyek-rekening").find("textarea[name$='["+ key +"]']").val(value);
                    $("#form-detail-obyek-rekening").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-detail-obyek-rekening").find("select[name$='["+ key +"]']").val(value);
                    
                    if(key == 'rekening5_aktif')
                    {
                        var x = 0;
                        if(value == true){
                            x = 1;
                        }
                        key = key +"_"+ x;
                        $("#form-detail-obyek-rekening").find("input[type=radio][id='AKRekening5M_"+ key +"']").attr('checked', true);
                    }
                });
            }, "json"
        );        
    }
}

function refreshTree() {
    $("#ka-viewtree").empty();
    $.post("<?php echo $this->createUrl('index'); ?>", {
        is_ajax:true,
        f:"loadTree",
    }, function(data) {
        $("#ka-viewtree").html(data);
        setTreeMenu();
    });
}

</script>