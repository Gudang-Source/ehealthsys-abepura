<div class="white-container">
    <legend class="rim2">Tambah <b>Rekening Pelayanan</b></legend>
    <?php
    $arrMenu = array();
    array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Rekening Pelayanan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tindakan Ruangan', 'icon' => 'folder-open', 'url' => array('Admin'))) : '';

    //$this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert');

    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'tindakanruangan-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
    ));
    ?>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, "daftartindakan_id", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
            <?php echo $form->hiddenField($model, 'ruangan_id'); ?>
            <?php echo $form->hiddenField($model, 'komponentarif_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modTindakanRuangan,
                'attribute' => 'daftartindakan_nama',
                'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompleteTindakan') . '",
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
					$(this).val( ui.item.value);
					return false;
					}',
                    'select' => 'js:function( event, ui ) { 
					$("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val(ui.item.daftartindakan_id);
					return false;
					}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode / Nama Tindakan',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogTindakan'),
            ));
            ?>
        </div> 
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'Rekening Debit', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'rekening5_id_d'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modTindakanRuangan,
                'attribute' => 'nmrekening5_d',
                'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompleteRekDebit') . '",
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
					$(this).val( ui.item.value);
					return false;
					}',
                    'select' => 'js:function( event, ui ) { 
					$("#' . CHtml::activeId($model, 'rekening5_id_d') . '").val(ui.item.rekening5_id);
					return false;
					}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode / Nama Rekening',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogRekDebit'),
            ));
            ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'Rekening Kredit', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'rekening5_id_k'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modTindakanRuangan,
                'attribute' => 'nmrekening5_k',
                'source' => 'js: function(request, response) {
                                    $.ajax({
					url: "' . $this->createUrl('AutocompleteRekDebit') . '",
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
					$(this).val( ui.item.value);
					return false;
					}',
                    'select' => 'js:function( event, ui ) { 
					$("#' . CHtml::activeId($model, 'rekening5_id_k') . '").val(ui.item.rekening5_id);
					return false;
					}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode / Nama Rekening',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogRekKredit'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'jnspelayanan', array('class' => 'control-label')); ?>

        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'jnspelayanan', CHtml::listData(SALookupM::getItemsList(), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            ));
            ?>
        </div>
        <div class="controls">
            <?php
            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                'class' => 'btn btn-primary',
                'onclick' => 'tambahTindakan();return false;',
                'onkeypress' => "tambahTindakan();return false;",
                'rel' => "tooltip",
                'title' => "Klik untuk menambahkan tindakan ke rekening pelayanan",));
            ?>
        </div>
        <div class="controls">
            <?php
            echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array(
                'class' => 'btn btn-danger',
                'style' => 'float:inline;',
                'onclick' => 'ulangTindakan();return false;',
                'rel' => "tooltip",
                'title' => "Klik untuk mengulang",));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <fieldset class="block">
        <div class="block-tabel">
            <h6>Tabel Daftar Rekening Pelayanan</h6>
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'rekeningpelayanan-m-grid',
                'dataProvider' => $modTindakanRuangan->search(),
                'filter' => $modTindakanRuangan,
                'template' => "{summary}\n{items}{pager}",
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(

                    array(
                        'header' => 'Rek. 5',
                        'name' => 'nmrekening5',
                        'value' => 'isset($data->rekening5->nmrekening5)?$data->rekening5->nmrekening5:" - "',
                    ),
                    array(
                        'header' => 'Ruangan',
                        'name' => 'ruangan_nama',
                        'value' => 'isset($data->ruangan->ruangan_nama)?$data->ruangan->ruangan_nama:" - "',
                    ),
                    array(
                        'header' => 'Nama Tindakan',
                        'name' => 'daftartindakan_nama',
                        'value' => 'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
                    ),
					array(
                        'header' => 'Komponen Tarif',
                        'name' => 'komponentarif_nama',
                        'value' => 'isset($data->komponentarif->komponentarif_nama)?$data->komponentarif->komponentarif_nama:" - "',
                    ),
                    array(
                        'header' => 'Hapus',
                        'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                        'template' => '{delete}',
                        'buttons' => array(
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("ruangan_id"=>"$data->ruangan_id","daftartindakan_id"=>"$data->daftartindakan_id"))',
                            ),
                        ),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tindakan Ruangan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips.tipsaddedit3', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>


    <?php
    //========= Dialog buat cari data Daftar Tindakan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTindakan',
        'options' => array(
            'title' => 'Daftar Tindakan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
        ),
    ));

    $modDaftarTindakan = new SATariftindakanruangandetailV('search');
    $modDaftarTindakan->unsetAttributes();
    if (isset($_GET['SATariftindakanruangandetailV'])) {
        $modDaftarTindakan->attributes = $_GET['SATariftindakanruangandetailV'];
    } else {
        $modDaftarTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'daftartindakan-m-grid',
        'dataProvider' => $modDaftarTindakan->search(),
        'filter' => $modDaftarTindakan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectTindakan",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
                                    $(\"#' . CHtml::activeId($model, 'daftartindakan_nama') . '\").val(\'$data->daftartindakan_nama\');
                                    $(\"#' . CHtml::activeId($model, 'ruangan_id') . '\").val(\'$data->ruangan_id\');
                                    $(\"#' . CHtml::activeId($model, 'komponentarif_id') . '\").val(\'$data->komponentarif_id\');
                                    $(\'#dialogTindakan\').dialog(\'close\');
                                    return false;"))'
            ),
            array(
                'header' => 'Ruangan',
                'name' => 'ruangan_nama',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'ruangan_id', CHtml::listData(SARuanganM::getItemsList(), 'ruangan_id', 'ruangan_nama'), array('empty' => '--Pilih--')),
            ),
            array(
                'header' => 'Komponen Tarif',
                'name' => 'komponentarif_nama',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'komponentarif_id', CHtml::listData(SAKomponentarifM::getItemsList(), 'komponentarif_id', 'komponentarif_nama'), array('empty' => '--Pilih--')),
            ),
            array(
                'header' => 'Kelompok Tindakan',
                'name' => 'kelompoktindakan_nama',
                'value' => 'isset($data->kelompoktindakan_nama)?$data->kelompoktindakan_nama:" - "',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kelompoktindakan_id', CHtml::listData(SAKelompokTindakanM::getItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('empty' => '--Pilih--')),
            ),
            array(
                'header' => 'Kategori Tindakan',
                'name' => 'kategoritindakan_nama',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kategoritindakan_id', CHtml::listData(SAKategoriTindakanM::getItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('empty' => '--Pilih--')),
            ),
            array(
                'header' => 'Kode Tindakan',
                'name' => 'daftartindakan_kode',
                'value' => 'isset($data->daftartindakan_kode)?$data->daftartindakan_kode:" - "',
            ),
            array(
                'header' => 'Nama Tindakan',
                'name' => 'daftartindakan_nama',
                'value' => 'isset($data->daftartindakan_nama)?$data->daftartindakan_nama:" - "',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>

    <?php
    //========= Dialog buat cari data Rekening Debit =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRekDebit',
        'options' => array(
            'title' => 'Rekening Debit',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
        ),
    ));

    $modRekeningDebit = new SARekeningakuntansiV('searchDebit');
    $modRekeningDebit->unsetAttributes();
    if (isset($_GET['SARekeningakuntansiV'])) {
        $modRekeningDebit->attributes = $_GET['SARekeningakuntansiV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'rekeningdebit-m-grid',
        'dataProvider' => $modRekeningDebit->searchDebit(),
        'filter' => $modRekeningDebit,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'rekening5_id_d') . '\").val(\'$data->rekening5_id\');
                                    $(\"#' . CHtml::activeId($model, 'nmrekening5_d') . '\").val(\'$data->nmrekening5\');
                                    $(\'#dialogRekDebit\').dialog(\'close\');
                                    return false;"))'
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
					'type'=>'raw',
					'name'=>'nmrekening5',
					'value'=>'($data->nmrekening5 == "" ? $data->nmrekening4 : ($data->nmrekening4 == "" ? $data->nmrekening3 : ($data->nmrekening3 == "" ? $data->nmrekening2 : ($data->nmrekening2 == "" ? $data->nmrekening1 : ($data->nmrekening1 == "" ? "-" : $data->nmrekening5)))))',
				),  
				array(
					'header'=>'Nama Lain',
					'name'=>'nmrekeninglain5',
					'value'=>'($data->nmrekeninglain5 == "" ? $data->nmrekeninglain4 : ($data->nmrekeninglain4 == "" ? $data->nmrekeninglain3 : ($data->nmrekeninglain3 == "" ? $data->nmrekeninglain2 : ($data->nmrekeninglain2 == "" ? $data->nmrekeninglain1 : ($data->nmrekeninglain1 == "" ? "-" : $data->nmrekeninglain5)))))',
				),
				array(
					'header'=>'Saldo Normal',
					'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
				),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>

    <?php
    //========= Dialog buat cari data Rekening Kredit =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRekKredit',
        'options' => array(
            'title' => 'Rekening Kredit',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
        ),
    ));

    $modRekeningKredit = new SARekeningakuntansiV('searchKredit');
    $modRekeningKredit->unsetAttributes();
    if (isset($_GET['SARekeningakuntansiV'])) {
        $modRekeningKredit->attributes = $_GET['SARekeningakuntansiV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'rekeningkredit-m-grid',
        'dataProvider' => $modRekeningKredit->searchKredit(),
        'filter' => $modRekeningKredit,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRekKredit",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'rekening5_id_k') . '\").val(\'$data->rekening5_id\');
                                    $(\"#' . CHtml::activeId($model, 'nmrekening5_k') . '\").val(\'$data->nmrekening5\');
                                    $(\'#dialogRekKredit\').dialog(\'close\');
                                    return false;"))'
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
					'type'=>'raw',
					'name'=>'nmrekening5',
					'value'=>'($data->nmrekening5 == "" ? $data->nmrekening4 : ($data->nmrekening4 == "" ? $data->nmrekening3 : ($data->nmrekening3 == "" ? $data->nmrekening2 : ($data->nmrekening2 == "" ? $data->nmrekening1 : ($data->nmrekening1 == "" ? "-" : $data->nmrekening5)))))',
				),  
				array(
					'header'=>'Nama Lain',
					'name'=>'nmrekeninglain5',
					'value'=>'($data->nmrekeninglain5 == "" ? $data->nmrekeninglain4 : ($data->nmrekeninglain4 == "" ? $data->nmrekeninglain3 : ($data->nmrekeninglain3 == "" ? $data->nmrekeninglain2 : ($data->nmrekeninglain2 == "" ? $data->nmrekeninglain1 : ($data->nmrekeninglain1 == "" ? "-" : $data->nmrekeninglain5)))))',
				),
				array(
					'header'=>'Saldo Normal',
					'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
				),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>

</div>
<?php $this->renderPartial($this->path_view . "_jsFunctions", array('model' => $model)); ?>