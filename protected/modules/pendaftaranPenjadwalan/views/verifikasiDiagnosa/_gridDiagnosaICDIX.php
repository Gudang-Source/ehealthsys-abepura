<div class="block-tabel">
    <h6>Tabel <b>Diagnosa (ICD IX)</b></h6>
    <div style="margin:3px;">
        <?php
        echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>Tambah Diagnosa IX', 
                array(
                    'onclick' => 'tambahDiagnosaix();return false;',
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Diagnosa IX Pasien",
                )
            );
        ?>
    </div>
    <table class="table table-striped table-condensed" id="tbl_diagnosaix">
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl. Diagnosa</th>
                <th>Kelompok Diagnosa</th>
                <th>Dokter</th>
                <th>Kode Diagnosa</th>
                <th>Nama Diagnosa</th>
                <th>Nama Lain</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($model) > 0){
                $i=0;
                foreach($model as $val)
                {
            ?>
                    <tr>
                        <td class="no_urut"><?php echo $i+1; ?></td>
                        <td>
                            <?php
                                $this->widget('MyDateTimePicker',
                                    array(
                                        'model'=>$model[$i],
                                        'attribute'=>"[$i]tglmorbiditas",
                                        'mode'=>'datetime',
                                        'options'=> array(
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array(
                                            'readonly'=>true,
                                            'class'=>'dtPicker2',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"
                                        ),
                                    )
                                );
                                echo $form->hiddenField($model[$i],"[$i]pasienmorbiditas_id");
                                echo $form->hiddenField($model[$i],"[$i]diagnosaicdix_id");
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $form->dropDownList($model[$i],"[$i]kelompokdiagnosa_id", CHtml::listData(PPKelompokDiagnosaM::model()->findAll(), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                ));
                                echo $form->error($model[$i], "[$i]kelompokdiagnosa_id");
                            ?>
                        </td>
                        <td>
                            <?php
                                echo $form->dropDownList($model[$i],"[$i]pegawai_id", CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                ));
                                echo $form->error($model[$i], "[$i]pegawai_id");
                            ?>
                        </td>
                        <td>
                          <?php
                                $this->widget('MyJuiAutoComplete',
                                    array(
                                        'name'=>"DiagnosaicdixM[$i][diagnosaicdix_kode]",
                                        'sourceUrl'=> $this->createUrl('getDiagnosaixM&param=kode'),
                                        'value'=>$model[$i]->diagnosatindakan->diagnosaicdix_kode,
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength' => 3,
                                            'focus'=> 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select'=>'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                                    $(this).val( ui.item.diagnosaicdix_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
                                                }else{
                                                    myAlert("Diagnosa telah terdaftar, coba cek lagi");
                                                }
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions'=>array(
                                            'placeholder'=>'Ketikan Kode Diagnosa',
                                            'aria-haspopup'=>"true",
                                            'aria-autocomplete'=>'list',
                                            'role'=>'textbox',
                                            'autocomplete'=>'off',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            'class'=>'span2 ui-autocomplete-input'
                                        )
                                    )
                                );
                            ?>
                        </td>
                        <td>
                          <?php
                                $this->widget('MyJuiAutoComplete',
                                    array(
                                        'name'=>"DiagnosaicdixM[$i][diagnosaicdix_nama]",
                                        'sourceUrl'=> $this->createUrl('getDiagnosaixM&param=nama'),
                                        'value'=>$model[$i]->diagnosatindakan->diagnosaicdix_nama,
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength' => 3,
                                            'focus'=> 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select'=>'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                                    $(this).val( ui.item.diagnosaicdix_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
                                                }else{
                                                    myAlert("Diagnosa telah terdaftar, coba cek lagi");
                                                }
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions'=>array(
                                            'placeholder'=>'Ketikan Nama Diagnosa',
                                            'aria-haspopup'=>"true",
                                            'aria-autocomplete'=>'list',
                                            'role'=>'textbox',
                                            'autocomplete'=>'off',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            'class'=>'span2 ui-autocomplete-input'
                                        )
                                    )
                                );
                            ?>
                        </td>
                        <td>
                          <?php
                                $this->widget('MyJuiAutoComplete',
                                    array(
                                        'name'=>"DiagnosaicdixM[$i][diagnosaicdix_namalainnya]",
                                        'sourceUrl'=> $this->createUrl('getDiagnosaixM&param=lainnya'),
                                        'value'=>$model[$i]->diagnosatindakan->diagnosaicdix_namalainnya,
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength' => 3,
                                            'focus'=> 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select'=>'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                                    $(this).val( ui.item.diagnosaicdix_namalainnya);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
                                                }else{
                                                    myAlert("Diagnosa telah terdaftar, coba cek lagi");
                                                }
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions'=>array(
                                            'placeholder'=>'Ketikan Nama Lainnya Diagnosa',
                                            'aria-haspopup'=>"true",
                                            'aria-autocomplete'=>'list',
                                            'role'=>'textbox',
                                            'autocomplete'=>'off',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            'class'=>'span2 ui-autocomplete-input'
                                        )
                                    )
                                );
                            ?>        
                        </td>
                        <td style="text-align: center">
                            <?php
                                echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "",array("onclick"=>"hapusDiagnosaix(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Menghapus Diagnosa"));
                            ?>
                        </td>
                    </tr>
            <?php
                $i++;
                }
            }else{
            ?>
            <tr id="is_kosong">
                <td align="center" colspan="8">Data tidak ditemukan</td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php
    $modUraian->pegawai_id = $modPendaftaran->pegawai_id;
    $modUraian->kelompokdiagnosa_id = 1;
?>
<script type="text/javascript">
    var trUraianix=new String(<?php echo CJSON::encode($this->renderPartial($path_view . '_formDiagnosaICDIX',array('form'=>$form,'modUraian'=>$modUraian),true));?>);

    function setDiagnosaix(){
        var xxx = null;
        $('#tbl_diagnosaix tbody tr').each(function(){
            xxx = $(this).find('input[name$="[diagnosaicdix_kode]"]').val();
            id_diagnosax[xxx]='yes';
        });
    }
    setDiagnosaix();
    
    function tambahDiagnosaix(){
        $('#dialogTambahDiagnosaix').dialog("open");
    }
    
    function hapusDiagnosaix(mine)
    {
        var pasienmorbiditas_id = $(mine).parents('tr').find('input[name$="[pasienmorbiditas_id]"]').val();
        if(pasienmorbiditas_id.length > 0)
        {
            jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/hapusDiagnosax')?>',
                        'data':{pasienmorbiditas_id:pasienmorbiditas_id},
                        'type':'post',
                        'dataType':'json',
                        'success':function(data) {
                                if (data.status == 'ok') {
                                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosa_kode"]').val();
                                    delete id_diagnosax[temp_diagnosaicdix_kode];
                                    $(mine).parents('tr').remove();
                                }else{
                                    myAlert('Data diagnosa gagal dihapus');
                                }   
                        } ,
                        'cache':false});
           return false; 
        }else{
            var diagnosaicdix_id = $(mine).parents('tr').find('input[name$="[diagnosaicdix_id]"]').val();
            delete id_diagnosax[diagnosaicdix_id];
            $(mine).parents('tr').remove();        
        }
    }
    
    function inputDiagnosaix(mine, params, kode){
        $('#tbl_diagnosaix').children('tbody').find("#is_kosong").remove();
        if (id_diagnosax[kode] == undefined){
            $('#tbl_diagnosaix').children('tbody').append(trUraianix.replace());
            $("#PPPasienMorbiditasix_99_diagnosaicdix_id").val(params);
            var x=0;
            $(mine).parents('tr').find('td').each(
                function(){
                    if(x == 1)
                    {
                        $("#DiagnosaicdixM_99_diagnosaicdix_kode").val($(this).text());
                        $("#diagnosaicdix_kode_temp").val($(this).text());
                        id_diagnosax.push($(this).text());
                    }else if(x == 2){
                        $("#DiagnosaicdixM_99_diagnosaicdix_nama").val($(this).text());
                    }else if(x == 3){
                        $("#DiagnosaicdixM_99_diagnosaicdix_namalainnya").val($(this).text());
                    }
                    x++;
                }
            );
			$(mine).parents('table').find('#selectPasien').addClass("animation-loading-1");
            setTimeout(function(){
				
                renameInputix('PPPasienMorbiditasix','tglmorbiditas');
                renameInputix('PPPasienMorbiditasix','kelompokdiagnosa_id');
                renameInputix('PPPasienMorbiditasix','pegawai_id');
                
                renameInputix('PPPasienMorbiditasix','pasienmorbiditas_id');
                renameInputix('PPPasienMorbiditasix','diagnosaicdix_id');
                
                renameInputix('DiagnosaicdixM','diagnosaicdix_kode');
                renameInputix('DiagnosaicdixM','diagnosaicdix_nama');
                renameInputix('DiagnosaicdixM','diagnosaicdix_namalainnya');
				$(mine).parents('table').find('#selectPasien').removeClass("animation-loading-1");
            }, 500);
            id_diagnosax[kode] = 'yes';
        }else{
            myAlert("Diagnosa yang anda input telah terdaftar, coba cek lagi");
        }
        

    }
    
    function renameInputix(modelName,attributeName)
    {
        var trLength = $('#tbl_diagnosaix tbody tr').length;
        var i = 0;
        $('#tbl_diagnosaix tbody tr').each(function(){
            $(this).find('.no_urut').text(i+1);
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            jQuery('#PPPasienMorbiditasix_'+ i +'_tglmorbiditas').datepicker(
                jQuery.extend(
                    {showMonthAfterYear:false},
                    jQuery.datepicker.regional['id'],
                    {
                        'dateFormat':'dd M yy',
                        'maxDate':'d',
                        'timeText':'Waktu',
                        'hourText':'Jam',
                        'minuteText':'Menit',
                        'secondText':'Detik',
                        'showSecond':true,
                        'timeOnlyTitle':'Pilih Waktu',
                        'timeFormat':'hh:mm:ss',
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'yearRange':'-80y:+20y'
                    }
                )
            );
            
            jQuery('#DiagnosaicdixM_'+ i +'_diagnosaicdix_kode').autocomplete({
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){return false;},
                'select':function( event, ui ){
                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosaicdix_kode_temp"]').val();
                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                        delete id_diagnosax[temp_diagnosaicdix_kode];
                        
                        $(this).val( ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_id]"]').val(ui.item.diagnosaicdix_id);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_nama]"]').val(ui.item.diagnosaicdix_nama);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_namalainnya]"]').val(ui.item.diagnosaicdix_namalainnya);
                        
                        id_diagnosax.push(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode_temp]"]').val(ui.item.diagnosaicdix_kode);
                    }else{
                        myAlert("Diagnosa telah terdaftar, coba cek lagi");
                    }
                    return false;                    
                },
                'source':'<?php echo $this->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/getDiagnosaixM&param=kode'); ?>'}
            );
            
            jQuery('#DiagnosaicdixM_'+ i +'_diagnosaicdix_nama').autocomplete({
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){return false;},
                'select':function( event, ui ){
                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosaicdix_kode_temp"]').val();
                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                        delete id_diagnosax[temp_diagnosaicdix_kode];
                        
                        $(this).val( ui.item.diagnosaicdix_nama);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_id]"]').val(ui.item.diagnosaicdix_id);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode]"]').val(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_namalainnya]"]').val(ui.item.diagnosaicdix_namalainnya);
                        
                        id_diagnosax.push(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode_temp]"]').val(ui.item.diagnosaicdix_kode);                        
                    }else{
                        myAlert("Diagnosa telah terdaftar, coba cek lagi");
                    }
                    return false;                    
                },
                'source':'<?php echo $this->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/getDiagnosaixM&param=nama'); ?>'}
            );
            
            jQuery('#DiagnosaicdixM_'+ i +'_diagnosaicdix_namalainnya').autocomplete({
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){return false;},
                'select':function( event, ui ){
                    var temp_diagnosaicdix_kode = $(this).parents("tr").find('input[name$="diagnosaicdix_kode_temp"]').val();
                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                        delete id_diagnosax[temp_diagnosaicdix_kode];
                        
                        $(this).val( ui.item.diagnosaicdix_namalainnya);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_id]"]').val(ui.item.diagnosaicdix_id);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode]"]').val(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_nama]"]').val(ui.item.diagnosaicdix_nama);

                        id_diagnosax.push(ui.item.diagnosaicdix_kode);
                        $(this).parents("tr").find('input[name$="[diagnosaicdix_kode_temp]"]').val(ui.item.diagnosaicdix_kode);
                    }else{
                        myAlert("Diagnosa telah terdaftar, coba cek lagi");
                    }
                    return false;                    
                },
                'source':'<?php echo $this->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/getDiagnosaixM&param=lainnya'); ?>'}
            );
            
            i++;
        });
    }

</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahDiagnosaix',
    'options' => array(
        'title' => 'Daftar Diagnosa IX',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
    $modDiagnosaix = new DiagnosaicdixM();
    $modDiagnosaix->unsetAttributes();
    if(isset($_GET['DiagnosaicdixM'])) {
        $modDiagnosaix->attributes = $_GET['DiagnosaicdixM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'diagnosaix-m-grid',
            'dataProvider'=>$modDiagnosaix->search(),
            'filter'=>$modDiagnosaix,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-condensed',
            'columns'=>array(
                array(
                    'name'=>'diagnosaicdix_nourut',
                    'value'=>'$data->diagnosaicdix_nourut',
                    'filter'=>false,
                ),
                'diagnosaicdix_kode',
                'diagnosaicdix_nama',
                'diagnosaicdix_namalainnya',
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                    "id" => "selectPasien",
                    "onClick" => "inputDiagnosaix(this,$data->diagnosaicdix_id, \'$data->diagnosaicdix_kode\');return false;"))',
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
$this->endWidget();
?>