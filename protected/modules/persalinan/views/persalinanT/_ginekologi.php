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
                            <?php echo $form->error($modGinekologi, 'obs_periksadalam'); ?>
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
                        <?php echo Chtml::label(" Riwayat Kelahiran ", 'anak_ke', array('class' => 'control-label')) ?>
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
   
</fieldset>
<script>
    function inputRiwayatKehamilan()
    {
       var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?>'; 
       var tambah_anak_ke = $("#tambah_anak_ke").val();
       var tambah_keterangan = $("#tambah_keterangan").val(); 
       var no = $("#riwayatkelahiran tbody").find("tr").length;              
       
       $('#riwayatkelahiran tbody').append("<tr>\n\
                                                <td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkehamilanT_"+(no+1)+"_anak_ke' name = 'PSRiwayatkehamilanT["+(no+1)+"][anak_ke]' value = '"+tambah_anak_ke+"' >"+tambah_anak_ke+"</td>"+
                                               "<td><input readonly = TRUE type = 'hidden' id = 'PSRiwayatkehamilanT_"+(no+1)+"_keterangan' name = 'PSRiwayatkehamilanT["+(no+1)+"][keterangan]' value = '"+tambah_keterangan+"' >"+tambah_keterangan+"</td>\n\
                                                <td style='text-align:center;'>"+buttonMinus+"</td>\n\
</tr>");
    
       resetRiwayat();
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
</script>