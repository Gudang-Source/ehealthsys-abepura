<div class="row-fluid">
    <div class = "span4">
        <?php echo $form->textFieldRow($model,'tglpembayaran',array('readonly'=>true,'class'=>'span2 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<?php echo $form->textFieldRow($model,'totalbiayapelayanan',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totaliurbiaya',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totaldiscount',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totalpembebasan',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modTandabukti, 'biayaadministrasi', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'biayaadministrasi',array('onblur'=>'hitungJmlpembulatan();hitungJmlpembayaran();','class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
	</div>
	<div class = "span4">
        <div class="control-group">
            <?php echo $form->labelEx($modTandabukti, 'biayamaterai', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'biayamaterai',array('onblur'=>'hitungJmlpembulatan();hitungJmlpembayaran();','class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modTandabukti, 'jmlpembulatan', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'jmlpembulatan',array('onblur'=>'hitungJmlpembayaran();','class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div style="display:none;">  <!--RND-2568 -->
            <?php echo $this->renderPartial($this->path_view.'_formDetailTotal',array(
                        'form'=>$form,
                        'model'=>$model,
                        )); ?>
        </div>
    

        <?php echo $form->textFieldRow($modTandabukti,'jmlpembayaran',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modPemakaianuangmuka,'totaluangmuka',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<div class="control-group">
            <?php echo $form->labelEx($modPemakaianuangmuka, 'pemakaianuangmuka', array('class'=>'control-label required','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modPemakaianuangmuka,'pemakaianuangmuka',array('onblur'=>'hitungUangKembalian();','class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>	
        <?php echo $form->textFieldRow($modPemakaianuangmuka,'sisauangmuka',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	</div> 
	<div class = "span4">        
		<div class="control-group">
            <?php echo $form->labelEx($modTandabukti, 'uangditerima', array('class'=>'control-label','style'=>'font-weight:bold;'))?>
            <div class="controls">
                <?php echo $form->textField($modTandabukti,'uangditerima',array('onblur'=>'hitungUangKembalian();','class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modTandabukti,'uangkembalian',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'totalsisatagihan',array('readonly'=>true,'class'=>'span2 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($modTandabukti,'carapembayaran',LookupM::getItems('carapembayaran'),array('readonly'=>true,'onchange'=>'hitungUangKembalian();','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    </div>
</div>
<div class="row-fluid">
    <div class = "span4">
        <?php echo $form->textAreaRow($modTandabukti,'darinama_bkm',array('Placeholder'=>'Nama Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($modTandabukti,'alamat_bkm',array('Placeholder'=>'Alamat Lengkap Pembayar','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($modTandabukti,'sebagaipembayaran_bkm',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class = "span4">
        <?php echo $form->hiddenField($modTandabukti,'is_menggunakankartu',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        'id'=>'form-kartupembayaran',
        'content'=>array(
            'content-kartupembayaran'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form Bayar Via Bank')).'<b> Bayar Via Bank</b>',
                'isi'=>$this->renderPartial($this->path_view.'_formKartuPembayaran',array(
                        'form'=>$form,
                        'modTandabukti'=>$modTandabukti,
                        ),true),
                'active'=>false,
                ),   
            ),
        )); ?>
    </div>
    <div class = "span4"></div>
</div>
    
