
    <?php
        
        
        $i = 0;
        if (!empty($modPemeriksaan->pemeriksaanobstetrik_id)){            
            $modPeriksaKala4 = PSPemeriksaankala4T::model()->findAll(" pemeriksaanobstetrik_id = '".$modPemeriksaan->pemeriksaanobstetrik_id."' ORDER BY kala4_tanggal ASC, kala4_waktu ASC");
            
            if (count($modPeriksaKala4)>0){
            
            foreach($modPeriksaKala4 as $data){
                $data->kala4_tanggal = MyFormatter::formatDateTimeForUser($data->kala4_tanggal).' '.$data->kala4_waktu;
    ?>          
                <tr>
                    <td>
                        <?php
                        echo $form->hiddenField($data,'[0]['.$i.']$counter', array('value' => 1));
                        echo $form->hiddenField($data,'[0]['.$i.']pemeriksaankala4_id');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $data,
                            'attribute' => '[0]['.$i.']kala4_tanggal',
                            'mode' => 'datetime',
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
                        <?php echo $form->textField($data, '[0]['.$i.']kala4_anemia', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).'<br/>'; ?>
                    </td>
                    <td>
                        <?php 
                        
                       
                        
                        
                        echo $form->textField($data, '[0]['.$i.']kala4_systolic', array('class'=>'span1 numbers-only systolic', 'onkeyup'=>'setTekanan(this);', )).' Mm '.$form->textField($data, '[0]['.$i.']kala4_diastolic', array('class'=>'span1 numbers-only diastolic', 'onkeyup'=>'setTekanan(this);', )).' Hg';?>
                        <br/>
                                <?php
                                        $data->kala4_tekanandarah = empty($data->kala4_tekanandarah) ? "000 / 000" : $data->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $data,
                                        'attribute' => '[0]['.$i.']kala4_tekanandarah',
                                        'mask' => '999 / 999',
                                        'placeholder'=>'000 / 000',
                                        'htmlOptions' => array('readonly'=>true, 'class'=>'span2 td','onkeypress'=>"return $(this).focusNextInputField(event)",) //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                        ));
                                ?> Mm/Hg
                        
                        <br/>
                        <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>                    
                        
                        <?php echo $form->textField($data,'[0]['.$i.']kala4_meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                </div>
                    </td>
                    
                    <td>
                        <?php
                            echo $form->textField($data, '[0]['.$i.']kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                        <br/>
                        <?php
                            echo $form->textField($data, '[0]['.$i.']kala4_pernapasan', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                    </td>
                    <td> <?php
                        echo $form->textField($data, '[0]['.$i.']kala4_tinggifundus', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div></td>
                    <td>
                         <?php
                        echo $form->textField($data, '[0]['.$i.']kala4_kontraksi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($data, '[0]['.$i.']kala4_kandungkemih', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($data, '[0]['.$i.']kala4_darahcc', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).' cc';
                        ?>
                    </td>
                    <td>
                         <?php 
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                    array('onclick' => 'inputKala4(this);',
                                        'class' => 'btn btn-primary',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => "tooltip",
                                        'title' => "Klik untuk menambahkan pemeriksaan kala 4",));
                            ?>    
                    </td>
                </tr>
    <?php       $i++;
            }
            }else{
                $modPeriksaKala4 = new PSPemeriksaankala4T;
                $modPeriksaKala4->kala4_tanggal = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));                
    ?>
                 <tr>
                    <td>
                        <?php
                        $form->hiddenField($modPeriksaKala4,'[0]['.$i.']pemeriksaankala4_id');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPeriksaKala4,
                            'attribute' => '[0]['.$i.']kala4_tanggal',
                            'mode' => 'datetime',
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
                        <?php echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_anemia', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).'<br/>'; ?>
                    </td>
                    <td>
                        <?php 
                                                
                        
                        
                        echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_systolic', array('class'=>'span1 numbers-only systolic', 'onkeyup'=>'setTekanan(this);', )).' Mm '.$form->textField($modPeriksaKala4, '[0]['.$i.']kala4_diastolic', array('class'=>'span1 numbers-only diastolic', 'onkeyup'=>'setTekanan(this);', )).' Hg';?>
                        <br/>
                                <?php
                                        $modPeriksaKala4->kala4_tekanandarah = empty($modPeriksaKala4->kala4_tekanandarah) ? "000 / 000" : $modPemeriksaan->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $modPeriksaKala4,
                                        'attribute' => '[0]['.$i.']kala4_tekanandarah',
                                        'mask' => '999 / 999',
                                        'placeholder'=>'000 / 000',
                                        'htmlOptions' => array('readonly'=>true, 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                        ));
                                ?> Mm/Hg
                        
                        <br/>
                        <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2 td', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>                    
                        <?php echo $form->textField($modPeriksaKala4,'[0]['.$i.']kala4_meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
            
                    </td>                                                             
                    <td>
                        <?php
                            echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                        <br/>
                        <?php
                            echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_pernapasan', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                    </td>
                    <td> <?php
                        echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_tinggifundus', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div></td>
                    <td>
                         <?php
                        echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_kontraksi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_kandungkemih', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($modPeriksaKala4, '[0]['.$i.']kala4_darahcc', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).' cc';
                        ?>
                    </td>
                    <td>
                         <?php 
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                    array('onclick' => 'inputKala4(this);',
                                        'class' => 'btn btn-primary',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => "tooltip",
                                        'title' => "Klik untuk menambahkan pemeriksaan kala 4",));
                            ?>    
                    </td>
                </tr>
                
                <?php
            }
        
        }
    ?>
  



