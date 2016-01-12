<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'bank-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
        <table>
            <tr>
                <td>
					<div class='control-group'>
						<?php echo $form->labelEx($model,'bank_id', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->hiddenField($model,'bank_id',array('class'=>'span3','maxlength'=>50));  ?>
							<?php
								$this->widget('MyJuiAutoComplete', array(
									'model' => $model,
									'attribute' => 'namaBank',
									'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/bank'),
									'options' => array(
										'showAnim' => 'fold',
										'minLength' => 2,
										'focus' => 'js:function( event, ui ) {
												$(this).val(ui.item.namabank);
												return false;
											}',
										'select' => 'js:function( event, ui ) {
														$(this).val(ui.item.namabank);
														$("#' . CHtml::activeId($model, 'bank_id') . '").val(ui.item.bank_id);
															return false;
													}'
									),
									'htmlOptions' => array(
										'onkeypress' => "return $(this).focusNextInputField(event)",
										'placeholder'=>'Ketikan Nama Bank',
										'class'=>'span3',
										'style'=>'width:150px;',
									),
									'tombolDialog' => array('idDialog' => 'dialogBank',),
								));
							?>
						</div>
					</div>
                    
					<div class='control-group'>
							<?php echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening5_nb]','D', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening5_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening4_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening3_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening2_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][1][rekening1_id]','', array('readonly'=>true));  ?>
							<?php
								$this->widget('MyJuiAutoComplete', array(
									'model' => $model,
									'attribute' => 'rekDebit',
									'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
									'options' => array(
										'showAnim' => 'fold',
										'minLength' => 2,
										'focus' => 'js:function( event, ui ) {
												$(this).val(ui.item.nmrekening5);
												return false;
											}',
										'select' => 'js:function( event, ui ) {
														$(this).val(ui.item.nmrekening5);
														$("#SABankRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
														$("#SABankRekM_rekening_1_rekening4_id").val(ui.item.rekening4_id);
														$("#SABankRekM_rekening_1_rekening3_id").val(ui.item.rekening3_id);
														$("#SABankRekM_rekening_1_rekening2_id").val(ui.item.rekening2_id);
														$("#SABankRekM_rekening_1_rekening1_id").val(ui.item.rekening1_id);
															return false;
													  }'
									),
									'htmlOptions' => array(
										'onkeypress' => "return $(this).focusNextInputField(event)",
										'placeholder'=>'Ketikan Nama Rekening',
										'class'=>'span3',
										'style'=>'width:150px;',
									),
									'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
								));
							?>
						</div>
					</div>
                    
					<div class='control-group'>
						<?php echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening5_nb]','K', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening5_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening4_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening3_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening2_id]','', array('readonly'=>true));  ?>
							<?php echo CHtml::hiddenField('SABankRekM[rekening][2][rekening1_id]','', array('readonly'=>true));  ?>
							<?php
								$this->widget('MyJuiAutoComplete', array(
									'model' => $model,
									'attribute' => 'rekKredit',
									'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
									'options' => array(
										'showAnim' => 'fold',
										'minLength' => 2,
										'focus' => 'js:function( event, ui ) {
												$(this).val(ui.item.nmrekening5);
												return false;
											}',
										'select' => 'js:function( event, ui ) {
														$(this).val(ui.item.nmrekening5);
														 $("#SABankRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
														 $("#SABankRekM_rekening_2_rekening4_id").val(ui.item.rekening4_id);
														 $("#SABankRekM_rekening_2_rekening3_id").val(ui.item.rekening3_id);
														 $("#SABankRekM_rekening_2_rekening2_id").val(ui.item.rekening2_id);
														 $("#SABankRekM_rekening_2_rekening1_id").val(ui.item.rekening1_id);
															return false;
													  }'
									),
									'htmlOptions' => array(
										'onkeypress' => "return $(this).focusNextInputField(event)",
										'placeholder'=>'Ketikan Nama Rekening',
										'class'=>'span3',
										'style'=>'width:150px;',
									),
									'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
								));
							?>
						</div>
					</div>
                </td>
            </tr>
        </table>
        
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/Bank/admin'), 
					array('class'=>'btn btn-danger',
						'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		
		<?php
			$content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
	</div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));
$account = "D";

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$modRekDebit->rekening5_nb = $account;
//$account = "D";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
	$modRekDebit->rekening5_nb = $account;
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchAccounts($account),
	'filter'=>$modRekDebit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Kode Rekening</center>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//            array(
