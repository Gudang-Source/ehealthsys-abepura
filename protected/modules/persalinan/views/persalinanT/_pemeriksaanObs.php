<?php
    if (isset($modPemeriksaLama)){
        if (count($modPemeriksaLama)>0){
            // obstetrik
            $modPemeriksaan->obs_fundusuteri = $modPemeriksaLama->obs_fundusufen;
            $modPemeriksaan->obs_posisijanin = $model->posisijanin;
            $modPemeriksaan->obs_periksadalam = $modPemeriksaLama->obs_periksadalam;
            $modPemeriksaan->obs_portio = $modPemeriksaLama->portio_genitalia;
            $modPemeriksaan->obs_konsistensigenitalia = $modPemeriksaLama->obs_konsistensigenitalia;
            $modPemeriksaan->obs_arah = $modPemeriksaLama->obs_arah;
            $modPemeriksaan->obs_ketuban = $modPemeriksaLama->ketuban_genitalia;
            $modPemeriksaan->obs_pemeriksa = $modPemeriksaLama->obs_pemeriksa;
            $modPemeriksaan->obs_warnaketuban = $modPemeriksaLama->obs_warnaketuban;
            $modPemeriksaan->obs_bagrendah = $modPemeriksaLama->penurunan_genitalia;
            $modPemeriksaan->obs_hodge = $modPemeriksaLama->obs_hodge;
            $modPemeriksaan->obs_posisigenital = $modPemeriksaLama->posisi_genitalia;
            $modPemeriksaan->obs_fetopelvik = $modPemeriksaLama->obs_fetofelvik;
            $modPemeriksaan->obs_presentasigenital = $modPemeriksaLama->presentasi_genitalia;
            $modPemeriksaan->obs_frekuensi = $modPemeriksaLama->frek_auskultasi;
            $modPemeriksaan->obs_djj = $modPemeriksaLama->denyutjantung_janin;
            $modPemeriksaan->obs_pemeriksaan = $modPemeriksaLama->obs_pemeriksaan;                        
            
            // plasenta
            $modPemeriksaan->plasenta_lahir = $modPemeriksaLama->plasenta_lahir;
            $modPemeriksaan->plasenta_spontanitas = $modPemeriksaLama->plasentaspontanitas;
            $modPemeriksaan->plasenta_kelengkapan = $modPemeriksaLama->plasentakelengkapan;
            $modPemeriksaan->plasenta_berat = $modPemeriksaLama->plasenta_berat;
            $modPemeriksaan->plasenta_diameter = $modPemeriksaLama->plasenta_diameter;
            
            //tali pusar
            $modPemeriksaan->pusar_insersi = $modPemeriksaLama->pusar_insersi;
            $modPemeriksaan->pusar_panjang = $modPemeriksaLama->pusar_panjang;
            $modPemeriksaan->pusar_kelengkapan = $modPemeriksaLama->pusar_kelengkapan;
            $modPemeriksaan->pusar_robekan = $modPemeriksaLama->pusar_robekan;
            $modPemeriksaan->pusar_lainlain = $modPemeriksaLama->pusar_lainlain;
            
            //perlukaan  jalan lahir
            $modPemeriksaan->luka_perineum = $modPemeriksaLama->luka_perineum;
            $modPemeriksaan->luka_vagina = $modPemeriksaLama->luka_vagina;
            $modPemeriksaan->luka_serviks = $modPemeriksaLama->luka_serviks;
            $modPemeriksaan->luka_episiotomi = $modPemeriksaLama->episiotomi;
            $modPemeriksaan->luka_rupturaperinei = $modPemeriksaLama->rupturaperinei;
            
            //pendarahan
            $modPemeriksaan->kala3_darahcc = $modPemeriksaLama->pendarahan;
            
            //nifas            
            $modPemeriksaan->nifas_inveksi = $modPemeriksaLama->nifas_inveksi;
            $modPemeriksaan->nifas_laktasi = $modPemeriksaLama->nifas_laktasi;
            $modPemeriksaan->nifas_febris = $modPemeriksaLama->nifas_febris;
            $modPemeriksaan->nifas_lainlain = $modPemeriksaLama->nifas_lainlain;
        }
    }

?>

