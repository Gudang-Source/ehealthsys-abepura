<fieldset class="box">
    <legend class="rim">Kontrak Pegawai</legend>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modKontrak,'nosuratkontrak', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKontrak,'nosuratkontrak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>   
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
               <div class="control-group">
                    <?php echo $form->labelEx($modKontrak,'tglkontrak', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                                    $modKontrak->tglkontrak = (!empty($modKontrak->tglkontrak) ? date("d/m/Y",strtotime($modKontrak->tglkontrak)) : null);
                                                    $this->widget('MyDateTimePicker',array(
                                                                                    'model'=>$modKontrak,
                                                                                    'attribute'=>'tglkontrak',
                                                                                    'mode'=>'date',
                                                                                    'options'=> array(
                                                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                                                            'maxDate' => 'd',                                                        
                                                                                            'yearRange'=> "-150:+0",
                                                                                    ),
                                                                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                                    ),
                                            )); ?> 
                    </div>
                </div> 
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                <?php echo $form->labelEx($modKontrak,'tglmulaikontrak', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <table style="width: 100%; margin: 0; padding: 0">
                            <tr>
                                <td> 
                                                                    <?php   
                                                                            $modKontrak->tglmulaikontrak = (!empty($modKontrak->tglmulaikontrak) ? date("d/m/Y",strtotime($modKontrak->tglmulaikontrak)) : null);
                                                                            $this->widget('MyDateTimePicker',array(
                                                                                            'model'=>$modKontrak,
                                                                                            'attribute'=>'tglmulaikontrak',
                                                                                            'mode'=>'date',
                                                                                            'options'=> array(
                                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                                    'maxDate' => 'd',                                                        
                                                                                                    'yearRange'=> "-150:+0",
                                                                                                    'onkeypress'=>"js:function(){lamaKontrak(this);}",
                                                                                                    'onSelect'=>'js:function(){lamaKontrak(this);}',
                                                                                            ),
                                                                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                                            ),
                                                                            )); 
                                                                    ?>
                                                            </td>
                                <td>Sampai </td>
                                <td>
                                                                    <?php   
                                                                            $modKontrak->tglakhirkontrak = (!empty($modKontrak->tglakhirkontrak) ? date("d/m/Y",strtotime($modKontrak->tglakhirkontrak)) : null);
                                                                            $this->widget('MyDateTimePicker',array(
                                                                                            'model'=>$modKontrak,
                                                                                            'attribute'=>'tglakhirkontrak',
                                                                                            'mode'=>'date',
                                                                                            'options'=> array(
                                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                                    'minDate' => 'd',                                                        
                                                                                                    'yearRange'=> "-150:+0",
                                                                                                    'onkeypress'=>"js:function(){lamaKontrak(this);}",
                                                                                                    'onSelect'=>'js:function(){lamaKontrak(this);}',
                                                                                            ),
                                                                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                                            ),
                                                                            )); 
                                                                    ?>
                                                            </td>
                            </tr>
                        </table>                      
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modKontrak,'lamakontrak', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKontrak,'lamakontrak',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modKontrak,'keterangankontrak', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modKontrak,'keterangankontrak',array('rows'=>3, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>


    
    <?php //echo $form->textFieldRow($modKontrak,'tglkontrak',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($modKontrak,'nourutkontrak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>


    
    <div class="control-group">
        <?php //echo $form->labelEx($modKontrak,'tglmulaikontrak', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php //echo $form->textField($modKontrak,'tglmulaikontrak',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <!--        &nbsp; S/d : &nbsp;&nbsp;-->
            <?php //echo $form->textField($modKontrak,'tglakhirkontrak',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>


    <?php //echo $form->textFieldRow($modKontrak,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($modKontrak,'create_user',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
</fieldset>