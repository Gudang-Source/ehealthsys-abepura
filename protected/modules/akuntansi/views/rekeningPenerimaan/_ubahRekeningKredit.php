<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'jenispengeluaran-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'verifikasi();'),
	'focus' => '#',
		));
?>

<div class='divForForm'>
</div>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table>
	<tr>
		<td>
			<div class='control-group'>
					<?php echo CHtml::label('Jenis Penerimaan', '', array('class' => 'control-label')) ?>
				<div class="controls">
<?php echo $form->textField($modPenerimaan, 'jenispenerimaan_nama', array()); ?>
				</div>
			</div>
			<div class='control-group'>
					<?php echo CHtml::label('Rekening Kredit', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('kredit', $model->rekeningkredit->nmrekening5, array()); ?>
					<?php echo CHtml::hiddenField('rekening5_id', $model->rekening5_id, array()); ?>

<?php echo CHtml::hiddenField('jenispenerimaan_id', $model->jenispenerimaan_id, array()); ?>
<?php echo CHtml::hiddenField('jnspenerimaanrek_id', $model->jnspenerimaanrek_id, array()); ?>
				</div>
			</div>
		</td>
	</tr>
</table>
<?php $this->endWidget(); ?>
<div class="block-tabel">
    <h6>Checklist Untuk <b>Ubah Rekening Kredit</b></h6>
    <div style="width:100%;">
		<?php
		$modRekKredit = new RekeningakuntansiV('searchKredit');
		$modRekKredit->unsetAttributes();
//            $account = "K";
		$account = "";
		if (isset($_GET['RekeningakuntansiV'])) {
			$modRekKredit->attributes = $_GET['RekeningakuntansiV'];
		}
//            $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'rekkredit-m-grid',
			//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
			'dataProvider' => $modRekKredit->searchAccounts($account),
			'filter' => $modRekKredit,
			'template' => "{summary}\n{items}\n{pager}",
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
			//                    'mergeHeaders'=>array(
			//                        array(
			//                            'name'=>'<center>Kode Rekening</center>',
			//                            'start'=>1, //indeks kolom 3
			//                            'end'=>5, //indeks kolom 4
			//                        ),
			//                    ),
			'columns' => array(
				array(
					'header' => 'No. Urut',
					'name' => 'nourutrek',
					'value' => '$data->nourutrek',
				),
				array(
					'header' => 'Rek. 1',
					'name' => 'kdrekening1',
					'value' => '$data->kdrekening1',
				),
				array(
					'header' => 'Rek. 2',
					'name' => 'kdrekening2',
					'value' => '$data->kdrekening2',
				),
				array(
					'header' => 'Rek. 3',
					'name' => 'kdrekening3',
					'value' => '$data->kdrekening3',
				),
				array(
					'header' => 'Rek. 4',
					'name' => 'kdrekening4',
					'value' => '$data->kdrekening4',
				),
				array(
					'header' => 'Rek. 5',
					'name' => 'kdrekening5',
					'value' => '$data->kdrekening5',
				),
				array(
					'header' => 'Nama Rekening',
					'name' => 'nmrekening5',
					'type' => 'raw',
					'value' => '$data->nmrekening5 == "" ?  "-" : $data->nmrekening5',
				),
				array(
					'header' => 'Nama Lain',
					'name' => 'nmrekeninglain5',
					'value' => '($data->nmrekeninglain5 == "" ? "-" : $data->nmrekeninglain5)))))',
				),
				array(
					'header' => 'Saldo Normal',
					'name' => 'rekening5_nb',
					'value' => '($data->rekening5_nb == "K") ? "Kredit" : "Debit"',
				),
				array(
					'header' => 'Pilih',
					'type' => 'raw',
					'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("style"=>"text-align:left;", 
								"id" => "selectRekKredit",
								"onClick" =>"
									$(\"#rekening5_id\").val(\"$data->rekening5_id\");
									$(\"#rekening4_id\").val(\"$data->rekening4_id\");
									$(\"#rekening3_id\").val(\"$data->rekening3_id\");
									$(\"#rekening2_id\").val(\"$data->rekening2_id\");
									$(\"#rekening1_id\").val(\"$data->rekening1_id\");
									$(\"#kredit\").val(\"$data->namaRekening\");  
									$(\"#rekening5_nb\").val(\"$data->rekening5_nb\");
									saveKredit();
									return false;
						"))',
				),
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
    </div>
</div>
<script>
	function verifikasi() {
		myConfirm("<?php echo Yii::t('mds', 'Yakin Anda akan Ubah Data Rekening?') ?>", 'Perhatian!', function (r) {
			if (r)
			{
				$('#dialogUbahRekeningDebitKredit').dialog('close');
			}
			else
			{
				$('#submit').submit();
				return false;
			}
		});
	}
</script>
<?php
$urlEditKredit = Yii::app()->createUrl('akuntansi/RekeningPenerimaan/getRekeningEditKreditPenerimaan'); //MAsukan Dengan memilih Rekening
$mds = Yii::t('mds', 'Anda yakin akan ubah data rekening kredit ?');
$jscript = <<< JS

function saveKredit()
{
    rekening1_id = $('#rekening1_id').val();
    rekening2_id = $('#rekening2_id').val();
    rekening3_id = $('#rekening3_id').val();
    rekening4_id = $('#rekening4_id').val();
    rekening5_id = $('#rekening5_id').val();
    rekening5_nb = $('#rekening5_nb').val();
    jenispenerimaan_id = $('#jenispenerimaan_id').val();
    jnspenerimaanrek_id = $('#jnspenerimaanrek_id').val();

    myConfirm("${mds}",'Perhatian!',function(r){
        if(r)
        {
            $.post("${urlEditKredit}", {rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, jenispenerimaan_id:jenispenerimaan_id, rekening5_nb:rekening5_nb,jnspenerimaanrek_id:jnspenerimaanrek_id},
                function(data){
                    $('.divForForm').html(data.pesan);
                    setTimeout(function(){
                        $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
                        return true;
                    },500);
            }, "json");
        }
    });
}
    
JS;
Yii::app()->clientScript->registerScript('jenispenerimaan', $jscript, CClientScript::POS_HEAD);
?>