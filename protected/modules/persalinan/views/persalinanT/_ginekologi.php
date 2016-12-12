<fieldset id="panel-ginekologi" hidden>
    <fieldset class='box'>
        <legend class='rim'>Status Ginekologi</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi,  'tglperiksaobgyn', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modGinekologi,
                                'attribute' => 'tglperiksaobgyn',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            // echo $form->textField($modPemeriksaan, 'obs_periksadalam', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>                            
                        </div>
                    </div>
                    <?php /*
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_keluhan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_keluhan', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_keluhan'); ?>
                        </div>
                    </div>
                    */ ?>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_keluhan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                    'model'=>$modGinekologi,
                                    'attribute'=>'gin_keluhan',
                                    'data'=> explode(',', $modGinekologi->gin_keluhan),   
                                    'debugMode'=>true,
                                    'options'=>array(
                                        //'bricket'=>false,
                                        'json_url'=>$this->createUrl('RiwayatKehamilanKeluhan'),
                                        'addontab'=> true, 
                                        'maxitems'=> 10,
                                        'input_min_size'=> 0,
                                        'cache'=> true,
                                        'newel'=> true,
                                        'addoncomma'=>true,
                                        'select_all_text'=> "", 
                                        'autoFocus'=>true,
                                    ),
                                ));
                            ?>
                             <?php
                            //echo $form->textField($modGinekologi, 'gin_keluhan', array('style'=>'text-align:right;', 'class'=>'span4','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)).' Kali';
                            ?> 
                            <?php echo $form->error($modGinekologi, 'keluhanutama'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_jmlkawin_kali', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' Kali';
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_jmlkawin_kali'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <?php echo $form->labelEx($modGinekologi, 'gin_statuskawin', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->radioButton($modGinekologi, 'gin_statuskawin', array('value'=>  Params::STATUS_PERKAWINAN_KAWIN, 'uncheckValue'=>null)); ?> Masih Kawin
                            <?php echo $form->radioButton($modGinekologi, 'gin_statuskawin', array('value'=> Params::STATUS_PERKAWINAN_TIDAK_KAWIN, 'uncheckValue'=>null)); ?> Tidak
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_usiakawin_thn', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_usiakawin_thn', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' Tahun';
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_usiakawin_thn'); ?>
                        </div>
                    </div>
                      
                    <!--awal riwayat kelahiran-->
                    <div class="control-group ">
                        <?php echo Chtml::label(" Riwayat Kehamilan ", 'anak_ke', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php                            
                            echo Chtml::textField('tambah_anak_ke', '', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 2));
                            echo ' Keterangan '.Chtml::textField('tambah_keterangan', '', array('class'=>'span4 angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            echo ' &nbsp; ';
                            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                array('onclick' => 'inputRiwayatKehamilan();',
                                    'class' => 'btn btn-primary',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan riwayat kelahiran",));
                            ?>                                                         
                        </div>
                    </div>
                                                            
                        <?php $this->renderPartial('_riwayatkelahiran', array('modRiwayatKehamilan' => $modRiwayatKehamilan)); ?>
                    
                    <!--akhir riwayat kelahiran-->
                    
                   
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'pegawai_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $pegawai = new CDbCriteria();
                            $pegawai->with = array('ruanganpegawai');
                            $pegawai->addCondition("t.pegawai_aktif = TRUE ");
                            $pegawai->addCondition("ruanganpegawai.ruangan_id = ".Yii::app()->user->getState('ruangan_id')); 
                            $pegawai->addCondition('t.kelompokpegawai_id IN ('.Params::KELOMPOKPEGAWAI_ID_BIDAN.','.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.') ');
                            $pegawai->order = 't.nama_pegawai ASC';
                            
                            echo $form->dropDownList($modGinekologi, 'pegawai_id', 
                                    CHtml::listData(PSPegawaiM::model()->findAll($pegawai), 'pegawai_id', 'namaLengkap'),
                                    array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modGinekologi, 'pegawai_id'); ?>
                        </div>
                    </div>
                    
                    
                     <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_menarche_thn', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_menarche_thn', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' Tahun';
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_menarche_thn'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_siklushaid_hari', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_siklushaid_hari', array('style'=>'text-align:right;','class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' Hari';
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_siklushaid_hari'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_lamahaid_hari', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_lamahaid_hari', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' Hari';
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_lamahaid_hari'); ?>
                        </div>
                    </div>
                    
                     <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_darahhaid', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_darahhaid', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_darahhaid'); ?>
                        </div>
                    </div>
                    
                     <div class="control-group">
                        <?php echo Chtml::label("", 'gin_darahhaid_tambahkurang', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->radioButton($modGinekologi, 'gin_darahhaid_tambahkurang', array('value'=>  0, 'uncheckValue'=>null)); ?> Bertambah
                            <?php echo $form->radioButton($modGinekologi, 'gin_darahhaid_tambahkurang', array('value'=> 1, 'uncheckValue'=>null)); ?> Berkurang
                        </div>
                    </div>
                    
                    
                     <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_nafsumakan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_nafsumakan', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_nafsumakan'); ?>
                        </div>
                    </div>
                    
                     <div class="control-group">
                        <?php echo Chtml::label("", 'gin_nafsumakan_kurusgemuk', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->radioButton($modGinekologi, 'gin_nafsumakan_kurusgemuk', array('value'=>  0, 'uncheckValue'=>null)); ?> Menjadi Kurus
                            <?php echo $form->radioButton($modGinekologi, 'gin_nafsumakan_kurusgemuk', array('value'=> 1, 'uncheckValue'=>null)); ?> Menjadi Gemuk
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_mictio', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_mictio', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_mictio'); ?>
                        </div>
                    </div>
                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modGinekologi, 'gin_defecatio', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modGinekologi, 'gin_defecatio', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> 
                            <?php echo $form->error($modGinekologi, 'gin_defecatio'); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
  
    <!-- (Pemeriksaan Keluarga Berencana) -->
    <fieldset class='box'>
        <legend class='rim'>Pemeriksaan Keluarga Berencana (KB)</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo Chtml::label("Sudah KB", 'kb_status', array('class'=>'control-label')); ?>
                        <div class="controls">                                                        
                            <?php              
                                
                                if (empty($modRiwayatKB->kb_status)){
                                    if ($modRiwayatKB->kb_status !== false)
                                    {
                                        $modRiwayatKB->kb_status = 3;
                                    }else{
                                        $modRiwayatKB->kb_status = 0;
                                    }                                    
                                }else{
                                    if ($modRiwayatKB->kb_status !== false)
                                    {
                                        $modRiwayatKB->kb_status = 1;
                                    }else{
                                        $modRiwayatKB->kb_status = 0;
                                    }                                    
                                }
                                
                                echo $form->radioButton($modRiwayatKB,'kb_status', array('uncheckValue' => null,'class'=>'statuskb', 'value'=>  1, 'onchange'=>'cekStatusKb(this);')); ?> Ya
                            <?php echo $form->radioButton($modRiwayatKB,'kb_status', array('uncheckValue' => null,'class'=>'statuskb', 'value'=>  0, 'onchange'=>'cekStatusKb(this);' ));                                
                            ?> Tidak
                        </div>
                    </div>                                       
                </td>
            </tr>
            <tr>
                <td>            
                    <table  id ="kbYa" width="100%" class="table-condensed">
                        <tr style = "height:20px;">
                            <td>
                                <div class="control-group">
                                    <?php echo Chtml::label('Jenis', 'gin_statuskawin', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo Chtml::dropDownList('tambah_jenis_kb','tambah_jenis_kb', LookupM::getItems('jenisriwayatkb'), array('empty' => '-- Pilih --')); ?>                            
                                    </div>                                    
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <?php echo CHtml::label('Pasang', 'gin_statuskawin', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                            $this->widget('MyDateTimePicker', array(                                                
                                                'name' => 'tambah_pasang_kb',
                                                'mode' => 'datetime',
                                                'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                                    'maxDate' => 'd',                                                    
                                                ),
                                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                                ),
                                            ));                                          
                                        ?>                                        
                                    </div>                                    
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <?php echo Chtml::label('Lepas', 'gin_statuskawin', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php
                                            $this->widget('MyDateTimePicker', array(                                                
                                                'name' => 'tambah_lepas_kb',
                                                'mode' => 'datetime',
                                                'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                                    'maxDate' => 'd',                                                    
                                                ),
                                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                                ),
                                            ));                                          
                                        ?>  
                                        <?php //echo Chtml::textField("tambah_lepas_kb",'', array('class'=>'span3')); ?>                            
                                    </div>                                    
                                </div>
                            </td>
                            <td>
                                <div class="control-group">                                    
                                    <div class="controls">
                                        <?php 
                                            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                                array('onclick' => 'inputKB();',
                                                    'class' => 'btn btn-primary',
                                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                                    'rel' => "tooltip",
                                                    'title' => "Klik untuk menambahkan pemeriksaan keluarga berencana",));
                                        ?>                            
                                    </div>
                                </div>
                            </td>                            
                        </tr>    
                        <tr>
                            <td colspan="4">
                                <?php $this->renderPartial('_pemeriksaanKb', array('modRiwayatKB' => $modRiwayatKB, 'modGinekologi' => $modGinekologi)); ?>
                            </td>
                        </tr>
                    </table>
                    
                    <table id="kbNo">
                        <tr>
                            <td>
                                <div class="control-group">
                                    <?php echo Chtml::label('Keterangan', 'kb_keterangan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modRiwayatKB,'kb_keterangan', array('class'=>'span3')); ?>                            
                                    </div>
                                    <?php echo $form->error($modRiwayatKB, 'kb_keterangan'); ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </fieldset>
    
    <!--Pemeriksaan Luar dan Dalam AWAL-->
     <fieldset class='box'>
        <legend class='rim'>Pemeriksaan Luar dan Dalam</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class = "control-group">
                        <?php echo Chtml::label('Pemeriksaan Luar', 'gin_periksaluar', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modGinekologi,'gin_periksaluar', array('class'=>'span3 custom-only', 'maxlength' => 100)); ?>                            
                            </div>
                    </div>
                </td>
                <td>
                    <div class = "control-group">
                        <?php echo Chtml::label('Pemeriksaan Dalam', 'gin_periksadalam', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modGinekologi,'gin_periksadalam', array('class'=>'span3 custom-only', 'maxlength' => 100)); ?>                            
                            </div>
                    </div>
                </td>
            </tr>
        </table>        
     </fieldset>
    <!--Pemeriksaan Luar dan Dalam AKHIR-->
  
</fieldset>
<script>
    function inputRiwayatKehamilan()
    {
       var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?>'; 
       var tambah_anak_ke = $("#tambah_anak_ke").val();
       var tambah_keterangan = $("#tambah_keterangan").val(); 
       var no = $("#riwayatkelahiran tbody").find("tr").length;              
       
        if (tambah_anak_ke != '' && tambah_keterangan != ''){
            $('#riwayatkelahiran tbody').append("<tr>\n\
                                                     <td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkehamilanT_"+(no+1)+"_anak_ke' name = 'PSRiwayatkehamilanT["+(no+1)+"][anak_ke]' value = '"+tambah_anak_ke+"' >"+tambah_anak_ke+"</td>"+
                                                    "<td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkehamilanT_"+(no+1)+"_keterangan' name = 'PSRiwayatkehamilanT["+(no+1)+"][keterangan]' value = '"+tambah_keterangan+"' >"+tambah_keterangan+"</td>\n\
                                                     <td style='text-align:center;'>"+buttonMinus+"</td>\n\
            </tr>");
            resetRiwayat();
        }else{
            myAlert("Maaf, Riwayat Kehamilan dan Keterangan Tidak Boleh Kosong");
        }
    
       
    }
    
    function resetRiwayat()
    {
        $("#tambah_anak_ke").val('');
        $("#tambah_keterangan").val('');
    }
    
    function delRow(obj)
    {
         myConfirm('Apakah Anda yakin ingin menghapus data riwayat kelahiran ini ?','Perhatian!',function(r){
            if (r){
                $(obj).parent().parent().remove();
           }
        });
        
    }
    
    /*pemeriksaan kb awal*/
    function delRowKb(obj)
    {
         myConfirm('Apakah Anda yakin ingin menghapus data pemeriksaan KB ini ?','Perhatian!',function(r){
            if (r){
                $(obj).parent().parent().remove();
           }
        });
        
    }
    
    function inputKB()
    {
        var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRowKb(this); return false;')) ?>'; 
        var jenis_kb = $("#tambah_jenis_kb").val();
        var pasang_kb = $("#tambah_pasang_kb").val(); 
        var lepas_kb = $("#tambah_lepas_kb").val(); 
        var no = $("#pemeriksaanKbYa tbody").find("tr").length;           

        if (jenis_kb != '' && pasang_kb != '' && lepas_kb != ''){
            $('#pemeriksaanKbYa tbody').append("<tr>\n\
                        <td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkbT_"+(no+1)+"_kb_jenis' name = 'PSRiwayatkbT["+(no+1)+"][kb_jenis]' value = '"+jenis_kb+"' >"+jenis_kb+"</td>"+
                       "<td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkbT_"+(no+1)+"_kb_pasang' name = 'PSRiwayatkbT["+(no+1)+"][kb_pasang]' value = '"+pasang_kb+"' >"+pasang_kb+"</td>\n\
                        <td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkbT_"+(no+1)+"_kb_lepas' name = 'PSRiwayatkbT["+(no+1)+"][kb_lepas]' value = '"+lepas_kb+"' >"+lepas_kb+"</td>\n\
                        <td style='text-align:center;'>"+buttonMinus+"</td>\n\
            </tr>");
            resetKb();
        }else{
            myAlert("Maaf, Jenis, Pasang dan Lepas KB tidak boleh kosong");
        }
        
    }
    
    function resetKb(){
        $("#tambah_jenis_kb").val('');
        $("#tambah_pasang_kb").val('');
        $("#tambah_lepas_kb").val('');
    }
    
    function cekStatusKb(obj){ 
        var status = $(obj).val();
        var ya = $("#kbYa");
        var no = $("#kbNo");  
                            
        if($(obj).is(":checked")){
            if (status == 1){
                ya.show();
                no.hide();
            }else  if (status == 0){
                ya.hide();
                no.show();
            }
        }else{
            ya.hide();
            no.hide();
        }
            
    }
    
    $( document ).ready(function(){
        var cekStatus = '<?php echo $modRiwayatKB->kb_status ?>';
        cekStatusKb($("#PSRiwayatkbT_kb_status"));  
        
        if (cekStatus == 0){
            $("#kbYa").hide();
            $("#kbNo").show();
        }
            
    });
    
    /*pemeriksaan kb akhir*/
</script>