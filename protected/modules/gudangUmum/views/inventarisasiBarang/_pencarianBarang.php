<div class="search-form">
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'pencarianbarang-form',
		'type' => 'horizontal',
		'focus' => '#' . CHtml::activeId($modBarang, 'barang_kode'),
	));
	?>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Jenis Inventarisasi', 'jenisinventarisasi', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (empty($model->formuliropname_id)) {
						echo $form->dropDownList($modBarang, 'invbarang_jenis', LookupM::getItems('jenisinventarisasi'), array('class' => 'span3', 'onchange' => 'setJenisInventarisasi();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					} else {
						echo $form->textField($modBarang, 'invbarang_jenis', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					}
					?>
				</div>
			</div>
			<?php echo $form->textFieldRow($modBarang, 'inventarisasi_kode', array('placeholder' => 'Ketik Kode Barang', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>     
                        
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($modBarang, 'barang_nama', array('placeholder' => 'Ketik Kode Barang', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>        
			<?php echo $form->textFieldRow($modBarang, 'barang_noseri', array('placeholder' => 'Ketik No. Seri', 'class' => 'span3', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($modBarang, 'barang_merk', array('placeholder' => 'Ketik Merk Barang', 'class' => 'span3', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>               
			<?php echo $form->dropDownListRow($modBarang, 'barang_satuan', CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
		<div class="span4">
                        <?php 
                        $g = GolonganM::model()->findAllByAttributes(array(
                            'golongan_aktif'=>true,
                        ), array(
                            'order'=>'golongan_nama',
                        ));
                        $b = BidangM::model()->findAllByAttributes(array(
                            'bidang_aktif'=>true,
                        ), array(
                            'order'=>'bidang_nama',
                        ));
                        $k = KelompokM::model()->findAllByAttributes(array(
                            'kelompok_aktif'=>true,
                        ), array(
                            'order'=>'kelompok_nama',
                        ));
                        $sk = SubkelompokM::model()->findAllByAttributes(array(
                            'subkelompok_aktif'=>true,
                        ), array(
                            'order'=>'subkelompok_nama',
                        ));
                        $ssk = SubsubkelompokM::model()->findAllByAttributes(array(
                            'subsubkelompok_aktif'=>true,
                        ), array(
                            'order'=>'subsubkelompok_nama',
                        ));
                        
                        echo $form->dropDownListRow($modBarang, 'golongan_id', CHtml::listData($g, 'golongan_id', 'golongan_nama'), 
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getBidang',array('encode'=>false,'model_nama'=>get_class($modBarang))), 
                                'success'=>'function(data){$("#'.CHtml::activeId($modBarang, "bidang_id").'").html(data); }',
                            ),
                        )); 
                        
                        echo $form->dropDownListRow($modBarang, 'bidang_id', array(), //CHtml::listData($b, 'bidang_id', 'bidang_nama'), 
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getKelompok',array('encode'=>false,'model_nama'=>get_class($modBarang))), 
                                'success'=>'function(data){$("#'.CHtml::activeId($modBarang, "kelompok_id").'").html(data); }',
                            ),
                        ));
                        
                        echo $form->dropDownListRow($modBarang, 'kelompok_id', array(), //CHtml::listData($k, 'kelompok_id', 'kelompok_nama'), 
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getSubKelompok',array('encode'=>false,'model_nama'=>get_class($modBarang))), 
                                'success'=>'function(data){$("#'.CHtml::activeId($modBarang, "subkelompok_id").'").html(data); }',
                            ),
                        ));
                        
                        echo $form->dropDownListRow($modBarang, 'subkelompok_id', array(), //CHtml::listData($sk, 'subkelompok_id', 'subkelompok_nama'), 
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                            'ajax' => array('type'=>'POST',
                                'url'=> $this->createUrl('/actionDynamic/getSubSubKelompok', array('encode'=>false,'model_nama'=>get_class($modBarang))), 
                                'success'=>'function(data){$("#'.CHtml::activeId($modBarang, "subsubkelompok_id").'").html(data); }',
                            ),
                        ));
                        
                        echo $form->dropDownListRow($modBarang, 'subsubkelompok_id', array(), //CHtml::listData($ssk, 'subsubkelompok_id', 'subsubkelompok_nama'), 
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3',
                        ));
                        
                        ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>