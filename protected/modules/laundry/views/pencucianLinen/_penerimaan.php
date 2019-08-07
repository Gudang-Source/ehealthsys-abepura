<div class="search-form">
<?php

$modInfoPencucian = PenerimaanlinenT::model()->findByPk($penerimaanlinen_id);
$modInfoPencucian->tglpenerimaanlinen = MyFormatter::formatDateTimeForUser($modInfoPencucian->tglpenerimaanlinen);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
));
?>
	<div class="row-fluid">
                <div class="span4">
			<div class="control-group ">
				<?php echo CHtml::label('No. Penerimaan', '', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modInfoPencucian,'nopenerimaanlinen',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>
					</div> 
			</div>
		</div>
                <div class="span4">
                    <div class="control-group ">
                        <?php echo CHtml::label('Tgl. Penerimaan','',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->textField($modInfoPencucian,'tglpenerimaanlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                        </div> 
                    </div>
                </div>
            
                <?php /*
		<div class="span4">
			<?php echo $form->textFieldRow($modInfoPencucian,'nopenerimaanlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
			<div class="control-group ">
				<?php echo $form->labelEx($modInfoPencucian,'Jenis Perawatan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modInfoPencucian,'nopenerimaanlinen',LookupM::getItems('jenisperawatan'),array('empty'=>'--Pilih--','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
					</div> 
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modInfoPencucian,'instalasi_id', $instalasiTujuans, 
							array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
									'ajax'=>array('type'=>'POST',
												'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modInfoPencucian))),
												'update'=>"#".CHtml::activeId($modInfoPencucian, 'ruangan_id'),
									)));?>
				</div>
			</div>
			<?php echo $form->dropDownListRow($modInfoPencucian,'ruangan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
		</div>
                 * 
                 */ ?>
	</div>
<?php $this->endWidget(); ?>
</div>