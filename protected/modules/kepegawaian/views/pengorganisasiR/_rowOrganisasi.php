<?php
    $i = (isset($i) ? $i : '' );
?>
<tr>
                        
                            <?php //echo $form->hiddenField($model,'['.$i.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                        <td style="padding-right:0px;">
                            
                            <?php echo $form->textField($model,'['.$i.']pengorganisasi_nama',array('class'=>'span2 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']pengorganisasi_kedudukan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'['.$i.']pengorganisasi_tahun',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker1',
                                                    ),
                        )); ?> 
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']pengorganisasi_lamanya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                            <?php echo $form->dropDownList($model,'['.$i.']lamanya',array('tahun'=>'tahun','bulan'=>'bulan','hari'=>'hari'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:55px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']pengorganisasi_tempat',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                        </td>
                    </tr>