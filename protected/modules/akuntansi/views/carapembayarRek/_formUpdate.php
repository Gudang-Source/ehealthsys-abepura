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
	<?php echo $form->errorSummary($modeld); ?>
        
        
        <table>
		<tr>
                        <td>
                                <div class="control-group">
                                    <?php echo CHtml::label('Cara Pembayaran', '', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modlookup,'lookup_name', array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>
                                    </div>
				</div> 
                        </td>
			<td>
				

				<div class='control-group'>
					<?php echo $form->labelEx($modlookup,'rekening_debit', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php 
                                                $modlookup->rekening_debit = $modeld->rekening5_id;
                                                echo $form->hiddenField($modlookup,'rekening_debit',array('class'=>'span3','maxlength'=>50));  ?>
						<?php
                                                        //var_dump($model["D"]->rekeningdebit->nmrekening5); die;
                                                        if (!empty($modeld->rekening5_id)) $modlookup->rekDebit = $modeld->rekening5->nmrekening5;
							$this->widget('MyJuiAutoComplete', array(
								'model' => $modlookup,
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
													$("#' . CHtml::activeId($modlookup, 'rekening_debit') . '").val(ui.item.rekening5_id);
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
					<?php echo $form->labelEx($modlookup,'rekeningKredit', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php 
                                                $modlookup->rekening_kredit = $modelk->rekening5_id;
                                                if (!empty($modelk->rekening5_id)) $modlookup->rekKredit = $modelk->rekening5->nmrekening5;
                                                echo $form->hiddenField($modlookup,'rekening_kredit',array('class'=>'span3','maxlength'=>50));  ?>
						<?php
                                                        
							$this->widget('MyJuiAutoComplete', array(
								'model' => $modlookup,
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
													$("#' . CHtml::activeId($modlookup, 'rekening_debit') . '").val(ui.item.rekening5_id);
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRekDebit',
	'options' => array(
		'title' => 'Daftar Rekening Debit',
		'autoOpen' => false,
		'modal' => true,
		'width' => 1000,
		'height' => 700,
		'resizable' => false,
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

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchAccounts(),
	'filter'=>$modRekDebit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    /*
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kode Rekening</center>',
                'start'=>1, //indeks kolom 3
                'end'=>5, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Saldo Normal</center>',
                'start'=>8, //indeks kolom 3
                'end'=>9, //indeks kolom 4
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
                                                $(\"#AKLookupM_rekening_debit\").val(\"$data->rekening5_id\");
                                                $(\"#AKLookupM_rekDebit\").val(\"$data->nmrekening5\");                                                
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
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
                ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
        
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRekKredit',
	'options' => array(
		'title' => 'Daftar Rekening Kredit',
		'autoOpen' => false,
		'modal' => true,
		'width' => 1000,
		'height' => 700,
		'resizable' => false,
	),
));

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

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->search(),
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
                                                $(\"#AKLookupM_rekening_kredit\").val(\"$data->rekening5_id\");
                                                $(\"#AKLookupM_rekKredit\").val(\"$data->nmrekening5\");
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
                ),
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