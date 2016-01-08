
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapaketbmhp-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
    'focus' => '#SAPaketbmhpM_tipepaket_id',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'tipepaket_id', CHtml::listData(TipepaketM::model()->findAll('tipepaket_aktif=true'), 'tipepaket_id', 'tipepaket_nama'), array('empty' => '-- pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->dropDownListRow($model, 'kelompokumur_id', CHtml::listData(KelompokumurM::model()->findAll(), 'kelompokumur_id', 'kelompokumur_nama'), array('empty'=>'-- Pilih --' , 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<div class="control-group ">
    <?php echo $form->label($model, 'daftartindakan_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <div class="input-append" style='display:inline'>
			    <?php echo $form->hiddenField($model,'daftartindakan_id',array('readonly'=>true)); ?>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'daftartindakan_nama',
                        'sourceUrl' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autocompleteDaftarTindakan').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
											$(this).val("");
											return false;
										}',
                            'select' => 'js:function( event, ui ) {
											$("#'.CHtml::activeId($model, 'daftartindakan_id').'").val(ui.item.daftartindakan_id);
											$("#'.CHtml::activeId($model, 'daftartindakan_nama').'").val(ui.item.daftartindakan_nama);
											return false;
										  }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 ',
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogDaftarTindakan'),
                ));
                ?>
        </div>      

    </div>

</div>
<div class="control-group ">
    <?php echo $form->label($model, 'obatalkes_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <div class="input-append" style='display:inline'>
			    <?php echo $form->hiddenField($model,'obatalkes_id',array('readonly'=>true)); ?>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'obatalkes_nama',
                        'sourceUrl' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autocompleteObatalkes').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
											$(this).val("");
											return false;
										}',
                            'select' => 'js:function( event, ui ) {
											$("#'.CHtml::activeId($model, 'obatalkes_id').'").val(ui.item.obatalkes_id);
											$("#'.CHtml::activeId($model, 'obatalkes_nama').'").val(ui.item.obatalkes_nama);
											return false;
										  }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 ',
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
                ));
                ?>
        </div>      

    </div>

</div>
<div class="control-group ">
    <label class="control-label">Jumlah / Harga Pemakaian</label>
    <div class="controls">
            <?php echo $form->textField($model,'qtypemakaian',array('class'=>'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?> / 
            <?php echo $form->textField($model,'hargapemakaian',array('class'=>'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/paketbmhpM/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'))."&nbsp";
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Paket BMHP', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));
    ?>
	<?php
$content = $this->renderPartial($this->path_view.'tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDaftarTindakan',
    'options' => array(
        'title' => 'Pencarian Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modDaftarTindakan = new SADaftarTindakanM('search');
$modDaftarTindakan->unsetAttributes();
if (isset($_GET['SADaftarTindakanM'])) {
    $modDaftarTindakan->attributes = $_GET['SADaftarTindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'satarif-tindakan-m-grid', 
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modDaftarTindakan->search(),
    'filter' => $modDaftarTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectDaftarTindakan",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'daftartindakan_id').'\").val(\"$data->daftartindakan_id\");
								  $(\"#'.CHtml::activeId($model, 'daftartindakan_nama') . '\").val(\"$data->daftartindakan_nama\");
								  $(\"#dialogDaftarTindakan\").dialog(\"close\");    
					"))',
		),
		'daftartindakan_kode',
		'daftartindakan_nama',
		'tindakanmedis_nama',
        array( 
			'name'=>'daftartindakan_karcis', 
			'value'=>'($data->daftartindakan_karcis)? "Ya" : "Tidak"', 
			'filter'=>false, 
		),
        array( 
			'name'=>'daftartindakan_konsul',
			'type'=>'raw',
			'value'=>'($data->daftartindakan_konsul)? "Ya" : "Tidak"', 
			'filter'=>false, 
		),
        array( 
			'name'=>'daftartindakan_akomodasi', 
			'type'=>'raw',
			'value'=>'($data->daftartindakan_akomodasi)? "Ya" : "Tidak"', 
			'filter'=>false, 
		),
        array( 
			'name'=>'daftartindakan_tindakan', 
			'type'=>'raw',
			'value'=>'($data->daftartindakan_tindakan) ? "Ya" : "Tidak"', 
			'filter'=>false, 
		),
       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modObatAlkes = new ObatalkesM('search');

$modObatAlkes->unsetAttributes();
if (isset($_GET['idKelasPelayanan'])){
    $modObatAlkes->kelaspelayanan_id = $_GET['idKelasPelayanan'];
}
if (isset($_GET['ObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkes-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modObatAlkes->search(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#idObatAlkes\").val(\"$data->obatalkes_id\");
                                                          $(\"#qtyPakai\").val(0);
                                                          $(\"#hargaPakai\").val(0);
                                                          $(\"#'.CHtml::activeId($model, 'obatalkes_id') . '\").val(\"$data->obatalkes_id\");
                                                          $(\"#'.CHtml::activeId($model, 'obatalkes_nama') . '\").val(\"".$data->obatalkes_nama." - ".$data->sumberdana->sumberdana_nama."\");
                                                          $(\"#dialogObatAlkes\").dialog(\"close\");    
                                                "))',
        ),
        'obatalkes_kategori',
        'obatalkes_golongan',
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name' => 'sumberdanaNama',
            'type' => 'raw',
            'value' => '$data->sumberdana->sumberdana_nama',
        ),
        array(
            'name' => 'hargajual',
            'type' => 'raw',
            'value'=>'number_format($data->hargajual,0,".",",")', 
            'filter'=>false,
        ),
        array(
            'name' => 'harganetto',
            'type' => 'raw',
            'value'=>'number_format($data->harganetto,0,".",",")', 
            'filter'=>false,
        ),
        // 'hargajual',
        // 'harganetto',
//        'obatalkes_kadarobat',
//        'kemasanbesar',
//        'kekuatan',
        //'tglkadaluarsa',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>