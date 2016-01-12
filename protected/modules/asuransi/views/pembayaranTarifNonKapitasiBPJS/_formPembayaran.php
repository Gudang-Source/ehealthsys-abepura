<fieldset class="box">
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="control-group ">
						<?php $modPembayaranKapitasi->pembayarankapitasi_tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPembayaranKapitasi->pembayarankapitasi_tgl, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                       <?php echo $form->labelEx($modPembayaranKapitasi,'pembayarankapitasi_tgl', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPembayaranKapitasi,
                                                    'attribute'=>'pembayarankapitasi_tgl',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modPembayaranKapitasi,'pembayarankapitasi_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
                <td width="50%">
                    <div class="control-group ">
                        <?php $modTandaBukti->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modTandaBukti->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo $form->labelEx($modTandaBukti,'tglbuktibayar', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modTandaBukti,
                                                    'attribute'=>'tglbuktibayar',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>

                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modTandaBukti,'tglbuktibayar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                    <?php echo $form->dropDownListRow($modTandaBukti,'carapembayaran',  LookupM::getItems('carapembayaran'),array('onchange'=>'ubahCaraPembayaran(this)','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <div class="control-group ">
                        <?php echo CHtml::label('Menggunakan Kartu','pakeKartu', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo CHtml::checkBox('pakeKartu',false,array('onchange'=>"enableInputKartu();", 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?> <i class="icon-chevron-down"></i>
                        </div>
                    </div>
                    <div id="divDenganKartu" class="hide">
                        <?php echo $form->dropDownListRow($modTandaBukti,'dengankartu',  LookupM::getItems('dengankartu'),array('onchange'=>'enableInputKartu()','empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textFieldRow($modTandaBukti,'bankkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($modTandaBukti,'nokartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        <?php echo $form->textFieldRow($modTandaBukti,'nostrukkartu',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    </div>

                    <?php echo $form->textFieldRow($modTandaBukti,'darinama_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php echo $form->textAreaRow($modTandaBukti,'alamat_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textFieldRow($modTandaBukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <div class="form-actions">
        <?php
			if ($modTandaBukti->isNewRecord) {
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
								array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
			  echo "&nbsp;&nbsp;";
			} else {
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
								array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true)); 
			  echo "&nbsp;&nbsp;";

			}
			echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('pembayaranKapitasiBPJS/Index'), array('disabled'=>false,'class'=>'btn btn-danger'));
		 ?>