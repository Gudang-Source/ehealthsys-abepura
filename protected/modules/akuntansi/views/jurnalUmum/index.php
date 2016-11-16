<div class="white-container" id="inputJurnalUmum">
    <div class='divForForm'>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    </div>
    <legend class="rim2">Jurnal <b>Umum</b></legend>
	<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js');

	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'form-jurnal-umum',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'htmlOptions' => array(
			'onKeyPress' => 'return disableKeyPress(event)',
			'onSubmit' => 'return requiredCheck(this);'
		),
		'focus' => '#',
			)
	);
	$this->widget('bootstrap.widgets.BootAlert');
	?>
    <table width="100%">
        <tr>
            <td>
				<?php
				echo $form->hiddenField(
						$model, "jurnalrekening_id", array(
					'class' => 'span1',
					'onkeypress' => "return $(this).focusNextInputField(event)",
					'readonly' => false
						)
				);
				?>
				<?php echo $form->dropDownListRow($model, 'jenisjurnal_id', JenisjurnalM::items(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm span3')); ?>
                <div class="control-group ">
					<?php echo $form->labelEx($model, 'tglbuktijurnal', array('class' => 'control-label')) ?>
                    <div class="controls">
						<?php
                                                $model->tglbuktijurnal = MyFormatter::formatDateTimeForUser($model->tglbuktijurnal);
                                                $model->tglreferensi = MyFormatter::formatDateTimeForUser($model->tglreferensi);
                                                
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglbuktijurnal',
							'mode' => 'datetime',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array(
								'style' => 'width:166px', 'class' => 'reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)",
							),
						));
						?>

                    </div>
                </div>
                <div class="control-group ">
					<?php echo $form->labelEx($model, 'tglreferensi', array('class' => 'control-label')) ?>
                    <div class="controls">
						<?php
                                                
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglreferensi',
							'mode' => 'datetime',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array(
								'style' => 'width:166px', 'class' => 'reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)",
							),
						));
						?>

                    </div>
                </div>
            </td>
            <td>
				<?php echo $form->textFieldRow($model, 'nobuktijurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>
				<?php echo $form->textFieldRow($model, 'kodejurnal', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => true)); ?>
				<?php
				if (!empty($model->rekperiod_id)) {
					echo $form->hiddenField(
							$model, 'rekperiod_id', array(
						'class' => 'span1',
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'readonly' => false
							)
					);
				}
//                    echo $form->dropDownListRow($model,'rekperiod_id', RekperiodM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm'));
				?>
				<?php echo $form->textFieldRow($model, 'noreferensi', array('class' => 'span3 reqForm numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
            </td>
            <td>
				<?php echo $form->textFieldRow($model, 'nobku', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
				<?php echo $form->textAreaRow($model, 'urianjurnal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
            </td>
        </tr>
    </table>
    <div class="block-tabel">
        <h6>Detail <b>Jurnal</b></h6>
        <div class="control-group ">
            <label class="control-label">Pilih Rekening</label>
            <div class="controls">
				<?php
				echo CHtml::dropDownList('isJenisRekenig', "", LookupM::getItems('jenis_rekening'), array(
					'empty' => '-- Pilih --',
					'onkeypress' => "return $(this).focusNextInputField(event)",
					'style' => 'float:left;margin-right:5px;',
                                        'onchange' => 'setSaldoNormal(this)',
					'class' => 'span2',
                                ));
				?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model' => $model,
					'attribute' => 'rekening_nama',
					'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 2,
						'focus' => 'js:function( event, ui ){return false;}',
						'select' => 'js:function( event, ui ){
								getDataRekening(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id);
                                return false;
                            }'
					),
					'htmlOptions' => array(
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'placeholder' => 'Pilih rekening yang akan dijurnal',
						'class' => 'span3',
					),
					'tombolDialog' => array('idDialog' => 'dialogRincianRek',),
				));
				?>
            </div>
        </div>    
		<?php echo $this->renderPartial('__gridDetailJurnal', array('modelJurDetail' => $modelJurDetail, 'form' => $form)); ?>        
    </div>
	<div class="form-actions">
		<?php
		$this->widget('bootstrap.widgets.BootButtonGroup', array(
			'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'buttons' => array(
				array(
					'label' => 'Jurnal',
					'icon' => 'icon-download icon-white',
					'url' => '#',
					'htmlOptions' => array(
						'onclick' => 'simpanJurnalUmum(\'jurnal\');return false;'
					)
				),
				array(
					'label' => '',
					'items' => array(
						array(
							'label' => 'Posting',
							'icon' => 'icon-download',
							'url' => '#',
							'itemOptions' => array(
								'onclick' => 'simpanJurnalUmum(\'posting\');return false;'
							)
						),
					)
				),
			)
		));
		?>     
	</div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRincianRek',
	'options' => array(
		'title' => 'Saldo Rekening',
		'autoOpen' => false,
		'modal' => true,
		'width' => 700,
		'height' => 450,
		'resizable' => false,
	),
));

if (isset($_GET['AKRekeningakuntansiV'])) {
	$rekeningakuntansiV->attributes = $_GET['AKRekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
	$rekeningakuntansiV->nmrekening5 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
	$rekeningakuntansiV->nmrekening4 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
	$rekeningakuntansiV->nmrekening3 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
	$rekeningakuntansiV->nmrekening2 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
	$rekeningakuntansiV->nmrekening1 = $_GET['AKRekeningakuntansiV']['nmrekening5'];

	// untuk mencari kode rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
	$rekeningakuntansiV->kdrekening5 = $_GET['AKRekeningakuntansiV']['kdrekening5'];
	$rekeningakuntansiV->kdrekening4 = $_GET['AKRekeningakuntansiV']['kdrekening5'];
	$rekeningakuntansiV->kdrekening3 = $_GET['AKRekeningakuntansiV']['kdrekening5'];
	$rekeningakuntansiV->kdrekening2 = $_GET['AKRekeningakuntansiV']['kdrekening5'];
	$rekeningakuntansiV->kdrekening1 = $_GET['AKRekeningakuntansiV']['kdrekening5'];
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
	'id' => 'list-rekening-m-grid',
	'dataProvider' => $rekeningakuntansiV->cariRekening(),
	'filter' => $rekeningakuntansiV,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'No. Urut',
			'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        'filter' => CHtml::activeHiddenField($rekeningakuntansiV, 'rekening5_nb'),
		),
		array(
			'header' => 'Kode Rekening',
			'name' => 'kdrekening5',
			'value' => '$data->kdrekening5',
		),
		array(
			'header' => 'Nama',
			'name' => 'nmrekening5',
			'value' => '$data->nmrekening5',
		),
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                    array(
                        "class"=>"btn-small",
                        "onClick" =>"
                            getDataRekening(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\');
							$(\'#dialogRincianRek\').dialog(\'close\');
                            return false;
							
                        ")
                    )
                ',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		)
);
$this->endWidget();
?>
<?php echo $this->renderPartial('_jsFunctions', array('redirect' => $redirect)); ?>