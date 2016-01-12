<div class="white-container">
    <legend class="rim2">Tambah <b>Rekening Uang Muka</b></legend>
    <?php
    $arrMenu = array();
    array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Tindakan Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
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
        <?php echo $form->labelEx($model, "instalasi_id", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            if (Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) {
                $modRuangans = SAInstalasiM::getItems($model->instalasi_id);
                echo $form->dropDownList($model, 'instalasi_id', ((count($modRuangans) > 0) ? CHtml::listData($modRuangans, 'instalasi_id', 'instalasi_nama') : array()), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'refreshTabel();', 'onkeyup' => "return $(this).focusNextInputField(event);"));
            } else {
                echo CHtml::activeHiddenField($model, 'instalasi_id', array('readonly' => true));
                echo $form->textField($model, 'instalasi_nama', array('readonly' => true, 'class' => 'span3',));
            }
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, "rekening5_id", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'rekening5_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nmrekening5',
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
												$("#' . CHtml::activeId($model, 'rekening5_id') . '").val(ui.item.rekening5_id);
												return false;
											}',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Kode / Nama Rekening',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                ),
                'tombolDialog' => array('idDialog' => 'dialogTindakan'),
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
                'title' => "Klik untuk menambahkan rekening ke instalasi",));
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
            <h6>Tabel Rekening Uang Muka</h6>
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'tindakanruangan-m-grid',
                'dataProvider' => $modTindakanRuangan->search(),
                'filter' => $modTindakanRuangan,
                'template' => "{summary}\n{items}{pager}",
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Instalasi',
                        'name' => 'instalasi_nama',
                        'value' => 'isset($data->instalasi->instalasi_nama)?$data->instalasi->instalasi_nama:" - "',
                        'filter' => CHtml::activeTextField($modTindakanRuangan, "instalasi_nama") . "<br>" .
                        CHtml::activeHiddenField($modTindakanRuangan, "instalasi_id", array('readonly' => true))
                    ),
                    array(
                        'header' => 'Rekening',
                        'name' => 'nmrekening5',
                        'value' => 'isset($data->rekening5->nmrekening5)?$data->rekening5->nmrekening5:" - "',
                    ),
                    array(
                        'header' => 'Hapus',
                        'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                        'template' => '{delete}',
                        'buttons' => array(
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Delete",array("instalasi_id"=>"$data->instalasi_id","rekening5_id"=>"$data->rekening5_id"))',
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
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Rekening Uang Muka', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tipsaddedit3', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>


    <?php
    //========= Dialog buat cari data Bidang =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTindakan',
        'options' => array(
            'title' => 'Rekening',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
        ),
    ));

    $modDaftarTindakan = new SARekeningakuntansiV('search');
    $modDaftarTindakan->unsetAttributes();
    if (isset($_GET['SARekeningakuntansiV'])) {
        $modDaftarTindakan->attributes = $_GET['SARekeningakuntansiV'];
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
                                    $(\"#' . CHtml::activeId($model, 'rekening5_id') . '\").val(\'$data->rekening5_id\');
                                    $(\"#' . CHtml::activeId($model, 'nmrekening5') . '\").val(\'$data->nmrekening5\');
                                    $(\'#dialogTindakan\').dialog(\'close\');
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