<h6>Pemantauan Persalinan Kala IV</h6>
<table class="table table-striped table-condensed" id="periksaKala4">
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Tekanan Darah</th>
        <th>Denyut Nadi/ <br/> Pernapasan</th>
        <th>Tinggi Fundus</th>
        <th>Kontraksi Uterus</th>
        <th>Kandung Kemih</th>
        <th>Pendarahan</th>
        <th>&nbsp;</th>
    </tr>
    <?php
        
        
        $i = 0;
        if (!empty($modPemeriksaan->pemeriksaanobstetrik_id)){            
            $modPeriksaKala4 = PSPemeriksaankala4T::model()->findAll(" pemeriksaanobstetrik_id = '".$modPemeriksaan->pemeriksaanobstetrik_id."' ");
            
            if (count($modPeriksaKala4)>0){
            foreach($modPeriksaKala4 as $data){
    ?>          
                <tr>
                    <td></td>
                    <td>Waktu</td>
                    <td>Tekanan Darah</td>
                    <td>Denyut Nadi</td>
                    <td>Tinggi Fundus</td>
                    <td>Kontraksi Uterus</td>
                    <td>Kandung Kemih</td>
                    <td>Pendarahan</td>
                    
                </tr>
    <?php       $i++;
            }
            }
        
        }
    ?>
                <tr>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPeriksaKala4,
                            'attribute' => '['.$i.']kala4_tanggal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>                                
                          
                    </td>
                    <td>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPeriksaKala4,
                            'attribute' => '['.$i.']kala4_waktu',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>                                                                             
                    </td>
                    <td>
                        <?php 
                        
                        echo 'Anemia '.$form->textField($modPeriksaKala4, '['.$i.']kala4_anemia', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).'<br/>';
                        
                        
                        echo $form->textField($modPeriksaKala4, '['.$i.']kala4_systolic', array('class'=>'span1 numbers-only systolic', 'onkeyup'=>'setTekanan(this);', )).' Mm '.$form->textField($modPeriksaKala4, '['.$i.']kala4_diastolic', array('class'=>'span1 numbers-only diastolic', 'onkeyup'=>'setTekanan(this);', )).' Hg';?>
                        <br/>
                                <?php
                                        $modPeriksaKala4->kala4_tekanandarah = empty($modPeriksaKala4->kala4_tekanandarah) ? "000 / 000" : $modPemeriksaan->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $modPeriksaKala4,
                                        'attribute' => '['.$i.']kala4_tekanandarah',
                                        'mask' => '999 / 999',
                                        'placeholder'=>'000 / 000',
                                        'htmlOptions' => array('readonly'=>true, 'class'=>'span2 td', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                        ));
                                ?> Mm/Hg
                        
                        <br/>
                        <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>                    
                </div>
                    </td>
                    <td>
                        <?php
                            echo $form->textField($modPeriksaKala4, '['.$i.']kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                        <br/>
                        <?php
                            echo $form->textField($modPeriksaKala4, '['.$i.']kala4_pernapasan', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                    </td>
                    <td> <?php
                        echo $form->textField($modPeriksaKala4, '['.$i.']kala4_tinggifundus', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div></td>
                    <td>
                         <?php
                        echo $form->textField($modPeriksaKala4, '['.$i.']kala4_kontraksi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($modPeriksaKala4, '['.$i.']kala4_kandungkemih', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($modPeriksaKala4, '['.$i.']kala4_darahcc', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                         <?php 
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                    array('onclick' => 'inpitKala4();',
                                        'class' => 'btn btn-primary',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => "tooltip",
                                        'title' => "Klik untuk menambahkan pemeriksaan kala 4",));
                            ?>    
                    </td>
                </tr>
    </thead>
</table>
