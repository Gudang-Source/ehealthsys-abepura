<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'carabayarrek-m-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'requiredCheck();'),
	'focus'=>'#AKCarapembayarRekM_rekDebit',
)); ?>

    <?php  //if (isset($modDetails)){ echo $form->errorSummary($modDetails); } ?>
    <?php echo $form->errorSummary($model); ?>
	<table>
		<tr>
			<td>
				<div class='control-group'>
					<?php echo $form->labelEx($model,'rekening debet', array('class'=>'control-label')) ?>
					 <div class="controls">
						 <?php echo CHtml::hiddenField('AKCarapembayarRekM[rekening][1][rekening5_nb]','D',array('class'=>'span3'));  ?>
						 <?php echo CHtml::hiddenField('AKCarapembayarRekM[rekening][1][rekening5_id]','',array('class'=>'span3'));  ?>
						 <?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][1][rekening4_id]','',array('class'=>'span3'));  ?>
						 <?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][1][rekening3_id]','',array('class'=>'span3'));  ?>
						 <?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][1][rekening2_id]','',array('class'=>'span3'));  ?>
						 <?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][1][rekening1_id]','',array('class'=>'span3'));  ?>
						<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'rekDebit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiDebit'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmrekening1);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrekening5);
													$("#AKCarapembayarRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
													$("#AKCarapembayarRekM_rekening_1_rekening4_id").val(ui.item.rekening4_id);
													$("#AKCarapembayarRekM_rekening_1_rekening3_id").val(ui.item.rekening3_id);
													$("#AKCarapembayarRekM_rekening_1_rekening2_id").val(ui.item.rekening2_id);
													$("#AKCarapembayarRekM_rekening_1_rekening1_id").val(ui.item.rekening1_id);
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
			</td>
			<td>
				<div class='control-group'>
					<?php echo $form->labelEx($model,'rekening kredit', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo CHtml::hiddenField('AKCarapembayarRekM[rekening][2][rekening5_nb]','K',array('class'=>'span3'));  ?>
						<?php echo CHtml::hiddenField('AKCarapembayarRekM[rekening][2][rekening5_id]','',array('class'=>'span3'));  ?>
						<?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][2][rekening4_id]','',array('class'=>'span3'));  ?>
						<?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][2][rekening3_id]','',array('class'=>'span3'));  ?>
						<?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][2][rekening2_id]','',array('class'=>'span3'));  ?>
						<?php // echo CHtml::hiddenField('AKCarapembayarRekM[rekening][2][rekening1_id]','',array('class'=>'span3'));  ?>
						<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'rekKredit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansiKredit'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmrekening5);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrekening5);
													$("#AKCarapembayarRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
													$("#AKCarapembayarRekM_rekening_2_rekening4_id").val(ui.item.rekening4_id);
													$("#AKCarapembayarRekM_rekening_2_rekening3_id").val(ui.item.rekening3_id);
													$("#AKCarapembayarRekM_rekening_2_rekening2_id").val(ui.item.rekening2_id);
													$("#AKCarapembayarRekM_rekening_2_rekening1_id").val(ui.item.rekening1_id);
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
    
	<div style='max-height:400px;max-width:100%;overflow-y: scroll;align:center;margin-bottom:20px;'>
		<?php 
			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'carabayarrek-m-grid',
				'dataProvider'=>$modCarabayar->searchCaraPembayaran(),
				'filter'=>$modCarabayar,
				'template'=>"{pager}\n{items}",
				'itemsCssClass'=>'table table-striped table-bordered table-condensed',
				'columns'=>array(
					array(
						'header'=>'Pilih'.'<br>'.CHtml::checkBox("cekAll","",array('onclick'=>'checkAllCarabayar();')),
						'type'=>'raw',
						'value'=>'CHtml::checkBox("AKCarapembayarRekM[bayar][$data->lookup_name][pilihCarabayar]","",array("onclick"=>"setAll();","class"=>"cekList"))',
					),
					array(
						'header'=>'<center>Cara Bayar</center>',
						'name'=>'lookup_name',
						//'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
						'value'=>'CHtml::hiddenField("AKCarapembayarRekM[$data->lookup_name][lookup_name]", $data->lookup_name, array("id"=>"lookup_name","onkeypress"=>"return $(this).focusNextInputField(event)"))."".$data->lookup_name',
						'type'=>'raw',
					),
				),
				'afterAjaxUpdate'=>'
					function(id, data){
						jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
				}',
			)); 
		?>
	</div>
    
            
    <div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				Yii::app()->createUrl($this->module->id.'/'.$this->id.'/create'), 
					array('class'=>'btn btn-danger',
						'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                                                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jurnal Rekening Cara Pembayaran',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
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

$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
$modRekDebit->rekening5_nb = "D";
//$account = "D";
$account = "";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
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

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
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
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#AKCarapembayarRekM_rekening_1_rekening5_id\").val(\"$data->rekening5_id\");
					$(\"#AKCarapembayarRekM_rekening_1_rekening4_id\").val(\"$data->rekening4_id\");
					$(\"#AKCarapembayarRekM_rekening_1_rekening3_id\").val(\"$data->rekening3_id\");
					$(\"#AKCarapembayarRekM_rekening_1_rekening2_id\").val(\"$data->rekening2_id\");
					$(\"#AKCarapembayarRekM_rekening_1_rekening1_id\").val(\"$data->rekening1_id\");
					$(\"#AKCarapembayarRekM_rekDebit\").val(\"$data->nmrekening5\");                                                
					$(\"#dialogRekDebit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
                        'header'=>'Kelompok Akun',
                        'name'=>'rekening1_id',
                        'value'=>'$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Golongan Akun',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Sub Golongan Akun',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Jenis Akun',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening4_id', 
                        CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
		array(
			'header' => 'Nama Akun',
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
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
$modRekKredit->rekening5_nb = "K";
//$account = "K";
$account = "";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
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

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
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
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#AKCarapembayarRekM_rekening_2_rekening5_id\").val(\"$data->rekening5_id\");
					$(\"#AKCarapembayarRekM_rekening_2_rekening4_id\").val(\"$data->rekening4_id\");
					$(\"#AKCarapembayarRekM_rekening_2_rekening3_id\").val(\"$data->rekening3_id\");
					$(\"#AKCarapembayarRekM_rekening_2_rekening2_id\").val(\"$data->rekening2_id\");
					$(\"#AKCarapembayarRekM_rekening_2_rekening1_id\").val(\"$data->rekening1_id\");
					$(\"#AKCarapembayarRekM_rekKredit\").val(\"$data->nmrekening5\");
					$(\"#dialogRekKredit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
                        'header' => 'Kelompok Akun',
                        'name' => 'rekening1_id',
                        'value' => '$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                                CHtml::listData(Rekening1M::model()->findAll(array(
                                    'condition'=>'rekening1_aktif = true',
                                    'order'=>'kdrekening1 asc',
                                )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Golongan Akun',
                        'name' => 'rekening2_id',
                        'value' => '$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Sub Golongan Akun',
                        'name' => 'rekening3_id',
                        'value' => '$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Jenis Akun',
                        'name' => 'rekening4_id',
                        'value' => '$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
                                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
		array(
			'header' => 'Nama Akun',
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

<script>
	function checkAllCarabayar() {
		if ($("#cekAll").is(":checked")) {
			$('#carabayarrek-m-grid input[name*="pilihCarabayar"]').each(function(){
			   $(this).attr('checked',true);
			})
		} else {
		   $('#carabayarrek-m-grid input[name*="pilihCarabayar"]').each(function(){
			   $(this).removeAttr('checked');
			})
		}
		setAll();
	}

	function setAll(obj){
		$('.cekList').each(function(){
		   if ($(this).is(':checked')){

				$(this).parents('tr').find('.cekList').val(1);
				}else{
					$(this).parents('tr').find('.cekList').val(0);
				}
		});
	}
</script>