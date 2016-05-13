<legend class="rim"><i class="icon-white icon-search"></i> Pencarian Penjualan</legend>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Penjualan','tglPenjualan', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true, 
                                                'class'=>'dtPicker3', 
                                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>

                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true, 
                                                'class'=>'dtPicker3', 
                                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>

                </div>
            </div>

        </td>
        <td>
            <?php //echo $form->textFieldRow($model,'noresep',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group ">
                <label for="BKPenjualanresepT_noresep" class="control-label">No. Resep / Struk</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'noresep', array('class'=>'span3')); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'), array(
                'empty'=>'-- Pilih --', 'class'=>'span3',
            )); ?>
        </td>
    </tr>
</table>