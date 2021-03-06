<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'jenispenerimaan-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this)'),
	'focus' => '#AKJenispenerimaanM_jenispenerimaan_kode',
		));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>

<table width="100%">
	<tr>
		<td>
			<div class='control-group'>
				<?php echo $form->labelEx($model, 'jenispenerimaan_kode', array('class' => 'control-label')) ?>
				<div class="controls">
                                        <?php echo $form->textField($model, 'jenispenerimaan_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
				<?php echo $form->labelEx($model, 'jenispenerimaan_nama', array('class' => 'control-label')) ?>
				<div class="controls">
                                        <?php echo $form->textField($model, 'jenispenerimaan_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>

			<div class='control-group'>
				<?php echo $form->labelEx($model, 'jenispenerimaan_namalain', array('class' => 'control-label')) ?>
				<div class="controls">
                                        <?php echo $form->textField($model, 'jenispenerimaan_namalain', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
				</div>
			</div>
		</td>
                <td>
                        <div class='control-group'>
                                <?php echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
                                <div class="controls">
                                        <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening5_nb]','D', array('readonly'=>true));  ?>
                                        <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening5_id]','', array('readonly'=>true));  ?>
                                        <?php
                                                $this->widget('MyJuiAutoComplete', array(
                                                        'model' => $model,
                                                        'attribute' => 'rekDebit',
                                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiDebit'),
                                                        'options' => array(
                                                                'showAnim' => 'fold',
                                                                'minLength' => 2,
                                                                'focus' => 'js:function( event, ui ) {
                                                                                $(this).val(ui.item.nmrekening5);
                                                                                return false;
                                                                        }',
                                                                'select' => 'js:function( event, ui ) {
                                                                                                $(this).val(ui.item.nmrekening5);
                                                                                                $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
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
                                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                array('onclick'=>'tambahRekeningDebit();return false;',
                                                          'class'=>'btn btn-primary',
                                                          'onkeypress'=>"tambahRekeningDebit();return false;",
                                                          'rel'=>"tooltip",
                                                          'title'=>"Klik untuk menambahkan",));
                                        ?>
                                </div>
                        </div>

                        <div class='control-group'>
                                <?php echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
                                <div class="controls">
                                        <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening5_nb]','K', array('readonly'=>true));  ?>
                                        <?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening5_id]','', array('readonly'=>true));  ?>
                                       <?php
                                                $this->widget('MyJuiAutoComplete', array(
                                                        'model' => $model,
                                                        'attribute' => 'rekKredit',
                                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiKredit'),
                                                        'options' => array(
                                                                'showAnim' => 'fold',
                                                                'minLength' => 2,
                                                                'focus' => 'js:function( event, ui ) {
                                                                                $(this).val(ui.item.nmrincianobyek);
                                                                                return false;
                                                                        }',
                                                                'select' => 'js:function( event, ui ) {
                                                                                                $(this).val(ui.item.nmrincianobyek);
                                                                                                 $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
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
                                                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                array('onclick'=>'tambahRekeningKredit();return false;',
                                                          'class'=>'btn btn-primary',
                                                          'onkeypress'=>"tambahRekeningKredit();return false;",
                                                          'rel'=>"tooltip",
                                                          'title'=>"Klik untuk menambahkan",));
                                        ?>
                                </div>
                        </div>
                </td>
	</tr>
</table>
<table class="table table-condensed table-bordered" id="tab_rekening_debit">
    <thead>
        <tr>
            <th>Rekening Debit</th>
            <th width="50px">Batal</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<table class="table table-condensed table-bordered" id="tab_rekening_kredit">
    <thead>
        <tr>
            <th>Rekening Kredit</th>
            <th width="50px">Batal</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="form-actions">
	<?php
	echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
					Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
	?>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/jurnalRekPenerimaan/admin'), array('class' => 'btn btn-danger',
		'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Penerimaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('tab'=>'frame','modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
	<?php
        $tips = array(
            '0' => 'autocomplete-search',
            '1' => 'tambah2',
            '2' => 'batal',
            '3' => 'simpan',
            '4' => 'ulang'
        );
	$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips'=>$tips), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
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

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
// $modRekDebit->rekening5_nb = "D";
$modRekDebit->rekening5_aktif = true;
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
	'dataProvider'=>$modRekDebit->searchAccounts(),
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
//        ),
	'columns'=>array(
                array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#AKJnsPenerimaanRekM_rekening_1_rekening5_id\").val(\"$data->rekening5_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_1_rekening4_id\").val(\"$data->rekening4_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_1_rekening3_id\").val(\"$data->rekening3_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_1_rekening2_id\").val(\"$data->rekening2_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_1_rekening1_id\").val(\"$data->rekening1_id\");
					$(\"#AKJenispenerimaanM_rekDebit\").val(\"$data->nmrekening5\");                                                
					$(\"#dialogRekDebit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                        'filter' => Chtml::activeTextField($modRekDebit, 'kdrekening5', array('class'=>'numbers-only','maxlength'=>12))
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
                        'filter' => Chtml::activeTextField($modRekDebit, 'nmrekening5', array('class'=>'custom-only'))
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
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
                                . '}',
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

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
// $modRekKredit->rekening5_nb = "K";
$modRekKredit->rekening5_aktif = true;
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
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts(),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Kode Rekening</center>',
//                'start'=>1, //indeks kolom 3
//                'end'=>4, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
                array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#AKJnsPenerimaanRekM_rekening_2_rekening5_id\").val(\"$data->rekening5_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_2_rekening4_id\").val(\"$data->rekening4_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_2_rekening3_id\").val(\"$data->rekening3_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_2_rekening2_id\").val(\"$data->rekening2_id\");
					$(\"#AKJnsPenerimaanRekM_rekening_2_rekening1_id\").val(\"$data->rekening1_id\");
					$(\"#AKJenispenerimaanM_rekKredit\").val(\"$data->nmrekening5\");
					$(\"#dialogRekKredit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                        'filter' => Chtml::activeTextField($modRekKredit, 'kdrekening5', array('class'=>'numbers-only','maxlength'=>12))
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
                        'filter' => Chtml::activeTextField($modRekKredit, 'nmrekening5', array('class'=>'custom-only'))
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
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
		),
		
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
                                . '}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<script type="text/javascript">
	function namaLain(nama)
	{
		document.getElementById('AKJenispenerimaanM_jenispenerimaan_namalain').value = nama.value.toUpperCase();
	}
        
        var id = "";
        function tambahRekeningDebit()
        {
            id = $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val();
            if (id.trim() == "") {
                myAlert("Rekening Debit Belum Dipilih");
                return false;
            }
            $.post('<?php echo $this->createUrl('formRekening'); ?>', {
                id: id, debitkredit: 'D',
            }, function(data) {
                $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val("");
                $("#AKJenispenerimaanM_rekDebit").val("");
                $("#tab_rekening_debit tbody").append(data.dat);
            }, 'json');
        }

        function tambahRekeningKredit()
        {
            id = $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val();
            nama = $("#AKJenispenerimaanM_rekKredit").val();
            if (id.trim() == "") {
                myAlert("Rekening Kredit Belum Dipilih");
                return false;
            }
            $.post('<?php echo $this->createUrl('formRekening'); ?>', {
                id: id, debitkredit: 'K',
            }, function(data) {
                $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val("");
                $("#AKJenispenerimaanM_rekKredit").val("");
                $("#tab_rekening_kredit tbody").append(data.dat);
            }, 'json');
        }
        
        function batalRekening(obj) {
            myConfirm("Apakah Anda yakin ingin menghapus rekening ini?","Perhatian!",
            function(r){
                if(r){
                    $(obj).parents("tr").remove();
                }
            }); 
        }
</script>