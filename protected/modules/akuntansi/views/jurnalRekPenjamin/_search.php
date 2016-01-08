<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
        'type'=>'horizontal',
)); ?>


<table>
    <tr>
        <td>
            <div class="control-group">
                 <?php echo CHtml::label('Cara Bayar','', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
//                        echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,
//                                array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
//                                        'ajax' => array('type'=>'POST',
//                                            'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'AKPenjaminpasienM')), 
//                                            'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
//                                        ),
//                            ));

                            echo $form->textField($model,'carabayar_nama',array('class'=>'span3'));
                    ?>
                </div>
            </div>
            <div class="control-group">
                 <?php echo CHtml::label('Penjamin','', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php 
//                        echo $form->dropDownList($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,
//                                array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
                           echo $form->textField($model,'penjamin_nama',array('class'=>'span3'));
                    ?>
                </div>
            </div>    
        </td>
        <td>
            <div class='control-group'>
                 <?php echo CHtml::label('Rekening Debit','rekeningDebit', array('class'=>'control-label')); ?>
                 <div class="controls">
                     <?php echo $form->textField($model,'rekening_debit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 </div>
            </div> 
                
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
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit')); 
                ?>
                
	</div>

<?php $this->endWidget(); ?>
