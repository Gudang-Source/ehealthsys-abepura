<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pelamar-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nama_pelamar'),
)); ?>

	<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($model,'nama_pelamar',array('class'=>'span3')); ?>
            <?php //echo $form->labelEx($model,'nama_pelamar', array('class'=>'control-label')); ?> 
            <!-- <div class="controls">
                <?php //echo CHtml::activeHiddenField($model,'nama_pelamar'); ?>
                <?php //echo CHtml::hiddenField('ygmengajukan_id'); ?>
                    <div style="float:left;">
                        <?php
                            $this->widget('MyJuiAutoComplete',array(
                                'model'=>$model,
                                'attribute'=>'nama_pelamar',
                                'sourceUrl'=>  Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/NamaPelamar'),
                                'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength'=>2,
                                    'select'=>'js:function( event, ui ) {
                                            $("#HRDPelamarT_nama_pelamar").val(ui.item.nama_pelamar);
                                                }',
                                ),
//                                'tombolDialog'=>array('idDialog'=>'dialogPegawaiYangMengajukan'),
                                'htmlOptions'=>array('class'=>'span2','style'=>'float:left;')
                            ));
                        ?>
			</div>
            </div> -->
		
		<div class="control-group">
			<?php echo CHtml::label('Semua Pelamar','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->checkBox($model,'semuapelamar', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</div>
	<div class="span6">		
		<?php echo $form->dropDownListRow($model,'pendidikan_id', CHtml::listData($model->PendidikanItems, 'pendidikan_id', 'pendidikan_nama') ,array('class'=>'span3', 'empty'=>'-- Pilih Pendidikan Pelamar --')); ?>
	</div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('pelamarT/admin'), array('class'=>'btn btn-danger')); ?>
    <?php
          $content = $this->renderPartial('../tips/informasi_pelamar',array(),true);
          $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