//                'name'=>'<center>Saldo Normal</center>',
//                'start'=>8, //indeks kolom 3
//                'end'=>9, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
			'header'=>'Rek. 1',
			'name'=>'kdrekening1',
			'value'=>'$data->kdrekening1',
		),
		array(
			'header'=>'Rek. 2',
			'name'=>'kdrekening2',
			'value'=>'$data->kdrekening2',
		),
		array(
			'header'=>'Rek. 3',
			'name'=>'kdrekening3',
			'value'=>'$data->kdrekening3',
		),
		array(
			'header'=>'Rek. 4',
			'name'=>'kdrekening4',
			'value'=>'$data->kdrekening4',
		),
		array(
			'header'=>'Rek. 5',
			'name'=>'kdrekening5',
			'value'=>'$data->kdrekening5',
		),
		array(
			'header'=>'Nama Rekening',
			'name'=>'nmrekening5',
			'value'=>'$data->nmrekening5',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		),
		array(
			'header'=>'Saldo Normal',
			'value'=>'$data->rekening5_nb',
		),

		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#SABankRekM_rekening_1_rekening5_id\").val(\"$data->rekening5_id\");
					$(\"#SABankRekM_rekening_1_rekening4_id\").val(\"$data->rekening4_id\");
					$(\"#SABankRekM_rekening_1_rekening3_id\").val(\"$data->rekening3_id\");
					$(\"#SABankRekM_rekening_1_rekening2_id\").val(\"$data->rekening2_id\");
					$(\"#SABankRekM_rekening_1_rekening1_id\").val(\"$data->rekening1_id\");
					$(\"#SABankRekM_rekDebit\").val(\"$data->nmrekening5\");                                                
					$(\"#dialogRekDebit\").dialog(\"close\");    
					return false;
			"))',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
        
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));
$account = "K";

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
$modRekKredit->rekening5_nb = $account;
//$account = "K";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
	$modRekKredit->rekening5_nb = $account;
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Kode Rekening</center>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
			'header'=>'Rek. 1',
			'name'=>'kdrekening1',
			'value'=>'$data->kdrekening1',
		),
		array(
			'header'=>'Rek. 2',
			'name'=>'kdrekening2',
			'value'=>'$data->kdrekening2',
		),
		array(
			'header'=>'Rek. 3',
			'name'=>'kdrekening3',
			'value'=>'$data->kdrekening3',
		),
		array(
			'header'=>'Rek. 4',
			'name'=>'kdrekening4',
			'value'=>'$data->kdrekening4',
		),
		array(
			'header'=>'Rek. 5',
			'name'=>'kdrekening5',
			'value'=>'$data->kdrekening5',
		),
		array(
			'header'=>'Nama Rekening',
			'name'=>'nmrekening5',
			'value'=>'$data->nmrekening5',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		),
		array(
			'header'=>'Saldo Normal',
			'value'=>'$data->rekening5_nb',
		),

		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#SABankRekM_rekening_2_rekening5_id\").val(\"$data->rekening5_id\");
					$(\"#SABankRekM_rekening_2_rekening4_id\").val(\"$data->rekening4_id\");
					$(\"#SABankRekM_rekening_2_rekening3_id\").val(\"$data->rekening3_id\");
					$(\"#SABankRekM_rekening_2_rekening2_id\").val(\"$data->rekening2_id\");
					$(\"#SABankRekM_rekening_2_rekening1_id\").val(\"$data->rekening1_id\");
					$(\"#SABankRekM_rekKredit\").val(\"$data->nmrekening5\");
					$(\"#dialogRekKredit\").dialog(\"close\");    
					return false;
			"))',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBank',
    'options'=>array(
        'title'=>'Daftar Bank',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modBank = new BankM('search');
$modBank->unsetAttributes();
if(isset($_GET['BankM'])) {
    $modBank->attributes = $_GET['BankM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'bank-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modBank->searchBank(),
	'filter'=>$modBank,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No. Urut',
			'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
		),
		array(
			'header'=>'Nama Bank ',
			'value'=>'$data->namabank',
		),
		array(
			'header'=>'Mata Uang',
			'value'=>' isset($data->matauang->matauang) ? $data->matauang->matauang : ""',
		),
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBank",
				"onClick" =>"
					$(\"#SABankRekM_bank_id\").val(\"$data->bank_id\");
					$(\"#SABankRekM_namaBank\").val(\"$data->namabank\");
					$(\"#dialogBank\").dialog(\"close\");    
					return false;
			"))',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
