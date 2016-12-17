
    <div class="span12"> 
        <div class="control-group">
            <?php echo Chtml::label("Jenis Simpanan", 'jenissimpanan_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($simpanan,'jenissimpanan_id', Chtml::listData(JenissimpananM::model()->findAll("jenissimpanan_aktif = TRUE ORDER BY jenissimpanan ASC"),'jenissimpanan_id', 'jenissimpanan'),array('onchange'=>'cekJenisSimpanan(this);' ,'empty'=>'-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
    </div>

<div class="detail-simpanan" hidden>
        <hr/>
    <div class="span5">        
            <div class="control-group">
                    <?php echo CHtml::label('No Simpanan', null, array('class'=>'control-label col-sm-2')); ?>
                    <div class="controls">
                            <?php echo $form->textField($simpanan,'nosimpanan', array('readonly'=>true,  'empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),)); ?>
                    </div>
            </div>
     </div>
     <div class="span9">        
            <div class="control-group">
                    <?php //echo $form->label($simpanan, 'jumlahsimpanan', array('class'=>'control-label col-sm-2')); ?>
                    <label class="control-label col-sm-2" for="PermohonanpinjamanT_jumlahsimpanan">Jumlah Simpanan<span class="required">*</span></label>
                    <div class="controls">
                            <?php echo $form->textField($simpanan,'jumlahsimpanan', array('data-validate'=>'number', 'class'=>'span3','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),'value' => 0)); ?>
                            <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$form->label($simpanan, 'Jasa (%)', array('class'=>'col-sm-1')); ?>
                            <?php echo $form->textField($simpanan,'persenjasa_thn', array('class'=>'span1','maxlength'=>3,)); ?>
                    </div>								
            </div>

            <div class="control-group">		
                    <?php echo $form->label($simpanan, 'Jangka Waktu', array('class'=>'control-label col-sm-2')); ?>
                    <div class="controls">
                            <?php echo $form->textField($simpanan,'jangkawaktusimpanan', array('data-validate'=>'number', 'class'=>'span1','maxlength'=>3, 'value'=>'0')); ?>
                            <?php echo $form->dropDownList($simpanan, 'satuan', Params::satuanWaktu(), array('empty'=>'-- Satuan --', 'class'=>'form-control')); ?>
                    </div>		
            </div>
    </div>
</div>