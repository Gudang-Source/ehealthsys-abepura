<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Uang Muka</b></legend>
	<?php
	$this->breadcrumbs = array(
		'Daftar Pasien' => array('/billingKasir/daftarPasien'),
		'PasienKarcis',
	);
	?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'caripasien-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'focus' => '#BKInformasibayaruangmukaV',
		'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
	));

	Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
	?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Uang Muka</b></h6>
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'pencarianpasien-grid',
			'dataProvider' => $model->search(),
			'template' => "{summary}\n{items}\n{pager}",
			'itemsCssClass' => 'table table-striped table-condensed',
			'columns' => array(
				array(
					'header' => 'Tanggal Deposit',
					'name' => 'tgluangmuka',
					'type' => 'raw',
					'value' => 'MyFormatter::formatDateTimeForUser($data->tgluangmuka)',
				),
				array(
					'header' => 'Uang Muka Untuk',
					'name' => 'instalasi',
					'type' => 'raw',
					'value' => 'isset($data->instalasi_id)?$data->instalasi_nama. " / ".$data->ruangan_nama:" - "',
				),
				array(
					'header' => 'No. Pendaftaran<br>No. RM',
					'type' => 'raw',
					'value' => '$data->no_pendaftaran . " <br> " . $data->no_rekam_medik',
				),
				array(
					'name' => 'nama_pasien',
					'type' => 'raw',
					'value' => '$data->nama_pasien',
				),
				array(
					'header' => 'Cara Bayar',
					'name' => 'carabayar_nama',
					'type' => 'raw',
					'value' => '$data->carabayar_nama',
				),
				array(
					'header' => 'Penjamin',
					'name' => 'penjamin_nama',
					'type' => 'raw',
					'value' => '$data->penjamin_nama',
				),
				//            array(
				//                'header'=>'Kasus Penyakit',
				//                'name'=>'jeniskasuspenyakit_nama',
				//                'type'=>'raw',
				//                'value'=>'$data->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama',
				//            ),
				//            array(
				//                'name'=>'umur',
				//                'type'=>'raw',
				//                'value'=>'$data->pendaftaran->umur',
				//            ),
				//            array(
				//                'header'=>'Alamat',
				//                'name'=>'alamat_pasien',
				//                'type'=>'raw',
				//                'value'=>'$data->pasien->alamat_pasien',
				//            ),
				array(
					'header' => 'Jumlah Uang Muka',
					'name' => 'jumlahuangmuka',
					'type' => 'raw',
					'value' => '"Rp. ".number_format($data->jumlahuangmuka,0,",",".")',
					'htmlOptions' => array('style' => 'text-align: left; width:80px')
				),
				array(
					'header' => 'Pemakaian Uang Muka',
					'type' => 'raw',
					'value' => '"Rp. ".number_format($data->pemakaianuangmuka,0,",",".")',
					'htmlOptions' => array('style' => 'text-align: left; width:80px')
				),
				array(
					'header' => 'Sisa Uang Muka',
					'type' => 'raw',
					'value' => '"Rp. ".number_format($data->sisauangmuka,0,",",".")',
					'htmlOptions' => array('style' => 'text-align: left; width:80px')
				),
//                    array(
//                        'header'=>'Jumlah Pembayaran',
//                        'type'=>'raw',
//                        'value'=>'"Rp. ".number_format($data->jmlpembayaran,0,",",".")',
//                        'htmlOptions'=>array('style'=>'text-align: left; width:80px')
//                    ),
				array(
					'header' => 'Sisa Pembayaran',
					'type' => 'raw',
					'value' => '$data->sisaPembayaran($data->jmlpembayaran,$data->jumlahuangmuka)',
					'htmlOptions' => array('style' => 'text-align: left; width:80px')
				),
				array(
					'header' => 'Keterangan',
					'name' => 'keteranganuangmuka',
					'type' => 'raw',
					'value' => '$data->keteranganuangmuka',
				),
				array(
					'header' => 'Tanggal Perjanjian',
					'name' => 'tglperjanjian',
					'type' => 'raw',
					'value' => 'MyFormatter::formatDateTimeForUser($data->tglperjanjian)',
				),
				array(
					'name' => 'keterangan_perjanjian',
					'type' => 'raw',
					'value' => '$data->keterangan_perjanjian',
				),
				array(
					'header' => 'Pembatalan',
					'type' => 'raw',
					'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("pembatalanUangMuka/index",array("idBayarUangMuka"=>$data->bayaruangmuka_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogBatalUangMuka\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membatalkan uang muka",
                                    ))', 'htmlOptions' => array('style' => 'text-align: center; width:40px')
				),
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
    </div>
	<?php //echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);   ?> 

    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> <?php echo Yii::t('mds', 'Search Patient') ?></legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
						<?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');  ?>
						<?php echo CHtml::label('Tanggal Pendaftaran', 'tglPendaftaran', array('class' => 'control-label inline')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_awal',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions' => array('class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>

                        </div>
                    </div>
                    <div class="control-group ">
						<?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
						<?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_akhir',
								'mode' => 'date',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								//                                                    'minDate' => 'd',
								),
								'htmlOptions' => array('class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>

                        </div>
                    </div>
					<?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
					<?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
					<?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>                
					<div class="control-group">
						<?php echo CHtml::label("Instalasi", "instalasi_id", array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(BKInstalasiM::getItems(), 'instalasi_id', 'instalasi_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
									'ajax' => array('type' => 'POST',
										'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
										'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data);}',
								)));
							?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label("Ruangan", "ruangan_id", array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
								$modRuangans = BKRuanganM::getItems($model->instalasi_id);
								echo $form->dropDownList($model, 'ruangan_id', ((count($modRuangans) > 0) ? CHtml::listData($modRuangans, 'ruangan_id', 'ruangan_nama') : array()), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
							
							?>
						</div>
					</div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
			<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
			<?php
			$content = $this->renderPartial('billingKasir.views.daftarPasien/tips/informasi2', array(), true);
			$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
			?>
        </div>
    </fieldset>
	<?php $this->endWidget(); ?>

	<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'dialogBatalUangMuka',
		'options' => array(
			'title' => 'Pembatalan Uang Muka',
			'autoOpen' => false,
			'modal' => true,
			'minWidth' => 980,
			'zIndex' => 1001,
			'minHeight' => 610,
			'resizable' => true,
			'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
					data: $(this).serialize()
				}); }",
		),
	));
	?>
    <iframe src="" name="iframePembayaran" width="100%" height="550" ></iframe>
	<?php
	$this->endWidget();
	?>

	<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'dialogEditUangMuka',
		'options' => array(
			'title' => 'Edit Uang Muka',
			'autoOpen' => false,
			'modal' => true,
			'minWidth' => 980,
			'zIndex' => 1001,
			'minHeight' => 610,
			'resizable' => true,
		),
			)
	);
	?>
    <iframe src="" name="iframeUangMuka" width="100%" height="550" ></iframe>
	<?php
	$this->endWidget();
	?>
</div>