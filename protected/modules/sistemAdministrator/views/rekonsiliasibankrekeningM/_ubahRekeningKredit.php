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
			<div class="control-group">
					<?php echo CHtml::label('Cara Bayar', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($modPengeluaran, 'jenisrekonsiliasibank_id', CHtml::listData($modPengeluaran->getJenisRekonItems(), 'jenisrekonsiliasibank_id', 'jenisrekonsiliasibank_nama'), array('empty' => '-- Pilih --', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)",
						'ajax' => array('type' => 'POST',
							'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => 'AKPenjaminpasienM')),
							'update' => '#' . CHtml::activeId($modPengeluaran, 'jenisrekonsiliasibank_id') . ''  //selector to update
						),
					));
					?>
				</div>
			</div>
			<div class='control-group'>
					<?php echo CHtml::label('Rekening Kredit', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('kredit', $model->rekeningkredit->nmrekening5, array()); ?>
					<?php echo CHtml::hiddenField('rekening5_id', $model->rekening5_id, array()); ?>
					<?php echo CHtml::hiddenField('jenisrekonsiliasibank_id', $model->jenisrekonsiliasibank_id, array()); ?>
<?php echo CHtml::hiddenField('rekonsiliasibankrekening_id', $model->rekonsiliasibankrekening_id, array()); ?>
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
		$account = "K";

		$modRekKredit = new RekeningakuntansiV('search');
		$modRekKredit->unsetAttributes();
		$modRekKredit->rekening5_nb = $account;
//            $account = "K";
		if (isset($_GET['RekeningakuntansiV'])) {
			$modRekKredit->attributes = $_GET['RekeningakuntansiV'];
			$modRekKredit->rekening5_nb = $account;
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
								saveKredit();
								return false;
						"))',
				),
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
					'type' => 'raw',
					'name' => 'nmrekening5',
					'value' => '($data->nmrekening5 == "" ?  "-" : $data->nmrekening5)',
				),
				array(
					'header' => 'Nama Lain',
					'name' => 'nmrekeninglain5',
					'value' => '($data->nmrekeninglain5 == "" ?  "-" : $data->nmrekeninglain5)',
				),
				array(
					'header' => 'Saldo Normal',
					'name' => 'rekening5_nb',
					'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
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
$urlEditKredit = Yii::app()->createUrl('sistemAdministrator/rekonsiliasibankrekeningM/getRekeningEditKreditRekonBank'); //MAsukan Dengan memilih Rekening
$mds = Yii::t('mds', 'Anda yakin akan ubah data rekening kredit ?');
$urlRefresh = Yii::app()->createUrl('sistemAdministrator/MasterRekonsiliasBank');
$jscript = <<< JS

function saveKredit()
{
    rekening1_id = $('#rekening1_id').val();
    rekening2_id = $('#rekening2_id').val();
    rekening3_id = $('#rekening3_id').val();
    rekening4_id = $('#rekening4_id').val();
    rekening5_id = $('#rekening5_id').val();
    rekening5_nb = $('#rekening5_nb').val();
    jenisrekonsiliasibank_id = $('#jenisrekonsiliasibank_id').val();
    rekonsiliasibankrekening_id = $('#rekonsiliasibankrekening_id').val();

    myConfirm("${mds}",'Perhatian!',function(r){
        if(r)
        {
            $.post("${urlEditKredit}", {rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, jenisrekonsiliasibank_id:jenisrekonsiliasibank_id, rekening5_nb:rekening5_nb,rekonsiliasibankrekening_id:rekonsiliasibankrekening_id},
                function(data){
                    $('.divForForm').html(data.pesan);
                    setTimeout(function(){
                        $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
                        window.location.href=("${urlRefresh}");
                        return true;
                    },500);
            }, "json");
        }
    });
}
    
JS;
Yii::app()->clientScript->registerScript('rekonBank', $jscript, CClientScript::POS_HEAD);
?>