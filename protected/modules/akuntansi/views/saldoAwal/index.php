<?php 

    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.treeview.js"></script>
<script type="text/javascript">
    var id_form = new Array();
</script>
<div class='white-container'>
    <legend class='rim2'>Saldo <b>Awal</b></legend>
    <table width="100%">
        <tr>
            <td width="45%">
                <ul id="tree_rekening_saldo" class="filetree treeview">
                    <li id="tree_rekening_satu">
                        <?php
                            $rekeningSatu = new AKRekening1M;
                            $rekeningDua = new AKRekening2M;
                            $rekeningTiga = new AKRekening3M;
                            $rekeningEmpat = new AKRekening4M;
                            $rekeningLima = new AKRekening5M;

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
                                                $id_kelompok_enam = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id . '_' . $val_empat->rekening4_id . '_' . $val_lima->rekening5_id;
                                                $parent_lima .= "<li><span class='file'>". $val_lima->nmrekening5 ."<span style='float:right'><a id_rek='". $id_kelompok_enam ."' value='". $val_lima->rekening5_id ."' href='#' onclick='tambahSaldoJenisRek(this);return false;' rel='tooltip' data-original-title='Klik untuk tambah<br>Saldo ". ucwords(strtolower($val_lima->nmrekening5)) ."'><i class='icon-plus-sign'></i></a></span></span></li>";
                                            }

                                            $kode_kelompok_lima = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3 . '_' . $val_empat->kdrekening4;
                                            $id_kelompok_lima = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id . '_' . $val_empat->rekening4_id;
                                            if(count($result_lima) > 0)
                                            {
                                                $parent_empat .= "<li><span class='folder'>". $val_empat->nmrekening4 ."</span><ul>". $parent_lima ."</ul></li>";
                                            }else{
                                                $parent_empat .= "<li class='expandable'><span class='folder'>". $val_empat->nmrekening4 ."</span></li>";                                            
                                            }
                                        }
    //                                    
                                        $kode_kelompok_empat = $val->kdrekening1 . '_' . $val_dua->kdrekening2 . '_' . $val_tiga->kdrekening3;
                                        $id_kelompok_empat = $val->rekening1_id . '_' . $val_dua->rekening2_id . '_' . $val_tiga->rekening3_id;
                                        if(count($result_empat) > 0)
                                        {
                                            $parent_tiga .= "<li><span class='folder'>". $val_tiga->nmrekening3 ."</span><ul>". $parent_empat ."</ul></li>";
                                        }else{
                                            $parent_tiga .= "<li class='expandable'><span class='folder'>". $val_tiga->nmrekening3 ."</span></li>";
                                        }


                                    }

                                    $kode_kelompok = $val->kdrekening1 . '_' . $val_dua->kdrekening2;
                                    $id_kelompok = $val->rekening1_id . '_' . $val_dua->rekening2_id;
                                    if(count($result_tiga) > 0)
                                    {
                                        $parent_dua .= "<li id='". $id_kelompok ."'><span class='folder'>". $val_dua->nmrekening2 ."</span><ul>". $parent_tiga ."</ul></li>";
                                    }else{
                                        $parent_dua .= "<li id='". $id_kelompok ."' class='expandable'><span class='folder'>". $val_dua->nmrekening2 ."</span></li>";
                                    }

                                }

                                $value_kode = $val->kdrekening1;
                                $value_id = $val->rekening1_id;
                                if(count($result_dua) > 0)
                                {
                                    $parent_satu .= "<li id='". $value_id ."'><span class='folder'>". $val->nmrekening1 ."</span><ul>". $parent_dua ."</ul></li>";
                                }else{
                                    $parent_satu .= "<li id='". $value_id ."' class='expandable'><span class='folder'>". $val->nmrekening1 ."</span></li>";
                                }
                            }
                        ?>
                        <span class="folder">
                            Struktur Rekening
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
        echo $this->renderPartial('__gridSaldoRekening', array('model'=>$AKSaldorekeningV));
    ?>
</div>
<script type="text/javascript">
    var frmSaldoKelompok = new String(<?php echo CJSON::encode($this->renderPartial('__formInputSaldoRekening',array('model'=>$model), true));?>);
    
    function setTreeMenu()
    {
        $("#tree_rekening_saldo").treeview({
            animated: "fast",
            collapsed: false,
            unique: true,
            persist: "cookie"
        });
    }
    setTreeMenu();
    
    function hapusIndexMenu()
    {
        for(key in id_form)
        {
            delete id_form[key];
        }
        $('#content_form').empty();
    }
    
    function tambahSaldoJenisRek(obj)
    {
        hapusIndexMenu();
        if (id_form['satu'] == undefined){
            $('#content_form').append(frmSaldoKelompok.replace());
            var title = $(obj).attr('data-original-title').split("<br>");
            var id_rek = $(obj).attr('id_rek').split("_");
            for(var i=0;i<id_rek.length;i++)
            {
                $('#fieldsetSaldoKelRek').find("input[name$='[rekening"+ (parseInt(i)+1) +"_id]']").val(id_rek[i]);
            }
            
            $('.currency').each(function(){
                    $(this).maskMoney(
                        {"symbol":"Rp. ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                }
            );
            
            $('#fieldsetSaldoKelRek').find('legend[class="rim"]').text("Tambah " + title[1]);
            id_form['satu'] = 'yes';
        }
    }
    
    function editSaldoJenisRek(obj)
    {
        hapusIndexMenu();
        $('#pop_up_content').empty();
        $("#dialogEditSaldoRekening").dialog("open");
        $('#pop_up_content').append(frmSaldoKelompok.replace());
        
        var title = $(obj).attr('data-original-title').split("<br>");
        $('#fieldsetSaldoKelRek').find('legend[class="rim"]').text("Edit " + title[1]);
        
        var value = $(obj).attr('value');
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInformasiSaldo');?>", {id:value},
            function(data){
                $.each(data, function(key, value){
                    $("#form-saldo-kel-rekening").find("input[type=text][name$='["+ key +"]']").val(value);
                    $("#form-saldo-kel-rekening").find("input[type=hidden][name$='["+ key +"]']").val(value);
                    $("#form-saldo-kel-rekening").find("select[name$='["+ key +"]']").val(value);
                });
                
                $('.currency').each(function(){
                        $(this).maskMoney(
                            {"symbol":"Rp. ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                        );
                    }
                );                
            }, "json"
        );
    }    
    
</script>

<!--__formInputSaldoRekening-->

