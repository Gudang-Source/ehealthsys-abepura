<?php
/**
 * form ini digunakan di:
 * - akuntansi/fakturPembelianGU
 */
?>
<legend class="rim">Jurnal Rekening Faktur</legend>
<div id="formJurnalRekeningKasir" class="grid-view">
<table id="tblInputRekening" class="table table-bordered table-condensed"  width="100%" style="overflow-x: scroll;">
    <thead>
        <tr>
            <!--<th width="10">No.</th>-->
            <th colspan="5" width="50">Kode Rekening</th>
            <th>Nama Rekening</th>
            <th width="50">Debit</th>
            <th width="50">Kredit</th>
            <th width="10">Tindakan</th>
        </tr>
    </thead>
    <tbody>
    <?php  
//        $modRekenings[0]=new RekeningpembayarankasirV(); //<<untuk menampilkan baris pertama blank
        $this->renderPartial('akuntansi.views.fakturPembelianGU.rekening._rowRekening',array('form'=>$form, 'modRekenings'=>$modRekenings)); ?>
    </tbody>
</table>
</div>
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebitKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit dan Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));
echo CHtml::hiddenField('row',0,array('readonly'=>true)); //untuk mencatat asal baris di klik
$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
//    $modRekKredit->rincianobyek_nb = $_GET['RekeningakuntansiV']['rincianobyek_nb'];
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkreditdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts(),
	'filter'=>$modRekKredit,
	'template'=>"{pager}{summary}\n{items}",
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
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebitKredit",
				"onClick" =>"
					var data = {
						rincianobyek_id:$data->rincianobyek_id,
						obyek_id:$data->obyek_id,
						jenis_id:$data->jenis_id,
						kelompok_id:$data->kelompok_id,
						struktur_id:$data->struktur_id,
						nmrincianobyek:\"$data->nmrincianobyek\",
						kdstruktur:\"$data->kdstruktur\",
						kdkelompok:\"$data->kdkelompok\",
						kdjenis:\"$data->kdjenis\",
						kdobyek:\"$data->kdobyek\",
						kdrincianobyek:\"$data->kdrincianobyek\",
						saldodebit:\"$data->saldodebit\",
						saldokredit:\"$data->saldokredit\",
						status:\"debit\"
					};
					var row = $(\"#dialogRekDebitKredit #row\").val();
					editDataRekeningFromGrid(data, row);
					$(\"#dialogRekDebitKredit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
			'header'=>'No. Urut',
			'value'=>'$data->nourutrek',
		),
		array(
			'header'=>'Rek. 1',
			'name'=>'kdstruktur',
			'value'=>'$data->kdstruktur',
		),
		array(
			'header'=>'Rek. 2',
			'name'=>'kdkelompok',
			'value'=>'$data->kdkelompok',
		),
		array(
			'header'=>'Rek. 3',
			'name'=>'kdjenis',
			'value'=>'$data->kdjenis',
		),
		array(
			'header'=>'Rek. 4',
			'name'=>'kdobyek',
			'value'=>'$data->kdobyek',
		),
		array(
			'header'=>'Rek. 5',
			'name'=>'kdrincianobyek',
			'value'=>'$data->kdrincianobyek',
		),
		array(
			'header'=>'Nama Rekening',
			'name'=>'nmrincianobyek',
			'value'=>'$data->nmrincianobyek',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrincianobyeklain',
			'value'=>'$data->nmrincianobyeklain',
		),
		array(
			'header'=>'Saldo Normal',
			'name'=>'rincianobyek_nb',
			'value'=>'$data->rincianobyek_nb',
			'filter'=>  CHtml::dropDownList('RekeningakuntansiV[rincianobyek_nb]', $modRekKredit->rincianobyek_nb, array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>'-- Pilih --', 'style'=>'width:64px;'))
		),  
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
<?php $this->renderPartial('akuntansi.views.fakturPembelianGU.rekening._jsFunctions',array('form'=>$form, 'modRekenings'=>$modRekenings)); ?>
