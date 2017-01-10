<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gupemakaianbarang-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
	<fieldset class="box">
		<legend class="rim">Data Pemakaian Barang</legend>
		<div class="row-fluid">
			<div class="span4">
				<div class="control-group ">
					<?php echo $form->labelEx($model, 'tglpemakaianbrg', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$model->tglpemakaianbrg = !empty($model->tglpemakaianbrg) ? MyFormatter::formatDateTimeForUser($model->tglpemakaianbrg) : date('d M Y H:i:s');
						/*$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglpemakaianbrg',
							'mode' => 'date',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
						));*/
                                                echo $form->textField($model, 'tglpemakaianbrg', array('class' => 'realtime', 'readonly' => TRUE));
						$model->tglpemakaianbrg = !empty($model->tglpemakaianbrg) ? MyFormatter::formatDateTimeForDb($model->tglpemakaianbrg) : date('Y-m-d H:i:s');
						?>
						<?php echo $form->error($model, 'tglpemakaianbrg'); ?>
					</div>
				</div>
				<?php echo $form->textFieldRow($model,'nopemakaianbrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>true)); ?>
                                <?php echo $form->dropDownListRow($model,'pegawai_id',Chtml::listData(
                                            PegawairuanganV::model()->findAllByAttributes(array(
                                            'pegawai_aktif'=>true,
                                            'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                                        ), array(
                                            'order'=>'nama_pegawai asc'
                                        ))
                                        ,'pegawai_id','nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
			</div>
			<div class="span4">
				<?php echo $form->textAreaRow($model,'untukkeperluan',array('rows'=>3, 'cols'=>80, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
			<div class="span4">
				<?php echo $form->textAreaRow($model,'keteranganpakai',array('rows'=>5, 'cols'=>180, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	</fieldset>

	<fieldset class="box">
            <legend class="rim">Detail Barang</legend>
            <?php $this->renderPartial($this->path_view.'_formDetailBarang', array('model'=>$model, 'form'=>$form,)); ?>		
            <div class="block-tabel">
                <h6>Tabel <b>Pemakaian Barang</b></h6>
                <?php $this->renderPartial($this->path_view.'_tableDetailBarang', array('model'=>$model, 'form'=>$form, 'modDetails'=>$modDetails,)); ?>
            </div>
	</fieldset>
	<div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekBarang();', 'onkeypress'=>'cekBarang();','disabled'=>$disableSave)); //formSubmit(this,event) ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
								$this->createUrl($this->module->id.'/Index'), 
								array('class'=>'btn btn-danger',
									'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
		<?php
			if(isset($_GET['sukses'])){
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
			}else{
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
			}
		?>
		<?php
			$content = $this->renderPartial('gudangUmum.views.pemakaianbarangT.tips.tipsPemakaianBarang',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
	</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modDetails'=>$modDetails)); ?>