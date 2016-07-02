<div class="search-form">
<?php

$modPenerimaanLinenDetail = PenerimaanlinenT::model()->findByPk($penerimaanlinen_id);
$modPenerimaanLinenDetail->tglpenerimaanlinen = MyFormatter::formatDateTimeForUser($modPenerimaanLinenDetail->tglpenerimaanlinen);

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
						<?php echo $form->textField($modPenerimaanLinenDetail,'nopenerimaanlinen',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>
					</div> 
			</div>
		</div>
                <div class="span4">
                    <div class="control-group ">
                        <?php echo CHtml::label('Tgl. Penerimaan','',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->textField($modPenerimaanLinenDetail,'tglpenerimaanlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                        </div> 
                    </div>
                </div>
            <?php /*
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanLinenDetail,'instalasi_id', $instalasiTujuans, 
							array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
									'ajax'=>array('type'=>'POST',
												'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modPenerimaanLinenDetail))),
												'update'=>"#".CHtml::activeId($modPenerimaanLinenDetail, 'ruangan_id'),
									)));?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanLinenDetail,'ruangan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
				</div>
			</div>			
		</div>
             * 
             */ ?>
	</div>
<?php $this->endWidget(); ?>
</div>