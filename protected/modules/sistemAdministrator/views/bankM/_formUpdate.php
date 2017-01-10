<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'bank-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
	'focus' => '#AKBankM_propinsi_id',
		));
?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

<table width='100%'>
	<tr>
		<td>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
						'ajax' => array('type' => 'POST',
							'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
							'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
						),
						'onchange' => "",));
					?>
					<?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
					  array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
					  'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
					  'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('propinsi_id'))) */ ?>
<?php echo $form->error($model, 'propinsi_id'); ?>
				</div>
			</div>
			<div class="control-group ">
					<?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
						'ajax' => array('type' => 'POST',
							'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
							'update' => "#" . CHtml::activeId($model, 'kecamatan_id'),
						),
						'onchange' => "",));
					?>
					<?php /* RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
					  array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialog-addkabupaten').dialog('open');}",
					  'id'=>'btn-addkabupaten','onkeyup'=>"return $(this).focusNextInputField(event)",
					  'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('kabupaten_id'))) */ ?>
<?php echo $form->error($model, 'kabupaten_id'); ?>
				</div>
			</div>


			<div class='control-group'>
					<?php echo $form->labelEx($model, 'kodepos', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'kodepos', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'negara', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'negara', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'matauang_id', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->dropDownList($model, 'matauang_id', CHtml::listData(MatauangM::model()->findAll(), 'matauang_id', 'matauang'), array('style' => 'width:160px;', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"));
?>
				</div>
			</div>  
		</td>
		<td>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'namabank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'namabank', array('placeholder' => 'Nama Bank', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
				</div>
			</div>  

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'norekening', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'norekening', array('placeholder' => 'No. Rekening', 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div>  

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'alamatbank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textArea($model, 'alamatbank', array('placeholder' => 'Alamat Bank', 'rows' => 3, 'cols' => 30, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:150px;')); ?>
				</div>
			</div>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'telpbank1', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'telpbank1', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div>
			<div class='control-group'>
					<?php echo $form->labelEx($model, 'telpbank2', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'telpbank2', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'faxbank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'faxbank', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;text-align:right;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'emailbank', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'emailbank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'website', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'website', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'cabangdari', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($model, 'cabangdari', array('class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'style' => 'width:150px;')); ?>
				</div>
			</div> 

			<div class='control-group'>
					<?php echo $form->labelEx($model, 'bank_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->checkBox($model, 'bank_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</td>
		<td>     
			<div class='control-group'>
				<?php echo $form->labelEx($model,'rekening debit', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('SABankM[rekening][1][rekening5_nb]','D',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][1][rekening5_id]',$modeld->rekening5_id,array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][1][rekening4_id]','',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][1][rekening3_id]','',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][1][rekening2_id]','',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][1][rekening1_id]','',array('class'=>'span3'));  ?>
					<?php
						if (!empty($modeld->rekening5_id)) $model->rekDebit = $modeld->rekeningdebit->nmrekening5;
						$this->widget('MyJuiAutoComplete', array(
							'model' => $model,
							'attribute' => 'rekDebit',
							'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiDebit'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ) {
										$(this).val(ui.item.nmrekening5);
										return false;
									}',
								'select' => 'js:function( event, ui ) {
												$(this).val(ui.item.nmrekening5);
												$("#SABankM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
												$("#SABankM_rekening_1_rekening4_id").val(ui.item.rekening4_id);
												$("#SABankM_rekening_1_rekening3_id").val(ui.item.rekening3_id);
												$("#SABankM_rekening_1_rekening2_id").val(ui.item.rekening2_id);
												$("#SABankM_rekening_1_rekening1_id").val(ui.item.rekening1_id);
													return false;
											  }'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder'=>'Ketikan Nama Rekening',
								'class'=>'span3',
								'style'=>'width:150px;',
								'onblur'=>'cekRekeningKosong(1);',
							),
							'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
						));
					?>
				</div>
			</div>
			
			<div class='control-group'>
				<?php echo $form->labelEx($model,'rekening kredit', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('SABankM[rekening][2][rekening5_nb]','K',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][2][rekening5_id]',$modelk->rekening5_id,array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][2][rekening4_id]','',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][2][rekening3_id]','',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][2][rekening2_id]','',array('class'=>'span3'));  ?>
					<?php echo CHtml::hiddenField('SABankM[rekening][2][rekening1_id]','',array('class'=>'span3'));  ?>
					<?php
						if (!empty($modelk->rekening5_id)) $model->rekKredit = $modelk->rekeningkredit->nmrekening5;
					
						$this->widget('MyJuiAutoComplete', array(
							'model' => $model,
							'attribute' => 'rekKredit',
							'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiKredit'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ) {
										$(this).val(ui.item.nmrekening5);
										return false;
									}',
								'select' => 'js:function( event, ui ) {
												$(this).val(ui.item.nmrekening5);
												$("#SABankM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
												$("#SABankM_rekening_2_rekening4_id").val(ui.item.rekening4_id);
												$("#SABankM_rekening_2_rekening3_id").val(ui.item.rekening3_id);
												$("#SABankM_rekening_2_rekening2_id").val(ui.item.rekening2_id);
												$("#SABankM_rekening_2_rekening1_id").val(ui.item.rekening1_id);
													return false;
											  }'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder'=>'Ketikan Nama Rekening',
								'class'=>'span3',
								'style'=>'width:150px;',
								'onblur'=>'cekRekeningKosong(2);',
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
	<?php
	echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
					Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
	?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
//                                    Yii::app()->createUrl($this->module->id.'/bankM/admin'), 
			'javascript:void(0);', array('class' => 'btn btn-danger',
//                                            'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;'));
		'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Bank',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
<?php
$content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
</div>

<?php $this->endWidget(); ?>

<script>
function cekRekeningKosong(r) {
	if ($("#SABankM_rekDebit").val().trim() === "") {
		$("#SABankM_rekening_1_rekening5_id").val(null);
		$("#SABankM_rekening_1_rekening4_id").val(null);
		$("#SABankM_rekening_1_rekening3_id").val(null);
		$("#SABankM_rekening_1_rekening2_id").val(null);
		$("#SABankM_rekening_1_rekening1_id").val(null);
	}
	
	if ($("#SABankM_rekKredit").val().trim() === "") {
		$("#SABankM_rekening_2_rekening5_id").val(null);
		$("#SABankM_rekening_2_rekening4_id").val(null);
		$("#SABankM_rekening_2_rekening3_id").val(null);
		$("#SABankM_rekening_2_rekening2_id").val(null);
		$("#SABankM_rekening_2_rekening1_id").val(null);
	}
}
</script>

<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));
$account = "D";

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

$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchAccounts(),
	'filter'=>$modRekDebit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeHeaders'=>array(
            /*
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ), */
//            array(
//                'name'=>'<center>Saldo Normal</center>',
//                'start'=>8, //indeks kolom 3
//                'end'=>9, //indeks kolom 4
//            ),
        ),
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#SABankM_rekening_1_rekening5_id\").val(\"$data->rekening5_id\");
                                                $(\"#SABankM_rekening_1_rekening4_id\").val(\"$data->rekening4_id\");
                                                $(\"#SABankM_rekening_1_rekening3_id\").val(\"$data->rekening3_id\");
                                                $(\"#SABankM_rekening_1_rekening2_id\").val(\"$data->rekening2_id\");
                                                $(\"#SABankM_rekening_1_rekening1_id\").val(\"$data->rekening1_id\");
                                                $(\"#SABankM_rekDebit\").val(\"$data->nmrekening5\");                                                
                                                $(\"#dialogRekDebit\").dialog(\"close\");    
                                                return false;
                            "))',
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
                        'filter'=>  CHtml::activeHiddenField($modRekDebit, 'rekening5_nb', array('empty'=>"-- Pilih --")),
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
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));
$account = "K";

$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
// $modRekKredit->rekening5_nb = $account;
$modRekKredit->rekening5_aktif = true;

if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
	// $modRekKredit->rekening5_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts(),
	'filter'=>$modRekKredit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    /*
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
        ),
     * 
     */
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#SABankM_rekening_2_rekening5_id\").val(\"$data->rekening5_id\");
                                                $(\"#SABankM_rekening_2_rekening4_id\").val(\"$data->rekening4_id\");
                                                $(\"#SABankM_rekening_2_rekening3_id\").val(\"$data->rekening3_id\");
                                                $(\"#SABankM_rekening_2_rekening2_id\").val(\"$data->rekening2_id\");
                                                $(\"#SABankM_rekening_2_rekening1_id\").val(\"$data->rekening1_id\");
                                                $(\"#SABankM_rekKredit\").val(\"$data->nmrekening5\");
                                                $(\"#dialogRekKredit\").dialog(\"close\");    
                                                return false;
                            "))',
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
                        'filter'=>CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
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
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Unsur',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Kelompok Pos',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Pos',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
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
                        'value'=>'($data->rekening5_nb == "K") ? "Kredit" : "Debit"',
                        'filter'=>  CHtml::activeHiddenField($modRekKredit, 'rekening5_nb', array('empty'=>"-- Pilih --")),
                ),
            
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>