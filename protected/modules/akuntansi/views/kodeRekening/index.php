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
            <td width="45%">
                <ul id="browser" class="filetree treeview">
                    <li id="tree_rekening_satu">
                        <?php

                            $criteria=new CDbCriteria;
                            $params = array('rekening1_aktif' => true);
                            $criteria->order = 'rekening1_id';
                            $result = $rekeningSatu->findAllByAttributes($params, $criteria);
                            $parent_satu = '';
                            foreach($result as $val)
                            {
                                $params_dua = array(
                                    'rekening2_aktif' => true,
                                    'rekening1_id' => $val->rekening1_id,
                                );
                                $criteria->order = 'rekening2_id';
                                $result_dua = $rekeningDua->findAllByAttributes($params_dua, $criteria);
                                $parent_dua = '';
                                foreach($result_dua as $val_dua)
                                {
                                    $params_tiga = array(
                                        'rekening3_aktif' => true,
//                                        'rekening1_id' => $val_dua->rekening1_id,
                                        'rekening2_id' => $val_dua->rekening2_id,
                                    );
                                    $criteria->order = 'rekening3_id';
                                    $result_tiga = $rekeningTiga->findAllByAttributes($params_tiga, $criteria);
                                    $parent_tiga = '';
                                    foreach($result_tiga as $val_tiga)
                                    {
                                        $params_empat = array(
                                            'rekening4_aktif' => true,
//                                            'rekening1_id' => $val_tiga->rekening1_id,
//                                            'rekening2_id' => $val_tiga->rekening2_id,
                                            'rekening3_id' => $val_tiga->rekening3_id,
                                        );
                                        $criteria->order = 'rekening4_id';
                                        $result_empat = $rekeningEmpat->findAllByAttributes($params_empat, $criteria);
                                        $parent_empat = '';
                                        foreach($result_empat as $val_empat)
                                        {
                                            $params_lima = array(
                                                'rekening5_aktif' => true,
//                                                'rekening1_id' => $val_empat->rekening1_id,
//                                                'rekening2_id' => $val_empat->rekening2_id,
//                                                'rekening3_id' => $val_empat->rekening3_id,
                                                'rekening4_id' => $val_empat->rekening4_id,
                                            );
                                            $criteria->order = 'rekening5_id';
                                            $result_lima = $rekeningLima->findAllByAttributes($params_lima, $criteria);
                                            $parent_lima = '';
                                            foreach($result_lima as $val_lima)
                                            {
                                                $parent_lima .= "<li><span class='file'>". $val_lima->nmrekening5 ."<span style='float:right'><a value='". $val_lima->rekening5_id ."' href='#' onclick='editObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Detail Obyek Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                            }

                                            $kode_kelompok_lima = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3 . '_' . $val_empat->kdrekening4;
                                            $id_kelompok_lima = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id . '_' . $val_empat->rekening4_id;
                                            if(count($result_lima) > 0)
                                            {
                                                $parent_empat .= "<li><span class='folder'>". $val_empat->nmrekening4 ."<span style='float:right'><a max_kode='". $val_lima->kdrekening5 ."' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' href='#' onclick='tambahObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah detail Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening4_id ."' href='#' onclick='editObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Obyek Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_lima ."</ul></li>";
                                            }else{
                                                $parent_empat .= "<li class='expandable'><span class='folder'>". $val_empat->nmrekening4 ."<span style='float:right'><a max_kode='0' id_rek='". $id_kelompok_lima ."' kode_rek='". $kode_kelompok_lima ."' href='#' onclick='tambahObyekDetailRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah detail Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_empat->rekening4_id ."' href='#' onclick='editObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Obyek Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";                                            
                                            }
                                        }
    //                                    
                                        $kode_kelompok_empat = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3;
                                        $id_kelompok_empat = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id;
                                        if(count($result_empat) > 0)
                                        {
                                            $parent_tiga .= "<li><span class='folder'>". $val_tiga->nmrekening3 ."<span style='float:right'><a max_kode='". $val_empat->kdrekening4 ."' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' href='#' onclick='tambahObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening3_id ."' href='#' onclick='editJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Jenis Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_empat ."</ul></li>";
                                        }else{
                                            $parent_tiga .= "<li class='expandable'><span class='folder'>". $val_tiga->nmrekening3 ."<span style='float:right'><a max_kode='0' id_rek='". $id_kelompok_empat ."' kode_rek='". $kode_kelompok_empat ."' href='#' onclick='tambahObyekRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Objek Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_tiga->rekening3_id ."' href='#' onclick='editJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Jenis Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                        }


                                    }

                                    $kode_kelompok = $val->kdrekening1 . '_' . $val_dua->kdrekening2;
                                    $id_kelompok = $val_dua->rekening1_id . '_' . $val_dua->rekening2_id;
                                    if(count($result_tiga) > 0)
                                    {
                                        $parent_dua .= "<li id='". $id_kelompok ."'><span class='folder'>". $val_dua->nmrekening2 ."<span style='float:right'><a max_kode='". $val_tiga->kdrekening3 ."' id_rek='". $id_kelompok ."' kode_rek='". $kode_kelompok ."' href='#' onclick='tambahJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Jenis Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening2_id ."' href='#' onclick='editKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Kelompok Rekening'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_tiga ."</ul></li>";
                                    }else{
                                        $parent_dua .= "<li id='". $id_kelompok ."' class='expandable'><span class='folder'>". $val_dua->nmrekening2 ."<span style='float:right'><a max_kode='0' id_rek='". $id_kelompok ."' kode_rek='". $kode_kelompok ."' href='#' onclick='tambahJenisRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Jenis Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val_dua->rekening2_id ."' href='#' onclick='editKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Kelompok Rekening'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                    }

                                }

                                $value_kode = $val->kdrekening1;
                                $value_id = $val->rekening1_id;
                                if(count($result_dua) > 0)
                                {
                                    $parent_satu .= "<li id='". $value_id ."'><span class='folder'>". $val->nmrekening1 ."<span style='float:right'><a max_kode='". $val_dua->kdrekening2 ."' id_rek='". $value_id ."' kode_rek='". $value_kode ."' href='#' onclick='tambahKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening1_id ."' href='#' onclick='editStrukturRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Struktur Akun'><i class='icon-pencil-brown'></i></a></span></span><ul>". $parent_dua ."</ul></li>";
                                }else{
                                    $parent_satu .= "<li id='". $value_id ."' class='expandable'><span class='folder'>". $val->nmrekening1 ."<span style='float:right'><a max_kode='0' id_rek='". $value_id ."' kode_rek='". $value_kode ."' href='#' onclick='tambahKelompokRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah Kelompok Rekening'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='". $val->rekening1_id ."' href='#' onclick='editStrukturRekening(this);return false;' rel='tooltip' data-original-title='Klik untuk edit Struktur Akun'><i class='icon-pencil-brown'></i></a></span></span></li>";
                                }
                            }
                        ?>
                        <span class="folder">
                            Struktur Akun
                            <span style="float:right"><a max_kode = "<?php echo isset($val->kdrekening1) ? $val->kdrekening1 : null; ?>" href="#" onclick="tambahStrukturRekening(this);return false;" rel="tooltip" data-original-title="Klik untuk menambah Struktur Akun"><i class="icon-plus-sign"></i></a></span>
                        </span>
                        <?php
                            if(count($result) > 0)
                            {
                                echo '<ul>';
                                echo $parent_satu;
                                echo '</ul>';
                            }                    
                        ?>
                    </li>
                </ul>
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
        $('#fieldsetRekeningSatu').find('legend[class="rim"]').text("Edit Struktur Akun");
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
        $('#fieldsetRekeningDua').find('legend[class="rim"]').text("Edit Kelompok Rekening");
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
        $('#fieldsetJenisRekening').find('legend[class="rim"]').text("Edit Jenis Rekening");
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
        $('#fieldsetObyekRekening').find('legend[class="rim"]').text("Edit Obyek Rekening");
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

function tambahObyekDetailRekening(obj)
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
    }
}

function editObyekDetailRekening(obj)
{
    hapusIndexMenu();
    if (id_form['lima'] == undefined){
        $('#content_form').append(frmObyekDetailRekening.replace());
        id_form['lima'] = 'yes';
        var value = $(obj).attr('value');
        $('#fieldsetDetailObyekRekening').find('legend[class="rim"]').text("Edit Detail Obyek Rekening");
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

</script>