<div class='biru' id = 'p0'>
        <div class="white">
            <fieldset class='box'>
                <legend class='rim'>Status Obsterikus</legend>        
                  <table width="100%" class="table-condensed" id='statusObs'>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($modPemeriksaan,'['.$id.']pemeriksaanobstetrik_id') ?>
                            <div class="control-group ">
                                <?php echo Chtml::label('Fundus Uteri', '[]obs_fundusuteri', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_fundusuteri', array('class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?> <div class='additional-text'>cm</div>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_fundusuteri'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo CHtml::label("Letak Janin", 'letak janin', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                        //$modPemeriksaan->obs_posisijanin = $model->posisijanin;
                                      echo $form->dropDownList($modPemeriksaan, '['.$id.']obs_posisijanin', LookupM::getItems('posisijanin'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                      //echo CHtml::dropDownList('posisijanin', 'posisijanin', LookupM::getItems('posisijanin'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'value'=>$model->posisijanin));
                                    ?>                          
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, '[]obs_periksadalam', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPemeriksaan,
                                        'attribute' => '['.$id.']obs_periksadalam',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    // echo $form->textField($modPemeriksaan, 'obs_periksadalam', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_periksadalam'); ?>
                                </div>
                            </div>
                            <!-- Kolom Baru portio_genitalia-->
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'obs_portio', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_portio', array('class'=>'span3 angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_portio'); ?>
                                </div>
                            </div>                    
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'konsistensi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_konsistensigenitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_konsistensigenitalia'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'arah', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_arah', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_arah'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'obs_ketuban', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_ketuban', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_ketuban'); ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'obs_pemeriksa', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $pegawai = new CDbCriteria();
                                    $pegawai->with = array('ruanganpegawai');
                                    $pegawai->addCondition("t.pegawai_aktif = TRUE ");
                                    $pegawai->addCondition("ruanganpegawai.ruangan_id = ".Yii::app()->user->getState('ruangan_id')); 
                                    $pegawai->addCondition('t.kelompokpegawai_id IN ('.Params::KELOMPOKPEGAWAI_ID_BIDAN.','.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.') ');
                                    $pegawai->order = 't.nama_pegawai ASC';

                                    echo $form->dropDownList($modPemeriksaan, '['.$id.']obs_pemeriksa', 
                                            CHtml::listData(PSPegawaiM::model()->findAll($pegawai), 'namaLengkap', 'namaLengkap'),
                                            array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_pemeriksa'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'warna ketuban', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_warnaketuban', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_warnaketuban'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'bagian terendah', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_bagrendah', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_bagrendah'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'hodge', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_hodge', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_hodge'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'posisi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_posisigenital', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_posisigenital'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo CHtml::label('Imbang Fetopelvik', 'obs_fetopelvik', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_fetopelvik', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_fetopelvik'); ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'presentasi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_presentasigenital', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_presentasigenital'); ?>
                                </div>
                            </div>
                            <!--kolom frekuensi Auskultasi -->                    
                            <div class="control-group ">
                                <?php echo CHtml::label('DJJ', '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($modPemeriksaan, '['.$id.']obs_djj', LookupM::getItems('denyutjantung'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_djj'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo Chtml::label("Frekuensi", 'obs_frekuensi', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_frekuensi', array('class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'style'=>'text-align:right;')).' /menit';
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_frekuensi'); ?>
                                </div>
                            </div>
                            <div class="control-group ">
                                <?php echo $form->labelEx($modPemeriksaan, 'pemeriksaan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->textField($modPemeriksaan, '['.$id.']obs_pemeriksaan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                    ?>
                                    <?php echo $form->error($modPemeriksaan, '[]obs_pemeriksaan'); ?>
                                </div>
                            </div>                    
                        </td>
                    </tr>
                </table>

            <div class="row-fluid">
                <div class="span4">
                    <fieldset class='box'>
                        <!--<legend class='rim'>Plasenta</legend>-->                
                        <h5 align="center">Plasenta</h5>
                        <hr/>
                        <table width="100%" class="table-condensed" id='plasenta'>
                            <tr>
                                <td>
                                <div class="control-group ">
                                    <?php 
                                    // $modPemeriksaan->plasenta_lahir = null;
                                    echo $form->labelEx($modPemeriksaan, 'lahir', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPemeriksaan,
                                            'attribute' => '['.$id.']plasenta_lahir',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                            ),
                                        ));
                                        ?>
                                        <?php echo $form->error($modPemeriksaan, '[]plasenta_lahir'); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_spontanitas', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->dropDownList($modPemeriksaan, '['.$id.']plasenta_spontanitas', LookupM::getItems('plasenta_spontanitas'), array('empty'=>'-- Pilih --','class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                        ?>
                                        <?php echo $form->error($modPemeriksaan, '[]plasenta_spontanitas'); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_kelengkapan', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->dropDownList($modPemeriksaan, '['.$id.']plasenta_kelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty'=>'-- Pilih --','class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                        ?>
                                        <?php echo $form->error($modPemeriksaan, '[]plasenta_kelengkapan'); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_berat', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->textField($modPemeriksaan, '['.$id.']plasenta_berat', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                        ?> <div class='additional-text'>gram</div>
                                        <?php echo $form->error($modPemeriksaan, '[]plasenta_berat'); ?>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_diameter', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        echo $form->textField($modPemeriksaan, '['.$id.']plasenta_diameter', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                        ?> <div class='additional-text'>cm</div>
                                        <?php echo $form->error($modPemeriksaan, '[]plasenta_diameter'); ?>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <div class="span4">
                    <fieldset class='box'>
                        <!--<legend class='rim'>Tali Pusat</legend>-->
                        <h5 align="center">Tali Pusar</h5>
                        <hr/>
                        <table width="100%" class="table-condensed" id='taliPusar'>
                            <tr>
                                <td>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]pusar_insersi', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']pusar_insersi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]pusar_insersi'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]pusar_panjang', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']pusar_panjang', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?> <div class='additional-text'>cm</div>
                                            <?php echo $form->error($modPemeriksaan, '[]pusar_panjang'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]pusar_kelengkapan', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->dropDownList($modPemeriksaan, '['.$id.']pusar_kelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty'=>'-- Pilih --','class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]pusar_kelengkapan'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]pusar_robekan', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']pusar_robekan', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]pusar_robekan'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]pusar_lainlain', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']pusar_lainlain', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]pusar_lainlain'); ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <div class="span4">
                    <fieldset class='box'>
                        <!--<legend class='rim'>Perlukaan Jalan Lahir</legend>-->
                        <h5 align="center">Perlukaan Jalan Lahir</h5>
                        <hr/>
                        <table width="100%" class="table-condensed" id='perlukaan'>
                            <tr>
                                <td>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]luka_perineum', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']luka_perineum', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]luka_perineum'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]luka_vagina', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']luka_vagina', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]luka_vagina'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]luka_serviks', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']luka_serviks', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, 'luka_serviks'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]luka_episiotomi', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->dropDownList($modPemeriksaan, '['.$id.']luka_episiotomi', LookupM::getItems('episiotomi'), array('empty'=>'-- Pilih --','class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]luka_episiotomi'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]luka_rupturaperinei', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->dropDownList($modPemeriksaan, '['.$id.']luka_rupturaperinei', LookupM::getItems('rupturaperinei'), array('empty'=>'-- Pilih --','class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]luka_rupturaperinei'); ?>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                        </table>
                    </fieldset>            
                </div>
            </div>   

            <div class="row-fluid">
                <div class="span4">
                    <fieldset class='box'>
                        <!--<legend class='rim'>Pendarahan</legend>-->
                        <h5 align="center">Pendarahan</h5>
                        <hr/>
                        <table width="100%" class="table-condensed" id='pendarahan'>
                            <tr>
                                <td>                                
                                    <div class="control-group ">
                                        <?php echo CHtml::label('Kala III', '', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']kala3_darahcc', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).' cc';
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]kala3_darahcc'); ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </div>  
                <div class="span4">
                    <fieldset class='box'>
                        <!--<legend class='rim'>Nifas</legend>-->
                        <h5 align="center">Nifas</h5>
                        <hr/>
                         <table width="100%" class="table-condensed" id='nifas'>
                            <tr>
                                <td>         
                                    <div class="control-group ">
                                        <?php echo Chtml::label("Infeksi", '[]nifas_inveksi', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']nifas_inveksi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]nifas_inveksi'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]nifas_laktasi', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']nifas_laktasi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]nifas_laktasi'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]nifas_febris', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']nifas_febris', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]nifas_febris'); ?>
                                        </div>
                                    </div>
                                    <div class="control-group ">
                                        <?php echo $form->labelEx($modPemeriksaan, '[]nifas_lainlain', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php
                                            echo $form->textField($modPemeriksaan, '['.$id.']nifas_lainlain', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                                            ?>
                                            <?php echo $form->error($modPemeriksaan, '[]nifas_lainlain'); ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                         </table>
                    </fieldset>
                </div>
            </div>
                 </fieldset>
            <div class="row-fluid">
                <div class="span12">
                    <fieldset class='box'>
                        <legend class='rim'>Pemeriksaan Kala IV</legend>

						<div class="block-tabel">
							<h6>Pemantauan Persalinan Kala IV</h6>
							<table class="table table-striped table-condensed" id="periksaKala4">
								<thead>
								<tr>
									<th>Tanggal/ <br/>Waktu</th>        
									<th>Anemia</th>        
									<th>Tekanan Darah</th>        
									<th>Denyut Nadi/ <br/> Pernapasan</th>
									<th>Tinggi Fundus</th>
									<th>Kontraksi Uterus</th>
									<th>Kandung Kemih</th>
									<th>Pendarahan</th>
									<th>&nbsp;</th>
								</tr>
								</thead>
								<tbody>
									<?php                                     
										$this->renderPartial('_pemeriksaanKala4', array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan, 'id'=>$id)); 
									?>
								</tbody>
							</table>
						</div>
						<?php 
						if (!empty($modPemeriksaan)) {
							echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemeriksaanPersalinan(".$modPemeriksaan->pemeriksaanobstetrik_id.");return false",  ));
						}
						?>
						
						
					</fieldset>	
                </div>
            </div>
            </div>
        </div>

