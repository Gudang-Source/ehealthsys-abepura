<div class='control-group'>
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
//							RND-8713
//                            var data = {
//                                rekening5_id:ui.item.rekening5_id,
//                                rekening4_id:ui.item.rekening4_id,
//                                rekening3_id:ui.item.rekening3_id,
//                                rekening2_id:ui.item.rekening2_id,
//                                rekening1_id:ui.item.rekening1_id,
//                                status:"debit"
//                            };
//                            getDataRekeningFromGrid(data);
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
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ){
                            return false;
                        }',
                        'select' => 'js:function( event, ui ){
                            $(this).val(ui.item.value);
//							RND-8713
//                            var data = {
//                                rekening5_id:ui.item.rekening5_id,
//                                rekening4_id:ui.item.rekening4_id,
//                                rekening3_id:ui.item.rekening3_id,
//                                rekening2_id:ui.item.rekening2_id,
//                                rekening1_id:ui.item.rekening1_id,
//                                status:"kredit"
//                            };
//                            getDataRekeningFromGrid(data);   
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
<table id="tblInputRekening" class="table table-striped table-condensed" widht="450">
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
    </tbody>
</table>

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

$modRekKredit = new AKRekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
//$account = "K";
$account = "";
if(isset($_GET['AKRekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['AKRekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
    $modRekKredit->nmrekening5 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening4 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening3 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening2 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening1 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
	
    $modRekKredit->nmrekeninglain5 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain4 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain3 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain2 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain1 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
        // 'mergeHeaders'=>array(
        //     array(
        //         'name'=>'<center>Kode Rekening</center>',
        //         'start'=>1, //indeks kolom 3
        //         'end'=>5, //indeks kolom 4
        //     ),
        // ),
	'columns'=>array(
		array(
			 'name'=>'nourutrek',
			 'header'=>'No. Urut',
			 'value'=>'$data->nourutrek',
		 ),
		 array(
			 'name'=>'kdrekening1',
			 'header'=>'Rek. 1',
			 'value'=>'$data->kdrekening1',
		 ),
		 array(
			 'name'=>'kdrekening2',
			 'header'=>'Rek. 2',
			 'value'=>'$data->kdrekening2',
		 ),
		 array(
			 'name'=>'kdrekening3',
			 'header'=>'Rek. 3',
			 'value'=>'$data->kdrekening3',
		 ),
		 array(
			 'name'=>'kdrekening4',
			 'header'=>'Rek. 4',
			 'value'=>'$data->kdrekening4',
		 ),
		 array(
			 'name'=>'kdrekening5',
			 'header'=>'Rek. 5',
			 'value'=>'$data->kdrekening5',
		 ),
		 array(
			 'name'=>'nmrekening5',
			 'header'=>'Nama Rekening',
			 'value'=>'$data->getNamaRekening()',
		 ),
		 array(
			 'name'=>'nmrekeninglain5',
			 'header'=>'Nama Lain',
			 'value'=>'$data->getNamaRekening()',

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
//				RND-8713
//					var data = {
//						rekening5_id:$data->rekening5_id,
//						rekening4_id:$data->rekening4_id,
//						rekening3_id:$data->rekening3_id,
//						rekening2_id:$data->rekening2_id,
//						rekening1_id:$data->rekening1_id,
//						status:\"kredit\"
//					};
//					getDataRekeningFromGrid(data);
					getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"kredit\");
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

$modRekKredit = new AKRekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
//$account = "D";
$account = "";
if(isset($_GET['AKRekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['AKRekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
    $modRekKredit->nmrekening5 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening4 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening3 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening2 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
    $modRekKredit->nmrekening1 = $_GET['AKRekeningakuntansiV']['nmrekening5'];
	
    $modRekKredit->nmrekeninglain5 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain4 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain3 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain2 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
    $modRekKredit->nmrekeninglain1 = $_GET['AKRekeningakuntansiV']['nmrekeninglain5'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdedit-m-grid',
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			 'name'=>'nourutrek',
			 'header'=>'No. Urut',
			 'value'=>'$data->nourutrek',
		 ),
		 array(
			 'name'=>'kdrekening1',
			 'header'=>'Rek. 1',
			 'value'=>'$data->kdrekening1',
		 ),
		 array(
			 'name'=>'kdrekening2',
			 'header'=>'Rek. 2',
			 'value'=>'$data->kdrekening2',
		 ),
		 array(
			 'name'=>'kdrekening3',
			 'header'=>'Rek. 3',
			 'value'=>'$data->kdrekening3',
		 ),
		 array(
			 'name'=>'kdrekening4',
			 'header'=>'Rek. 4',
			 'value'=>'$data->kdrekening4',
		 ),
		 array(
			 'name'=>'kdrekening5',
			 'header'=>'Rek. 5',
			 'value'=>'$data->kdrekening5',
		 ),
		 array(
			 'name'=>'nmrekening5',
			 'header'=>'Nama Rekening',
			 'value'=>'$data->getNamaRekening()',
		 ),
		 array(
			 'name'=>'nmrekeninglain5',
			 'header'=>'Nama Lain',
			 'value'=>'$data->getNamaRekening()',

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
//							RND-8713
//								var data = {
//									rekening5_id:$data->rekening5_id,
//									rekening4_id:$data->rekening4_id,
//									rekening3_id:$data->rekening3_id,
//									rekening2_id:$data->rekening2_id,
//									rekening1_id:$data->rekening1_id,
//									status:\"debit\"
//								};
//								getDataRekeningFromGrid(data);
								getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"debit\");
								$(\"#dialogRekDebit\").dialog(\"close\");    
								return false;
					"))',
		),
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
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