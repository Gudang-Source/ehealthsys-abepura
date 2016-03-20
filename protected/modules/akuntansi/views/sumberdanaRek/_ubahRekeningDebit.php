<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'jenispengeluaran-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'verifikasi();'),
	'focus'=>'#',
)); ?>

<div class='divForForm'>
</div>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>
	<table>
		<tr>
			<td>
				<div class="control-group">
					<?php echo CHtml::label('Sumber Dana','', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php 
							echo $form->dropDownList($modSumberdana,'sumberdana_id', CHtml::listData($modSumberdana->getSumberdanaItems($modSumberdana->sumberdana_id), 'sumberdana_id', 'sumberdana_nama') ,
								array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'disabled'=>true)); 
						?>
					</div>
				</div>
				<div class='control-group'>
						<?php echo CHtml::label('Rekening Debit','',array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo CHtml::textField('debit',$model->rekening5->nmrekening5,array()); ?>
							<?php echo CHtml::hiddenField('rekening5_id',$model->rekening5_id,array()); ?>
							<?php // echo CHtml::hiddenField('rekening4_id',$model->rekening4_id,array()); ?>
							<?php // echo CHtml::hiddenField('rekening3_id',$model->rekening3_id,array()); ?>
							<?php // echo CHtml::hiddenField('rekening2_id',$model->rekening2_id,array()); ?>
							<?php // echo CHtml::hiddenField('rekening1_id',$model->rekening1_id,array()); ?>
							<?php echo CHtml::hiddenField('sumberdana_id',$model->sumberdana_id,array()); ?>
							<?php echo CHtml::hiddenField('sumberdanarek_id',$model->sumberdanarek_id,array()); ?>
							<?php // echo CHtml::hiddenField('saldonormal',$model->saldonormal,array()); ?>
						</div>
				</div>
			</td>
		</tr>
	 </table>
<?php $this->endWidget(); ?>
<div class="block-tabel">
    <h6>Checklist Untuk <b>Ubah Rekening Debit</b></h6>
    <div style="width:100%;">
        <?php 
		    $account = "D";
            
			$modRekDebit = new RekeningakuntansiV('search');
            $modRekDebit->unsetAttributes();
			$modRekDebit->rekening5_nb = $account;
//            $account = "";
            if(isset($_GET['RekeningakuntansiV'])) {
                $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
				$modRekDebit->rekening5_nb = $account;
            }
//            $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
            $this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'rekdebit-m-grid',
				//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
				'dataProvider'=>$modRekDebit->searchAccounts($account),
				'filter'=>$modRekDebit,
				'template'=>"{summary}\n{items}\n{pager}",
				'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//                    'mergeHeaders'=>array(
//                        array(
//                            'name'=>'<center>Kode Rekening</center>',
//                            'start'=>1, //indeks kolom 3
//                            'end'=>5, //indeks kolom 4
//                        ),
//                    ),
				'columns'=>array(
                                        array(
						'header'=>'Pilih',
						'type'=>'raw',
						'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("style"=>"text-align:left;", 
								"id" => "selectRekDebit",
								"onClick" =>"
									$(\"#rekening5_id\").val(\"$data->rekening5_id\");
									$(\"#rekening4_id\").val(\"$data->rekening4_id\");
									$(\"#rekening3_id\").val(\"$data->rekening3_id\");
									$(\"#rekening2_id\").val(\"$data->rekening2_id\");
									$(\"#rekening1_id\").val(\"$data->rekening1_id\");
									$(\"#debit\").val(\"$data->nmrekening5\");  
									saveDebit();
									return false;
						"))',
					),
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
						'name'=>'rekening5_nb',
						'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
					),

					
				),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
</div>
<script>
    function verifikasi(){
        myConfirm("<?php echo Yii::t('mds','Yakin Anda akan Ubah Data Rekening?') ?>",'Perhatian!',function(r){
            if(r)
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
$urlEditDebit = $this->createUrl('GetRekeningEditDebitKreditSumberdana');//MAsukan Dengan memilih Rekening
$urlAdmin = Yii::app()->createUrl('akuntansi/sumberdanaRek/Admin');
$jscript = <<< JS

function saveDebit()
{
    rekening1_id = $('#rekening1_id').val();
    rekening2_id = $('#rekening2_id').val();
    rekening3_id = $('#rekening3_id').val();
    rekening4_id = $('#rekening4_id').val();
    rekening5_id = $('#rekening5_id').val();
    rekening5_nb = $('#rekening5_nb').val();
    sumberdana_id = $('#sumberdana_id').val();
    sumberdanarek_id = $('#sumberdanarek_id').val();

//    myAlert(sumberdanarek_id + sumberdana_id+ rekening5_nb + rekening5_id + rekening4_id + rekening3_id + rekening2_id + rekening1_id);

    $.post("${urlEditDebit}", {rekening1_id:rekening1_id, rekening2_id:rekening2_id, rekening3_id:rekening3_id, rekening4_id:rekening4_id, rekening5_id:rekening5_id, sumberdana_id:sumberdana_id, rekening5_nb:rekening5_nb,sumberdanarek_id:sumberdanarek_id},
        function(data){
            $('.divForForm').html(data.pesan);
            setTimeout(function(){
                $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));
                window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
                return true;
            },500);
    }, "json");

    $.post("${urlAdmin}", {rekening5_id:rekening5_id, sumberdana_id:sumberdana_id}, function(data) {
        $("admin.php#divMessages").html(data.pesan);
    }, "json");

    //window.parent.reload()
  
}
    
JS;
Yii::app()->clientScript->registerScript('masukanobat',$jscript, CClientScript::POS_HEAD);
?>