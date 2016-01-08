<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenisrekonsiliasi-m-search',
        'type'=>'horizontal',
)); ?>

    <table width='100%'>
        <tr>
            <td>              
                <div class='control-group'>
                    <?php echo $form->labelEx($model,'jenisrekonsiliasibank_nama', array('class'=>'control-label')) ?>
                    <div class="controls">
                         <?php echo $form->textField($model,'jenisrekonsiliasibank_nama',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class='control-group'>
                               <?php echo $form->labelEx($model,'jenisrekonsiliasibank_namalain', array('class'=>'control-label')) ?>
                          <div class="controls">
                               <?php echo $form->textField($model,'jenisrekonsiliasibank_namalain',array('class'=>'span3','maxlength'=>50)); ?>
                          </div>
                </div>
                
                <div class='control-group'>
                            <?php echo CHtml::label('Rekening Debit','rekeningDebit', array('class'=>'control-label')); ?>
                     <div class="controls">
                            <?php echo $form->textField($model,'rekening_debit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     </div>
                </div>
            </td>
            <td>
                <div class='control-group'>
                            <?php echo CHtml::label('Rekening Kredit','rekeningDebit', array('class'=>'control-label')); ?>
                     <div class="controls">
                            <?php echo $form->textField($model,'rekeningKredit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="form-actions">
            <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); 
            ?>
    </div>

<?php $this->endWidget(); ?>
