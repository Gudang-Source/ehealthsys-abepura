<div class="block-tabel">
    <h6>Tabel <b>Diagnosa (ICD X)</b></h6>
    <?php
    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>Tambah Diagnosa X', 
            array(
                'onclick' => 'tambahDiagnosax();return false;',
                'class' => 'btn btn-primary',
                'rel' => "tooltip",
                'title' => "Klik untuk menambahkan Diagnosa X Pasien",
            )
        );
    ?>    
    <table class="table table-striped table-condensed" id="tbl_diagnosax">
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
                                echo $form->hiddenField($model[$i],"[$i]diagnosa_id");
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
                                        'name'=>"PPDiagnosaM[$i][diagnosa_kode]",
                                        'sourceUrl'=> $this->createUrl('getDiagnosaM&param=kode'),
                                        'value'=>$model[$i]->diagnosa->diagnosa_kode,
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength' => 3,
                                            'focus'=> 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select'=>'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                                    $(this).val( ui.item.diagnosa_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_nama]"]\').val(ui.item.diagnosa_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_namalainnya]"]\').val(ui.item.diagnosa_namalainnya);
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
                                        'name'=>"PPDiagnosaM[$i][diagnosa_nama]",
                                        'sourceUrl'=> $this->createUrl('getDiagnosaM&param=nama'),
                                        'value'=>$model[$i]->diagnosa->diagnosa_nama,
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength' => 3,
                                            'focus'=> 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select'=>'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                                    $(this).val( ui.item.diagnosa_nama);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_kode]"]\').val(ui.item.diagnosa_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_namalainnya]"]\').val(ui.item.diagnosa_namalainnya);
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
                                        'name'=>"PPDiagnosaM[$i][diagnosa_namalainnya]",
                                        'sourceUrl'=> $this->createUrl('getDiagnosaM&param=lainnya'),
                                        'value'=>$model[$i]->diagnosa->diagnosa_namalainnya,
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength' => 3,
                                            'focus'=> 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select'=>'js:function( event, ui ){
                                                if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                                    $(this).val( ui.item.diagnosa_namalainnya);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_kode]"]\').val(ui.item.diagnosa_kode);
                                                    $(this).parents("tr").find(\'input[name$="[diagnosa_nama]"]\').val(ui.item.diagnosa_nama);
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
                                echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosa(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Menghapus Diagnosa"));
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
    var trUraian=new String(<?php echo CJSON::encode($this->renderPartial($path_view . '_formDiagnosaICDX',array('form'=>$form,'modUraian'=>$modUraian),true));?>);
    var id_diagnosax = new Array();
    
    function setDiagnosax(){
        var xxx = null;
        $('#tbl_diagnosax tbody tr').each(function(){
            xxx = $(this).find('input[name$="[diagnosa_kode]"]').val();
            id_diagnosax[xxx]='yes';
        });
    }
    setDiagnosax();
    
    function tambahDiagnosax(){
        $('#dialogTambahDiagnosax').dialog("open");
    }
    
    function hapusDiagnosa(mine)
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
                                    var temp_diagnosa_kode = $(this).parents("tr").find('input[name$="diagnosa_kode"]').val();
                                    delete id_diagnosax[temp_diagnosa_kode];
                                    $(mine).parents('tr').remove();
                                }else{
                                    myAlert('Data diagnosa gagal dihapus');
                                }   
                        } ,
                        'cache':false});
           return false; 
        }else{
            var temp_diagnosaicdx_kode = $(mine).parents("tr").find('input[name$="[diagnosa_kode]"]').val();
//            myAlert(temp_diagnosaicdx_kode);
            delete id_diagnosax[temp_diagnosaicdx_kode];
            $(mine).parents('tr').remove();            
        }
    }
    
    function inputDiagnosa(mine, params, kode){
        $('#tbl_diagnosax').children('tbody').find("#is_kosong").remove();
        
        if (id_diagnosax[kode] == undefined){
            $('#tbl_diagnosax').children('tbody').append(trUraian.replace());
            $("#PPPasienMorbiditasT_99_diagnosa_id").val(params);
            var x=0;
            $(mine).parents('tr').find('td').each(
                function(){
                    if(x == 1)
                    {
                        $("#PPDiagnosaM_99_diagnosa_kode").val($(this).text());
                        id_diagnosax.push($(this).text());
                    }else if(x == 2){
                        $("#PPDiagnosaM_99_diagnosa_nama").val($(this).text());
                    }else if(x == 3){
                        $("#PPDiagnosaM_99_diagnosa_namalainnya").val($(this).text());
                    }
                    x++;
                }
            );
			$(mine).parents('table').find('#selectPasien').addClass("animation-loading-1");
            setTimeout(function(){
                renameInput('PPPasienMorbiditasT','tglmorbiditas');
                renameInput('PPPasienMorbiditasT','kelompokdiagnosa_id');
                renameInput('PPPasienMorbiditasT','pegawai_id');
                
                renameInput('PPPasienMorbiditasT','pasienmorbiditas_id');
                renameInput('PPPasienMorbiditasT','diagnosa_id');
                
                renameInput('PPDiagnosaM','diagnosa_kode');
                renameInput('PPDiagnosaM','diagnosa_nama');
                renameInput('PPDiagnosaM','diagnosa_namalainnya');
				$(mine).parents('table').find('#selectPasien').removeClass("animation-loading-1");
            }, 500);
            id_diagnosax[kode] = 'yes';
        }else{
            myAlert("Diagnosa yang anda input telah terdaftar, coba cek lagi");
        }
        

    }
    
    function renameInput(modelName,attributeName)
    {
        var trLength = $('#tbl_diagnosax tbody tr').length;
        var i = 0;
        $('#tbl_diagnosax tbody tr').each(function(){
            $(this).find('.no_urut').text(i+1);
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            jQuery('#PPPasienMorbiditasT_'+ i +'_tglmorbiditas').datepicker(
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
	
            jQuery('#PPDiagnosaM_'+ i +'_diagnosa_kode').autocomplete({
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){return false;},
                'select':function( event, ui ){return false;},
                'source':'<?php echo $this->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/getDiagnosaM&param=kode'); ?>'}
            );
            
            jQuery('#PPDiagnosaM_'+ i +'_diagnosa_nama').autocomplete({
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){return false;},
                'select':function( event, ui ){return false;},
                'source':'<?php echo $this->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/getDiagnosaM&param=nama'); ?>'}
            );
            
            jQuery('#PPDiagnosaM_'+ i +'_diagnosa_namalainnya').autocomplete({
                'showAnim':'fold',
                'minLength':3,
                'focus':function( event, ui ){return false;},
                'select':function( event, ui ){return false;},
                'source':'<?php echo $this->createUrl('pendaftaranPenjadwalan/verifikasiDiagnosa/getDiagnosaM&param=lainnya'); ?>'}
            );
            
            i++;
        });
    }

</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahDiagnosax',
    'options' => array(
        'title' => 'Daftar Diagnosa X',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
    $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
    $modDiagnosa->unsetAttributes();
    if(isset($_GET['PPDiagnosaM'])) {
        $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'PPdiagnosa-m-grid',
            'dataProvider'=>$modDiagnosa->search(),
            'filter'=>$modDiagnosa,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-condensed',
            'columns'=>array(
                array(
                    'name'=>'diagnosa_nourut',
                    'value'=>'$data->diagnosa_nourut',
                    'filter'=>false,
                ),
                'diagnosa_kode',
                'diagnosa_nama',
                'diagnosa_namalainnya',
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                    "id" => "selectPasien",
                    "onClick" => "inputDiagnosa(this,$data->diagnosa_id, \'$data->diagnosa_kode\');return false;"))',
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
);
$this->endWidget();
?>