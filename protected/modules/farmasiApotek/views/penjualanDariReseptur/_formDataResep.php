<div class="row-fluid">
    <div class="span4">

            <?php
                    echo $form->hiddenField($modPenjualan,'penjualanresep_id',array('readonly'=>true));
                ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPenjualan,'tglresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                        <?php                       
                                                    $modPenjualan->tglpenjualan = MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);
                                                    $modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modPenjualan->tglresep);
                                                    
                                                    if($this->ada_penjualan){
                                                            echo $form->textField($modPenjualan,'tglresep',array('readonly'=>true, 'style'=>'width:170px;'));
                                                    }else{
                                                            $this->widget('MyDateTimePicker',array(
                                                                                            'model'=>$modPenjualan,
                                                                                            'attribute'=>'tglresep',
                                                                                            'mode'=>'datetime',
                                                                                            'options'=> array(
                                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                                    'maxDate' => 'd',
                                                                                                    'yearRange'=> "-60:+0",
                                                                                            ),
                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'style'=>'width:128px;','onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                            ),
                                                            )); 
                                                    }
                                                    ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Penjualan','noresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPenjualan,'noresep',array('readonly'=>true, 'style'=>'width:170px;')); ?><br>
                        </div>
                    </div>
                    <div class="control-group">  
                    <?php echo $form->labelEx($modPenjualan,'pegawai_id', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modPenjualan,'pegawai_id'); ?>
                                            <?php echo $form->textField($modReseptur,'pegawai_id',array('readonly'=>true, 'style'=>'width:250px;','value'=>$modReseptur->pegawai2->namaLengkap)); ?><br>
                            <!--<div style="float:left;">-->
                                <?php
    //								echo $modReseptur->pegawai_id;exit;
    //                                $modReseptur->dokter = isset($_GET['idPenjualan'])?$modPenjualan->pegawai->nama_pegawai:null;
    //                                $this->widget('MyJuiAutoComplete',array(
    //                                    'model'=>$modReseptur,
    //                                    'attribute'=>'dokter',
    //                                    'sourceUrl'=>  Yii::app()->createUrl('ActionAutoComplete/ListDokter'),
    //                                    'options'=>array(
    //                                        'showAnim'=>'fold',
    //                                        'minLength'=>2,
    //                                        'select'=>'js:function( event, ui ) {
    //                                                $("#'.CHtml::activeId($modPenjualan,'pegawai_id').'").val(ui.item.pegawai_id);
    //                                                    }',
    //                                    ),
    //                                    'tombolDialog'=>array('idDialog'=>'dialogDokter'),
    //                                    'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Dokter",'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
    //                                ));
                                ?>
                            <!--</div>-->
                    </div>          
                    </div>
    </div>
    <div class="span4">
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'lamapelayanan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenjualan,'lamapelayanan',array('class'=>'inputFormTabel lebar3 integer2','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?> Detik
            </div> 
        </div>
        <?php 
            echo $form->hiddenField($modPenjualan,'discount',array('class'=>'inputFormTabel lebar3 integer2','readonly'=>true,'onkeyup'=>'hitungDiskonSemua();', 'onkeypress'=>"return $(this).focusNextInputField(event)"));
        ?>
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'tglpenjualan', array('class'=>'control-label')) ?>
            <div class="controls">
            <?php   
                                        if($this->ada_penjualan){
                                                echo $form->textField($modPenjualan,'tglpenjualan',array('readonly'=>true, 'style'=>'width:170px;'));
                                        }else{
                                                $this->widget('MyDateTimePicker',array(
                                                                                'model'=>$modPenjualan,
                                                                                'attribute'=>'tglpenjualan',
                                                                                'mode'=>'datetime',
                                                                                'options'=> array(
                                                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                                                        'maxDate' => 'd',
                                                                                        'yearRange'=> "-60:+0",
                                                                                ),
                                                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 realtime', 'style'=>'width:128px;', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                ),
                                        ));
                                        }
                 ?>
            </div>
        </div>
    </div>
    <div class="span4">

                    <?php //echo $form->textFieldRow($modPenjualan,'jenispenjualan',array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                    <div class='control-group'>
                                <?php echo $form->labelEx($modPenjualan,'isresepperawatan', array('class'=>'control-label')) ?>
                         <div class="controls">
                              <?php echo $form->checkBox($modPenjualan,'isresepperawatan', array('onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>$this->ada_penjualan)); ?>
                         </div>
                    </div> 

                                    <div class="control-group ">
                                            <label class="control-label" for="iter">Iter</label>
                                            <div class="controls">
                                                    <?php echo CHtml::activeTextField($modPenjualan, 'iter', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbers-only')) ?>
                                            </div>
                                    </div>
    </div>
</div>