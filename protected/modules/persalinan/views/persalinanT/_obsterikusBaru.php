<fieldset id="panel-obs" hidden>
    <fieldset class='box'>
        <legend class='rim'>Status Obsterikus</legend>        
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo Chtml::label('Fundus Uteri', '[]obs_fundusuteri', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_fundusuteri', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>cm</div>
                            <?php echo $form->error($modPemeriksaan, '[]obs_fundusuteri'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label("Letak Janin", 'letak janin', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                $modPemeriksaan->obs_posisijanin = $model->posisijanin;
                              echo $form->dropDownList($modPemeriksaan, '[]obs_posisijanin', LookupM::getItems('posisijanin'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
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
                                'attribute' => '[]obs_periksadalam',
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
                            echo $form->textField($modPemeriksaan, '[]obs_portio', array('class'=>'span3 angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_portio'); ?>
                        </div>
                    </div>                    
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'konsistensi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_konsistensigenitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_konsistensigenitalia'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'arah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_arah', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_arah'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'obs_ketuban', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_ketuban', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
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
                            
                            echo $form->dropDownList($modPemeriksaan, '[]obs_pemeriksa', 
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
                            echo $form->textField($modPemeriksaan, '[]obs_warnaketuban', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_warnaketuban'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'bagian terendah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_bagrendah', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_bagrendah'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'hodge', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_hodge', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_hodge'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'posisi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_posisigenital', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_posisigenital'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Imbang Fetopelvik', 'obs_fetopelvik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_fetopelvik', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
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
                            echo $form->textField($modPemeriksaan, '[]obs_presentasigenital', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_presentasigenital'); ?>
                        </div>
                    </div>
                    <!--kolom frekuensi Auskultasi -->                    
                    <div class="control-group ">
                        <?php echo CHtml::label('DJJ', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPemeriksaan, 'obs_djj', LookupM::getItems('denyutjantung'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_djj'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo Chtml::label("Frekuensi", 'obs_frekuensi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_frekuensi', array('class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'style'=>'text-align:right;')).' /menit';
                            ?>
                            <?php echo $form->error($modPemeriksaan, '[]obs_frekuensi'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'pemeriksaan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, '[]obs_pemeriksaan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
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
                <div class="control-group ">
                    <?php 
                    // $modPemeriksaan->plasenta_lahir = null;
                    echo $form->labelEx($modPemeriksaan, 'lahir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaan,
                            'attribute' => '[]plasenta_lahir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                        echo $form->dropDownList($modPemeriksaan, '[]plasenta_spontanitas', LookupM::getItems('plasenta_spontanitas'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]plasenta_spontanitas'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_kelengkapan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, '[]plasenta_kelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]plasenta_kelengkapan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_berat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]plasenta_berat', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>gram</div>
                        <?php echo $form->error($modPemeriksaan, '[]plasenta_berat'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]plasenta_diameter', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]plasenta_diameter', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div>
                        <?php echo $form->error($modPemeriksaan, '[]plasenta_diameter'); ?>
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="span4">
            <fieldset class='box'>
                <!--<legend class='rim'>Tali Pusat</legend>-->
                <h5 align="center">Tali Pusar</h5>
                <hr/>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]pusar_insersi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]pusar_insersi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]pusar_insersi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]pusar_panjang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]pusar_panjang', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div>
                        <?php echo $form->error($modPemeriksaan, '[]pusar_panjang'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]pusar_kelengkapan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, '[]pusar_kelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]pusar_kelengkapan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]pusar_robekan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]pusar_robekan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]pusar_robekan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]pusar_lainlain', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]pusar_lainlain', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]pusar_lainlain'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset class='box'>
                <!--<legend class='rim'>Perlukaan Jalan Lahir</legend>-->
                <h5 align="center">Perlukaan Jalan Lahir</h5>
                <hr/>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]luka_perineum', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]luka_perineum', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]luka_perineum'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]luka_vagina', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]luka_vagina', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]luka_vagina'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]luka_serviks', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]luka_serviks', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'luka_serviks'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]luka_episiotomi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, '[]luka_episiotomi', LookupM::getItems('episiotomi'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]luka_episiotomi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]luka_rupturaperinei', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, '[]luka_rupturaperinei', LookupM::getItems('rupturaperinei'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]luka_rupturaperinei'); ?>
                    </div>
                </div>
            </fieldset>            
        </div>
    </div>   
    
    <div class="row-fluid">
        <div class="span4">
            <fieldset class='box'>
                <!--<legend class='rim'>Pendarahan</legend>-->
                <h5 align="center">Pendarahan</h5>
                <hr/>
                <div class="control-group ">
                    <?php echo CHtml::label('Kala III', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]kala3_darahcc', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]kala3_darahcc'); ?>
                    </div>
                </div>
            </fieldset>
        </div>  
        <div class="span4">
            <fieldset class='box'>
                <!--<legend class='rim'>Nifas</legend>-->
                <h5 align="center">Nifas</h5>
                <hr/>
                <div class="control-group ">
                    <?php echo Chtml::label("Infeksi", '[]nifas_inveksi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]nifas_inveksi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]nifas_inveksi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]nifas_laktasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]nifas_laktasi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]nifas_laktasi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]nifas_febris', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]nifas_febris', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]nifas_febris'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, '[]nifas_lainlain', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, '[]nifas_lainlain', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, '[]nifas_lainlain'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
         </fieldset>
    <div class="row-fluid">
        <div class="span12">
            <fieldset class='box'>
                <legend class='rim'>Pemeriksaan Kala IV</legend>
                
                <?php /*
                <table width="100%">
                    <tr>
                        <td>
                            <!--kolom 1-->
                        </td>
                        <td>
                            <!--kolom 2-->
                        </td>
                        <td>
                            <!--kolom 3-->
                        </td>
                    </tr>
                </table>
                 <div class="control-group ">
                    <?php 
                    // $modPemeriksaan->plasenta_lahir = null;
                    echo $form->labelEx($modPemeriksaan, 'lahir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPeriksaKala4,
                            'attribute' => '[]kala4_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_tanggal'); ?>
                    </div>
                </div>
                
                <div class="control-group ">
                    <?php echo $form->labelEx($modPeriksaKala4, '[]kala4_darahcc', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_darahcc', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).' cc';
                        ?>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_darahcc'); ?>
                    </div>
                </div>
                
                <div class="control-group ">
                    <?php echo $form->labelEx($modPeriksaKala4, '[]kala4_anemia', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_anemia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_anemia'); ?>
                    </div>
                </div>


                <div class="control-group ">
                        <?php echo $form->LabelEx($modPeriksaKala4,'[]kala4_systolic',array('class'=>'control-label'));?>
                        <div class="controls">
                         <?php 
                         echo $form->textField($modPeriksaKala4,'[]kala4_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'setTekanan(this);', 'style'=>'text-align: right;')); ?>Mm
                         <?php 
                         echo $form->textField($modPeriksaKala4,'[]kala4_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'setTekanan(this);', 'style'=>'text-align: right;')); ?>Hg
                                                    &nbsp;
                        </div>
                </div>
                <div class="control-group ">
                        <?php echo CHtml::Label('','',array('class'=>'control-label'));?>
                        <div class="controls">
                                <?php
                                        $modPeriksaKala4->kala4_tekanandarah = empty($modPeriksaKala4->kala4_tekanandarah) ? "000 / 000" : $modPemeriksaan->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $modPeriksaKala4,
                                        'attribute' => '[]kala4_tekanandarah',
                                        'mask' => '999 / 999',
                                        'placeholder'=>'000 / 000',
                                        'htmlOptions' => array('readonly'=>true, 'class'=>'span2 td', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                        ));
                                ?> Mm/Hg
                        </div>
                </div>
                <div class="control-group ">
                    <div class="controls">
                        <?php echo CHtml::label('','',array('class'=>'control-label'));?>
                        <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
                <div class="control-group ">
                        <?php echo $form->LabelEx($modPeriksaKala4,'[]kala4_meanarteripressure',array('class'=>'control-label'));?>
                        <div class="controls">
                                 <?php echo $form->textField($modPeriksaKala4,'[]kala4_meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                        </div>
                </div>


                <div class="control-group ">
                    <?php echo Chtml::label("Denyut Nadi", 'kala4_detaknadi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_detaknadi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPeriksaKala4, '[]kala4_pernapasan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_pernapasan', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?><div class='additional-text'>/ Menit</div>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_pernapasan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPeriksaKala4, '[]kala4_tinggifundus', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_tinggifundus', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_tinggifundus'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPeriksaKala4, '[]kala4_kontraksi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_kontraksi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_kontraksi'); ?>
                    </div>
                </div>
                
                <div class="control-group ">
                    <?php echo $form->labelEx($modPeriksaKala4, '[]kala4_kandungkemih', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPeriksaKala4, '[]kala4_kandungkemih', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPeriksaKala4, '[]kala4_kandungkemih'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        
        */ ?>
        
        <div class ="span12">
            <div class="block-tabel">
                <?php $this->renderPartial('_pemeriksaanKala4', array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan)); ?>
            </div>
        </div>
    </div>
</fieldset>