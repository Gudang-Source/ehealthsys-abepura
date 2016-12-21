
    <?php
        
        
        $i = 0;
        if (!empty($modPemeriksaan->pemeriksaanobstetrik_id)){                  
            $modPeriksaKala4 = PSPemeriksaankala4T::model()->findAll(" pemeriksaanobstetrik_id = '".$modPemeriksaan->pemeriksaanobstetrik_id."' ORDER BY pemeriksaankala4_id ASC");
            
            if (count($modPeriksaKala4)>0){
            //var_dump($modPemeriksaan->pemeriksaanobstetrik_id);
            foreach($modPeriksaKala4 as $data){
                $data->kala4_tanggal = MyFormatter::formatDateTimeForUser($data->kala4_tanggal).' '.$data->kala4_waktu;
    ?>          
                <tr>
                    <td>
                        <?php                        
                        echo $form->hiddenField($data,'['.$id.']['.$i.']pemeriksaankala4_id');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $data,
                            'attribute' => '['.$id.']['.$i.']kala4_tanggal',
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
                        <?php echo $form->textField($data, '['.$id.']['.$i.']kala4_anemia', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).'<br/>'; ?>
                    </td>
                    <td>
                        <?php 
                        
                       
                        
                        
                        echo $form->textField($data, '['.$id.']['.$i.']kala4_systolic', array('class'=>'span1 numbers-only systolic', 'onkeyup'=>'setTekanan(this);', )).' Mm '.$form->textField($data, '['.$id.']['.$i.']kala4_diastolic', array('class'=>'span1 numbers-only diastolic', 'onkeyup'=>'setTekanan(this);', )).' Hg';?>
                        <br/>
                                <?php
                                        $data->kala4_tekanandarah = empty($data->kala4_tekanandarah) ? "000 / 000" : $data->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $data,
                                        'attribute' => '['.$id.']['.$i.']kala4_tekanandarah',
                                        'mask' => '999 / 999',
                                        'placeholder'=>'000 / 000',
                                        'htmlOptions' => array('readonly'=>true, 'class'=>'span2 td','onkeypress'=>"return $(this).focusNextInputField(event)",) //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                        ));
                                ?> Mm/Hg
                        
                        <br/>
                        <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>                    
                        
                        <?php echo $form->textField($data,'['.$id.']['.$i.']kala4_meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
                </div>
                    </td>
                    
                    <td>
                        <?php
                            echo $form->textField($data, '['.$id.']['.$i.']kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                        <br/>
                        <?php
                            echo $form->textField($data, '['.$id.']['.$i.']kala4_pernapasan', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                    </td>
                    <td> <?php
                        echo $form->textField($data, '['.$id.']['.$i.']kala4_tinggifundus', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div></td>
                    <td>
                         <?php
                        echo $form->textField($data, '['.$id.']['.$i.']kala4_kontraksi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($data, '['.$id.']['.$i.']kala4_kandungkemih', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($data, '['.$id.']['.$i.']kala4_darahcc', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).' cc';
                        ?>
                    </td>
                    <td>
                         <?php 
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                    array('onclick' => 'inputKala4(this,'.$id.');',
                                        'class' => 'btn btn-primary',                                        
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => "tooltip",
                                        'id' => 'tambahKala4',
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
                        echo $form->hiddenField($modPeriksaKala4,'['.$id.']['.$i.']pemeriksaankala4_id');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPeriksaKala4,
                            'attribute' => '['.$id.']['.$i.']kala4_tanggal',
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
                        <?php echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_anemia', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).'<br/>'; ?>
                    </td>
                    <td>
                        <?php 
                                                
                        
                        
                        echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_systolic', array('class'=>'span1 numbers-only systolic', 'onkeyup'=>'setTekanan(this);', )).' Mm '.$form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_diastolic', array('class'=>'span1 numbers-only diastolic', 'onkeyup'=>'setTekanan(this);', )).' Hg';?>
                        <br/>
                                <?php
                                        $modPeriksaKala4->kala4_tekanandarah = empty($modPeriksaKala4->kala4_tekanandarah) ? "000 / 000" : $modPemeriksaan->kala4_tekanandarah;
                                        $this->widget('CMaskedTextField', array(
                                        'model' => $modPeriksaKala4,
                                        'attribute' => '['.$id.']['.$i.']kala4_tekanandarah',
                                        'mask' => '999 / 999',
                                        'placeholder'=>'000 / 000',
                                        'htmlOptions' => array('readonly'=>true, 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
                                        ));
                                ?> Mm/Hg
                        
                        <br/>
                        <?php echo CHtml::textField('tekananDarah','', array('class'=>'span2 td', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);"));?>                    
                        <?php echo $form->textField($modPeriksaKala4,'['.$id.']['.$i.']kala4_meanarteripressure',array('readonly'=>true, 'class'=>'span2 integer numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10));?>
            
                    </td>                                                             
                    <td>
                        <?php
                            echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_detaknadi', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                        <br/>
                        <?php
                            echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_pernapasan', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>/ Menit</div>
                    </td>
                    <td> <?php
                        echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_tinggifundus', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?> <div class='additional-text'>cm</div></td>
                    <td>
                         <?php
                        echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_kontraksi', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_kandungkemih', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $form->textField($modPeriksaKala4, '['.$id.']['.$i.']kala4_darahcc', array('class'=>'span2','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)).' cc';
                        ?>
                    </td>
                    <td>
                         <?php 
                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                    array('onclick' => 'inputKala4(this,'.$id.');',
                                        'class' => 'btn btn-primary',                                        
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => "tooltip",
                                        'id' => 'tambahKala4',
                                        'title' => "Klik untuk menambahkan pemeriksaan kala 4",));
                            ?>    
                    </td>
                </tr>
                
                <?php
            }
        
        }else{
             $this->renderPartial('_getFormKala4', array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan, 'id'=>$id)); 
        }
    ?>
  



