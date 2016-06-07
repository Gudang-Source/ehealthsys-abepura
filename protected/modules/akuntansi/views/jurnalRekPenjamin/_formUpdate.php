<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penjaminpasien-m-form',
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
                                <div class="control-group">
                                        <?php echo $form->textFieldRow($modPenjamin,'penjamin_nama', array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); 
                                        ?>
				</div> 
                        </td>
			<td>
				

				<div class='control-group'>
					<?php echo $form->labelEx($modPenjamin,'rekening_debit', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php 
                                                if (!empty($model["D"])) $modPenjamin->rekening_debit = $model["D"]->rekening5_id;
                                                echo $form->hiddenField($modPenjamin,'rekening_debit',array('class'=>'span3','maxlength'=>50));  ?>
						<?php
                                                        //var_dump($model["D"]->rekeningdebit->nmrekening5); die;
                                                        if (!empty($model["D"]->rekeningdebit)) $modPenjamin->rekDebit = $model["D"]->rekeningdebit->nmrekening5;
							$this->widget('MyJuiAutoComplete', array(
								'model' => $modPenjamin,
								'attribute' => 'rekDebit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmrekening1);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrekening5);
													$("#' . CHtml::activeId($model["D"], 'rekening_debit') . '").val(ui.item.rekening5_id);
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
					<?php echo $form->labelEx($modPenjamin,'rekeningKredit', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php 
                                                if (!empty($model["K"])) $modPenjamin->rekeningKredit = $model["K"]->rekening5_id;
                                                if (!empty($model["K"]->rekeningkredit)) $modPenjamin->rekKredit = $model["K"]->rekeningkredit->nmrekening5;
                                                echo $form->hiddenField($modPenjamin,'rekeningKredit',array('class'=>'span3','maxlength'=>50));  ?>
						<?php
                                                        
							$this->widget('MyJuiAutoComplete', array(
								'model' => $modPenjamin,
								'attribute' => 'rekKredit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmrekening1);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrekening5);
													$("#' . CHtml::activeId($modPenjamin, 'rekening_debit') . '").val(ui.item.rekening5_id);
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
		<?php 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
		?>
		<?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/jurnalRekPenjamin/admin'), 
					array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
		?>
		<?php
			$content = $this->renderPartial('../tips/transaksi',array(),true);
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
        'width'=>700,
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
					$(\"#AKPenjaminpasienM_rekening_debit\").val(\"$data->rekening5_id\");
					$(\"#AKPenjaminpasienM_rekDebit\").val(\"$data->nmrekening5\");                                                
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
        'width'=>600,
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
	'id'=>'rekredit-m-grid',
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
					$(\"#AKPenjaminpasienM_rekeningKredit\").val(\"$data->rekening5_id\");
					$(\"#AKPenjaminpasienM_rekKredit\").val(\"$data->nmrekening5\");
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