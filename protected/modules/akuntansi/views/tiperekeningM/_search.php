<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'tiperekening-m-search',
        'type'=>'horizontal',
)); ?>
        <table>
            <tr>
                <td>
                    <div class='control-group'>
                         <?php echo $form->labelEx($model,'tiperekening', array('class'=>'control-label')) ?>
                         <div class="controls">
                              <?php echo $form->textField($model,'tiperekening',array('class'=>'span3','maxlength'=>50)); ?>
                         </div>
                    </div>
                    <div>
                               <?php echo $form->checkBoxRow($model,'tiperekening_aktif',array('checked'=>'checked')); ?>
                    </div>
                </td>
                <td>
                    <div class='control-group'>
                          <?php echo $form->labelEx($model,'keterangan', array('class'=>'control-label')) ?>
                          <div class="controls">
                                 <?php echo $form->textArea($model,'keterangan',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>
                          </div>
                    </div> 
                </td>
            </tr>
        </table>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
