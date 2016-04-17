<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'informasi-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'instalasi_id'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian Kartu Stok Obat Alkes</legend>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Transaksi','tgl_awal', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_awal',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            )); 
                            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                        ?>
                    </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Sampai Dengan','tgl_akhir', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                            )); 
                            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                        ?>
                    </div>
            </div>
            
        </div>
        <div class="span4">
            <?php echo $form->dropDownListRow($model,'instalasi_id', $instalasiAsals, 
                    array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                            'ajax'=>array('type'=>'POST',
                                        'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                        'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                            )));?>
            <?php echo $form->dropDownListRow($model,'ruangan_id',$ruanganAsals,array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
				<?php echo CHtml::label('Nama Transaksi','Nama Transaksi', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'transaksi',$model->getNamaTransaksiKartuStok(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
				</div>
            </div>
            <?php echo $form->dropDownListRow($model,'jenisobatalkes_id',  
                    CHtml::listData(JenisobatalkesM::model()->findAll(array(
                        'condition'=>'jenisobatalkes_aktif = true',
                        'order'=>'jenisobatalkes_nama',
                    )), "jenisobatalkes_id", "jenisobatalkes_nama")
                    ,array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'obatalkes_golongan',  ObatAlkesGolongan::items() ,array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'obatalkes_kategori', ObatAlkesKategori::items() ,array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'obatalkes_kode',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'obatalkes_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'satuankecil_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			<?php // echo $form->dropDownListRow($model,'transaksi',$model->getNamaTransaksiKartuStok(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
			<?php // echo $form->textFieldRow($model,'obatalkes_golongan',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			<?php echo $form->textFieldRow($model,'nobatch',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'tglkadaluarsa', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php   
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tglkadaluarsa',
											'mode'=>'date',
											'options'=> array(
												'showOn' => false,
												'maxDate' => 'd',
												'yearRange'=> "-150:+0",
											),
											'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
											),
					));
					$model->tglkadaluarsa = $format->formatDateTimeforDb($model->tglkadaluarsa); ?>
			</div>
		</div>
		</div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?><?php
           $content = $this->renderPartial($this->path_view.'/tips/tipsInformasi',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
    <?php $this->endWidget(); ?>
</div>
