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
				<?php echo $form->textFieldRow($model, 'nobku', array('class' => 'span3  numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 32, 'readonly' => false)); ?>
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

$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
// $modRekDebit->rekening5_nb = $account;
$modRekDebit->rekening5_aktif = true;
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
	// $modRekDebit->rekening5_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
	'id' => 'list-rekening-m-grid',
	'dataProvider' => $modRekDebit->searchAccounts(),
	'filter' => $modRekDebit,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
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
		array(
				'header' => 'Kode Akun',
				'name' => 'kdrekening5',
				'value' => '$data->kdrekening5',
		),
		array(
				'header'=>'Kelompok Akun',
				'type'=>'raw',
				'value'=>function($data) {
					$rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
					$rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
					return $rek2->namakelrekening;
				},
				'filter'=>CHtml::activeDropDownList($modRekDebit, 'kelrekening_id', CHtml::listData(
			   KelrekeningM::model()->findAll(array(
				   'condition'=>'kelrekening_aktif = true',
				   'order'=>'koderekeningkel',
			   )), 'kelrekening_id', 'namakelrekening'
				), array('empty'=>'-- Pilih --')),
		),
		array(
				'header'=>'Komponen',
				'name'=>'rekening1_id',
				'value'=>'$data->nmrekening1',
				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening1_id', 
				CHtml::listData(Rekening1M::model()->findAll(array(
					'condition'=>'rekening1_aktif = true',
					'order'=>'kdrekening1 asc',
				)), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
		),
		array(
				'header'=>'Unsur',
				'name'=>'rekening2_id',
				'value'=>'$data->nmrekening2',
				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening2_id', 
				CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
		),
		array(
				'header'=>'Kelompok Pos',
				'name'=>'rekening3_id',
				'value'=>'$data->nmrekening3',
				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening3_id', 
				CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
		),
		array(
				'header'=>'Pos',
				'name'=>'rekening4_id',
				'value'=>'$data->nmrekening4',
				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening4_id', 
				CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
		),
		array(
				'header' => 'Akun',
				'name' => 'nmrekening5',
				'value' => '$data->nmrekening5',
		), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
		array(
				'header'=>'Saldo Normal',
				'name'=>'rekening5_nb',
				'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		)
);
$this->endWidget();
?>
<?php echo $this->renderPartial('_jsFunctions', array('redirect' => $redirect)); ?>