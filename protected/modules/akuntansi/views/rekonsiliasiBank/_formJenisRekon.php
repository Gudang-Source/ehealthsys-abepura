<div class="span12">
	<div class="control-group">
		<?php echo CHtml::label('Jenis Rekonsiliasi Bank','',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::dropDownList('jenisrekonsiliasibank_id','', CHtml::listData(AKJenisrekonsiliasibankM::model()->findAll(),'jenisrekonsiliasibank_id','jenisrekonsiliasibank_nama'), array('empty'=>'--Pilih--','class'=>'span2','style'=>'width:150px;','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'setRekonsiliasiBank(this);'))?>
		</div>
	</div>	
</div>
<div class="span12">
	<div class="row-fluid">
		<div class="span6">
			<div class='control-group'>
				<?php // echo CHtml::hiddenField('rekening1_id','',array()); ?>
				<?php // echo CHtml::hiddenField('rekening2_id','',array()); ?>
				<?php // echo CHtml::hiddenField('rekening3_id','',array()); ?>
				<?php // echo CHtml::hiddenField('rekening4_id','',array()); ?>
				<?php echo CHtml::hiddenField('rekening5_id','',array()); ?>
				<?php echo CHtml::hiddenField('rekening5_nb','',array()); ?>
				<?php echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php
						$this->widget('MyJuiAutoComplete',
							array(
								'name' => 'rekDebit',
								'id' => 'rekDebit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ){
										return false;
									}',
									'select' => 'js:function( event, ui ){
										$(this).val(ui.item.value);
										$("#rekening1_id").val(ui.item.rekening1_id);
										$("#rekening2_id").val(ui.item.rekening2_id);
										$("#rekening3_id").val(ui.item.rekening3_id);
										$("#rekening4_id").val(ui.item.rekening4_id);
										$("#rekening5_id").val(ui.item.rekening5_id);
										$("#rekening5_nb").val("debit");
										setRekonsiliasiBankRekening();
										return false;
									}'
								),
								'htmlOptions' => array(
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'placeholder'=>'Ketikan Nama Rekening',
									'class'=>'span3',
									'style'=>'width:150px;',
								),
								'tombolDialog' => array(
									'idDialog' => 'dialogRekDebit'
								),
							)
						);
					?>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class='control-group'>
				<?php echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php
						$this->widget('MyJuiAutoComplete',
							array(
								'name' => 'rekKredit',
								'id' => 'rekKredit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ){
										return false;
									}',
									'select' => 'js:function( event, ui ){
										$(this).val(ui.item.value);  
										$("#rekening1_id").val(ui.item.rekening1_id);
										$("#rekening2_id").val(ui.item.rekening2_id);
										$("#rekening3_id").val(ui.item.rekening3_id);
										$("#rekening4_id").val(ui.item.rekening4_id);
										$("#rekening5_id").val(ui.item.rekening5_id);
										$("#rekening5_nb").val("kredit");
										setRekonsiliasiBankRekening();
										return false;
									}'
								),
								'htmlOptions' => array(
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'placeholder'=>'Ketikan Nama Rekening',
									'class'=>'span3',
									'style'=>'width:150px;',
								),
								'tombolDialog' => array(
									'idDialog' => 'dialogRekKredit'
								),
							)
						);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
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

$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
// $modRekDebit->rekening5_nb = $account;
$modRekKredit->rekening5_aktif = true;
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
	// $modRekDebit->rekening5_nb = $account;
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


$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
	'dataProvider'=>$modRekKredit->searchAccounts(),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#rekening1_id\").val($data->rekening1_id);
					$(\"#rekening2_id\").val($data->rekening2_id);
					$(\"#rekening3_id\").val($data->rekening3_id);
					$(\"#rekening4_id\").val($data->rekening4_id);
					$(\"#rekening5_id\").val($data->rekening5_id);
					$(\"#rekening5_nb\").val(\"kredit\");
					setRekonsiliasiBankRekening();
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
				'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
				'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
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
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdedit-m-grid',
	'dataProvider'=>$modRekDebit->searchAccounts(),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
							"id" => "selectRekDebit",
							"onClick" =>"
								$(\"#rekening1_id\").val($data->rekening1_id);
								$(\"#rekening2_id\").val($data->rekening2_id);
								$(\"#rekening3_id\").val($data->rekening3_id);
								$(\"#rekening4_id\").val($data->rekening4_id);
								$(\"#rekening5_id\").val($data->rekening5_id);
								$(\"#rekening5_nb\").val(\"debit\");
								setRekonsiliasiBankRekening();
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
				'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>