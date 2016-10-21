<fieldset class='box' id="panel-persalinan">
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData($model->DokterItems, 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan_id',  CHtml::listData($model->BidanItems, 'pegawai.pegawai_id', 'pegawai.nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan2_id',  CHtml::listData($model->BidanItems, 'pegawai.pegawai_id', 'pegawai.nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan3_id',  CHtml::listData($model->BidanItems, 'pegawai.pegawai_id', 'pegawai.nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'paramedis_id',  CHtml::listData($model->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model, 'catatan_dokter', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    
                    <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    
                    
                    <?php //echo $form->textFieldRow($model,'tglmulaipersalinan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglmulaipersalinan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmulaipersalinan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    //'onkeypress' => "js:function(){getUmur(this);}",
                                    //'onSelect' => 'js:function(){$(this).close();}',
                                    //'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglmulaipersalinan'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglselesaipersalinan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglselesaipersalinan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglselesaipersalinan'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'lamapersalinan_jam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'lamapersalinan_jam', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Jam</div>
                            <?php echo $form->error($model, 'lamapersalinan_jam'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->Label($model, 'tglmelahirkan', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglmelahirkan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'islahirdirs', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'islahirdirs', array('value'=>1, 'uncheckValue'=>null)); ?> Ya &emsp;
                            <?php echo $form->radioButton($model, 'islahirdirs', array('value'=>0, 'uncheckValue'=>null)); ?> Tidak
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'keadaanlahir',LookupM::getItems('keadaanlahir'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange'=> 'setKematian();', 'maxlength' => 100)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'masagestasi_minggu', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'masagestasi_minggu', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Minggu</div><br/>
                            <?php echo $form->error($model, 'masagestasi_minggu'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'paritaske', LookupM::getItemsUrutan('paritas'), array('empty'=> '-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'jmlkelahiranhidup', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'jmlkelahiranhidup', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Orang</div>
                            <?php echo $form->error($model, 'jmlkelahiranhidup'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'jmlkelahiranmati', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'jmlkelahiranmati', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Orang</div>
                            <?php echo $form->error($model, 'jmlkelahiranmati'); ?>
                        </div>
                    </div>
                    
                    
                    <?php //echo $form->textFieldRow($model, 'tglmelahirkan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                    <?php //echo $form->textFieldRow($model, 'masagestasi_minggu', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model, 'jeniskegiatanpersalinan', LookupM::model()->getItems('jeniskegiatanpersalinan'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'kegiatanpersalinan_id', CHtml::listData(PSKegiatanpersalinanM::model()->findAll("kegiatanpersalinan_aktif ORDER BY kegiatanpersalinan_nama ASC"), 'kegiatanpersalinan_id', 'kegiatanpersalinan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'carapersalinan', LookupM::getItems('carapersalinan'), array('empty'=>'-- Pilih --','class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'posisijanin', LookupM::getItems('posisijanin'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'kelsebababortus_id', CHtml::listData(PSKelsebababortusM::model()->findAll("kelsebababortus_aktif = TRUE ORDER BY kelsebababortus_nama ASC"), 'kelsebababortus_id', 'kelsebababortus_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'sebababortus_id', CHtml::listData(PSSebababortusM::model()->findAll("sebababortus_aktif = TRUE ORDER BY sebababortus_nama ASC"), 'sebababortus_id', 'sebababortus_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'sebabkematian', LookupM::getItems('sebabkematian'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <div class="control-group ">
                        <?php 
                        $model->tglabortus = null;
                        echo $form->labelEx($model, 'tglabortus', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglabortus',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglabortus'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'jmlabortus', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    
                </td>
            </tr>
        </table>
    </fieldset>