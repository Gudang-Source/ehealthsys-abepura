<fieldset id="panel-obs" hidden>
    <fieldset class='box'>
        <legend class='rim'>Status Obsterikus</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'fundus ufen', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_fundusufen', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>cm</div>
                            <?php echo $form->error($modPemeriksaan, 'obs_fundusufen'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'letak janin', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'posisijanin', LookupM::getItems('posisijanin'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($model, 'posisijanin'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'memeriksaan dalam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPemeriksaan,
                                'attribute' => 'obs_periksadalam',
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
                            <?php echo $form->error($modPemeriksaan, 'obs_periksadalam'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'konsistensi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_konsistensigenitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_konsistensigenitalia'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'arah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_arah', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_arah'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'ketuban', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'ketuban_genitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'ketuban_genitalia'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'pemeriksa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_pemeriksa', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_pemeriksa'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'warna ketuban', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_warnaketuban', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_warnaketuban'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'bagian terendah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'penurunan_genitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'penurunan_genitalia'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'hodge', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_hodge', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_hodge'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'posisi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'posisi_genitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'posisi_genitalia'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'presentasi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'presentasi_genitalia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'presentasi_genitalia'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('DJJ', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'denyutjantung_janin', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'denyutjantung_janin'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'pemeriksaan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_pemeriksaan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_pemeriksaan'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemeriksaan, 'imbang fetofelvik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($modPemeriksaan, 'obs_fetofelvik', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?>
                            <?php echo $form->error($modPemeriksaan, 'obs_fetofelvik'); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <div class="row-fluid">
        <div class="span4">
            <fieldset class='box'>
                <legend class='rim'>Plasenta</legend>
                <div class="control-group ">
                    <?php 
                    // $modPemeriksaan->plasenta_lahir = null;
                    echo $form->labelEx($modPemeriksaan, 'lahir', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPemeriksaan,
                            'attribute' => 'plasenta_lahir',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'tglabortus'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'spontanitas', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'plasentaspontanitas', LookupM::getItems('plasenta_spontanitas'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'plasentaspontanitas'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'kelengkapan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'plasentakelengkapan', LookupM::getItems('plasenta_kelengkapan'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'plasentakelengkapan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'berat', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'plasenta_berat', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>gram</div>
                        <?php echo $form->error($modPemeriksaan, 'plasenta_berat'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'diameter', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'plasenta_diameter', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div>
                        <?php echo $form->error($modPemeriksaan, 'plasenta_diameter'); ?>
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="span4">
            <fieldset class='box'>
                <legend class='rim'>Tali Pusat</legend>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'insersi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_insersi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_insersi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'panjang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_panjang', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div>
                        <?php echo $form->error($modPemeriksaan, 'pusar_panjang'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'kelengkapan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'pusar_kelengkapan', LookupM::getItems('pusar_kelengkapan'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_kelengkapan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'robekan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_robekan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_robekan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'lain-lain', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pusar_lainlain', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pusar_lainlain'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset class='box'>
                <legend class='rim'>Perlukaan Jalan Lahir</legend>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'luka_perineum', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'luka_perineum', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'luka_perineum'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'luka_vagina', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'luka_vagina', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'luka_vagina'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'luka_serviks', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'luka_serviks', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'luka_serviks'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'episiotomi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'episiotomi', LookupM::getItems('episiotomi'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'episiotomi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'ruptura perinei', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($modPemeriksaan, 'rupturaperinei', LookupM::getItems('rupturaperinei'), array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'rupturaperinei'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <fieldset class='box'>
                <legend class='rim'>Kala IV</legend>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'anemia', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'kala4_anemia', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'kala4_anemia'); ?>
                    </div>
                </div>


                <div class="control-group ">
                        <?php echo $form->LabelEx($modPemeriksaan,'tekanan darah',array('class'=>'control-label'));?>
                        <div class="controls">
                         <?php 
                         echo $form->textField($modPemeriksaan,'kala4_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'setTekanan(this);', 'style'=>'text-align: right;')); ?>Mm
                         <?php 
                         echo $form->textField($modPemeriksaan,'kala4_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'setTekanan(this);', 'style'=>'text-align: right;')); ?>Hg
                                                    &nbsp;
                        </div>
                </div>
                <div class="control-group ">
                        <?php echo CHtml::Label('','',array('class'=>'control-label'));?>
                        <div class="controls">
                                <?php
                                        $modPemeriksaan->kala4_tekanandarah = empty($modPemeriksaan->kala4_tekanandarah) ? "000 / 000" : $modPemeriksaan->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $modPemeriksaan,
                                        'attribute' => 'kala4_tekanandarah',
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
                        <?php echo $form->LabelEx($modPemeriksaan,'mean arteri pressure',array('class'=>'control-label'));?>
                        <div class="controls">
                                 <?php echo $form->textField($modPemeriksaan,'kala4_meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                        </div>
                </div>


                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'detak nadi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'></div>
                        <?php echo $form->error($modPemeriksaan, 'kala4_detaknadi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'pernapasan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'kala4_pernapasan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'kala4_pernapasan'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'tinggi fundus uteri', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'tinggifundus_uteri', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div>
                        <?php echo $form->error($modPemeriksaan, 'tinggifundus_uteri'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'kontraksi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'kala4_kontraksi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'kala4_kontraksi'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset class='box'>
                <legend class='rim'>Pendarahan</legend>
                <div class="control-group ">
                    <?php echo CHtml::label('Kala III + IV', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'pendarahan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'pendarahan'); ?>
                    </div>
                </div>
            </fieldset>
        </div>  
        <div class="span4">
            <fieldset class='box'>
                <legend class='rim'>Nifas</legend>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'inveksi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'nifas_inveksi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'nifas_inveksi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'laktasi', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'nifas_laktasi', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'nifas_laktasi'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'febris puerperalis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'nifas_febris', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'nifas_febris'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modPemeriksaan, 'lain-lain', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPemeriksaan, 'nifas_lainlain', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                        <?php echo $form->error($modPemeriksaan, 'nifas_lainlain'); ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</fieldset>