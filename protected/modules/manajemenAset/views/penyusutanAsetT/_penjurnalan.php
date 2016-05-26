<div class="row-fluid">
	<div class="span5">
		<div class='control-group'>
			<?php echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
					$this->widget('MyJuiAutoComplete',
						array(
							'name' => 'rekDebit',
							'id' => 'rekDebit',
							'sourceUrl' => $this->createUrl('AutocompleteRekeningAkuntansi', array('id_jenis_rek'=>'Debit')),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ){
									return false;
								}',
								'select' => 'js:function( event, ui ){
									$(this).val(ui.item.value);
									getDataRekeningFromGrid(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id, "debit");
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
		<div class='control-group'>
			<?php echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
					$this->widget('MyJuiAutoComplete',
						array(
							'name' => 'rekKredit',
							'id' => 'rekKredit',
							'sourceUrl' => Yii::app()->createUrl('AutocompleteRekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ){
									return false;
								}',
								'select' => 'js:function( event, ui ){
									$(this).val(ui.item.value);                        
									getDataRekeningFromGrid(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id, "kredit");
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
	<div class="span7">
		<table id="tblInputRekening" class="table table-striped table-condensed">
			<thead>
				<tr>
					<th width="100">Kode Rekening</th>
					<th>Nama Rekening</th>
					<th width="100">Debit</th>
					<th width="100">Kredit</th>
					<th width="50">Batal</th>
				</tr>
			</thead>
			<tbody>
				<?php // $this->renderPartial('_rowUraian',array('form'=>$form, 'modUraian'=>$modUraian)); ?>
			</tbody>
		</table>
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

$modRekKredit = new MARekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
$modRekKredit->rekening5_aktif = true;
$account = "";
if(isset($_GET['MARekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['MARekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
    /*
    $modRekKredit->nmrekening5 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening4 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening3 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening2 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening1 = $_GET['MARekeningakuntansiV']['nmrekening5'];
	/*
    $modRekKredit->nmrekeninglain5 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain4 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain3 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain2 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain1 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
         * 
         */
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
	'dataProvider'=>$modRekKredit->searchAccounts($account),
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
					getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"kredit\");
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
			'value'=>'$data->getNamaRekening()',
		), */
		array(
                        'header'=>'Saldo Normal',
                        'name'=>'rekening5_nb',
                        'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                        'filter'=>  CHtml::activeHiddenField($modRekKredit, 'rekening5_nb', array('empty'=>"-- Pilih --")),
                ),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

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

$modRekDebit = new MARekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$modRekDebit->rekening5_aktif = true;
$account = "";
if(isset($_GET['MARekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['MARekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
    /*
    $modRekDebit->nmrekening5 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekDebit->nmrekening4 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekDebit->nmrekening3 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekDebit->nmrekening2 = $_GET['MARekeningakuntansiV']['nmrekening5'];
    $modRekDebit->nmrekening1 = $_GET['MARekeningakuntansiV']['nmrekening5'];
	/*
    $modRekDebit->nmrekeninglain5 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekDebit->nmrekeninglain4 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekDebit->nmrekeninglain3 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekDebit->nmrekeninglain2 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
    $modRekDebit->nmrekeninglain1 = $_GET['MARekeningakuntansiV']['nmrekeninglain5'];
         * 
         */
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
	'dataProvider'=>$modRekDebit->searchAccounts($account),
	'filter'=>$modRekDebit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"debit\");
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
                ),
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
<script>
    function getDataRekeningFromGrid(rekening1_id,rekening2_id,rekening3_id,rekening4_id,rekening5_id,status)
    {
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('AmbilDataRekening'); ?>',
			data: {rekening1_id:rekening1_id,rekening2_id:rekening2_id,rekening3_id:rekening3_id,rekening4_id:rekening4_id,rekening5_id:rekening5_id,status:status},//
			dataType: "json",
			success:function(data){
				$("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening();
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
    }
</script>