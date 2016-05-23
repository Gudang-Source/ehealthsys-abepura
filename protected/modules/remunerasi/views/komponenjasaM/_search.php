<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'komponenjasa-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td><?php echo $form->dropDownListRow($model,'komponentarif_id',CHtml::listData($model->getKomponentarifItems(),'komponentarif_id','komponentarif_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:120px;')) ?></td>
        <td><?php echo $form->textFieldRow($model,'komponenjasa_kode',array('class'=>'span2','maxlength'=>5)); ?></td>
        <td><?php echo $form->textFieldRow($model,'jasadireksi',array('class'=>'span2','maxlength'=>50)); ?></td>
        <td>
            
	<?php echo $form->textFieldRow($model,'biayaumum',array('class'=>'span2','maxlength'=>50)); ?>
	
        </td>
    </tr>
    <tr>
        <td>
            <?php //golongan
                echo $form->dropDownListRow($model,'jenistarif_id', CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'), 
                      array('class'=>'span2','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                              'ajax'=>array('type'=>'POST',
                                          'url'=>$this->createUrl('/ActionDynamic/GetCaraBayar',array('encode'=>false,'model_nama'=>get_class($model))),
                                          'update'=>"#".CHtml::activeId($model, 'carabayar_id'),
                              ),
                          //    'onchange'=>"setClearBidang();setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",
                          ));?>
        </td>
        <td><?php echo $form->textFieldRow($model,'komponenjasa_nama',array('class'=>'span2','maxlength'=>100)); ?></td>
        <td><?php echo $form->textFieldRow($model,'kuebesar',array('class'=>'span2','maxlength'=>50)); ?></td>
        <td><?php echo $form->checkBoxRow($model,'komponenjasa_aktif',array('checked'=>'komponenjasa_aktif')); ?></td>
    </tr>
    <tr>
        <td>            
            <?php echo $form->dropDownListRow($model,'carabayar_id',CHtml::listData($model->getCarabayarItems(),'carabayar_id','carabayar_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:120px;')) ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'komponenjasa_singkatan',array('class'=>'span2','maxlength'=>10)); ?>
        </td>
        <td><?php echo $form->textFieldRow($model,'jasaparamedis',array('class'=>'span2','maxlength'=>50)); ?></td>
    </tr>    
    <tr>        
        <td><?php echo $form->dropDownListRow($model,'kelompoktindakan_id',CHtml::listData($model->getKelompoktindakanItems(),'kelompoktindakan_id','kelompoktindakan_nama'),array('class'=>'span2','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:60px;')); ?></td>
        <td><?php echo $form->textFieldRow($model,'besaranjasa',array('class'=>'span2')); ?></td>
        <td><?php echo $form->textFieldRow($model,'jasaunit',array('class'=>'span2','maxlength'=>50)); ?></td>
    </tr>
    <tr>
        <td><?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('class'=>'span2','onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','style'=>'width:60px;')); ?></td>
        <td><?php echo $form->textFieldRow($model,'potongan',array('class'=>'span2')); ?></td>
        <td><?php echo $form->textFieldRow($model,'jasabalanceins',array('class'=>'span2','maxlength'=>50)); ?></td>
    </tr>
    <tr>
        
        
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'komponenjasa_id',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
