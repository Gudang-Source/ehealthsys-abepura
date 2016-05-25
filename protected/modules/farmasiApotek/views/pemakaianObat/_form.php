<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'fapemakaianobat-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>
<?php $disabled = isset($_GET['sukses'])?true:false; ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box">
    <legend class="rim">Data Pemakaian Obat</legend>
	<div class="row-fluid">
		<div class="span4">
			
				<?php
				if($disabled){
					echo $form->textFieldRow($model,'tglpemakaianobat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>true));
				}else{ ?>
					<div class="control-group ">
						<?php echo $form->labelEx($model, 'tglpemakaianobat', array('class' => 'control-label')) ?>
						<div class="controls">
							<?php
								$model->tglpemakaianobat = !empty($model->tglpemakaianobat) ? MyFormatter::formatDateTimeForUser($model->tglpemakaianobat) : date('d M Y H:i:s');
								$this->widget('MyDateTimePicker', array(
									'model' => $model,
									'attribute' => 'tglpemakaianobat',
									'mode' => 'date',
									'options' => array(
										'dateFormat' => Params::DATE_FORMAT,
										'maxDate' => 'd',
									),
									'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
								));
								$model->tglpemakaianobat = !empty($model->tglpemakaianobat) ? MyFormatter::formatDateTimeForDb($model->tglpemakaianobat) : date('Y-m-d H:i:s');
							?>
							<?php echo $form->error($model, 'tglpemakaianobat'); ?>
						</div>
					</div>
				<?php } ?>
			<?php echo $form->textFieldRow($model,'nopemakaian_obat',array('disabled'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readonly'=>$disabled)); ?>
			
		</div>
                <div class="span4">
                    <?php echo $form->textAreaRow($model,'untukkeperluan_obat',array('rows'=>3, 'cols'=>80, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>$disabled)); ?>
                </div>
		<div class="span4">
			<?php echo $form->textAreaRow($model,'ket_pemakaianobat',array('rows'=>5, 'cols'=>180, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>$disabled)); ?>
		</div>
	</div>
</fieldset>
<?php if(!$disabled){ ?>
<fieldset class="box">
    <legend class="rim">Detail Obat</legend>
    <div class="row-fluid">
        <?php $this->renderPartial($this->path_view.'_formInputObat', array('model'=>$model, 'form'=>$form,)); ?>
    </div>
    <div class="block-tabel">
        <h6>Tabel <b>Obat Alkes</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>Kode / Nama Obat</th>
                    <th hidden>Satuan Kecil</th>
                    <th>Jumlah</th>
                    <th hidden>Stok</th>
                    <th>Harga Satuan</th>
                    <th>Sub Total</th>
                                        <?php echo ($disabled)?"":"<th>Batal</th>"; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modDetails) > 0){
                    foreach($modDetails AS $i=> $modDetail){
                        $modDetail->jmlstok = StokobatalkesT::getJumlahStokOaPemakaianTersimpan($modDetail->pemakaianobatdetail_id);
                        $modDetail->subtotal = $modDetail->qty_satuanpakai*$modDetail->harga_satuanpakai;
                        echo $this->renderPartial($this->path_view.'_rowDetail',array('modPemakaianObatDetail'=> $modDetail));
                    }
                }
                ?>
            </tbody>
                        <tfoot>
                                <tr>
                    <th colspan="3" style="text-align: right;">Total</th>
                    <th><?php echo $form->textField($model, 'totalharga',array('class'=>'integer','style'=>'width:100px;', 'readonly'=>'true')); ?></th>
                    <th></th>
                </tr>
                        </tfoot>
        </table>
    </div>
</fieldset>
<?php } ?>
<div class="form-actions">
	<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
		Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
		array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'cekObat();', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>$disabled)); ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
							$this->createUrl($this->module->id.'/Index'), 
							array('class'=>'btn btn-danger',
								'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
	<?php
		if(isset($_GET['sukses'])){
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
		}else{
			echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
		}
	?>
	<?php
		$content = $this->renderPartial('farmasiApotek.views.pemakaianObat.tips.transsaksiPemakaianObat',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>