<div class="white-container">
    <legend class="rim2">Ubah <b>Tindakan Ruangan</b></legend>
    <?php
    $arrMenu = array();
    array_push($arrMenu, array('label' => Yii::t('mds', 'update') . ' Tindakan Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
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
    <?php  echo $form->labelEx($model,'Ruangan',array('class'=>'control-label required'));  ?>
    <div class="control-group">
       <div class="controls">
            
            <?php 
                echo $form->hiddenField($model,'ruangan_id',array("readonly"=>TRUE));
                echo CHtml::textField('ruangan_nama', $model->ruangan->ruangan_nama, array('readonly' => true, 'class' => 'span4'));
                 /*    $arrRuangan = array();
                      foreach($modRuangan as $Ruangan)
                        {
                           $arrRuangan[] = $Ruangan['ruangan_id'];
                        }

                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                array('sortable'=>true, 'searchable'=>true)
                           );
                   echo CHtml::dropDownList(
                   'ruangan_id[]',
                   $arrRuangan,
                   CHtml::listData(SARuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                   array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:250px')
                           );*/
             ?>
       </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label("Daftar Tindakan", "daftartindakan_nama", array('class' => 'control-label')); ?>
       <div class="controls">
            <?php echo $form->hiddenField($model, 'daftartindakan_id'); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
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
                    'class' => 'span4'
                ),
                'tombolDialog' => array('idDialog' => 'dialogTindakan'),
            ));
            ?>
        </div>
    </div>
            
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
               <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tindakan Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',            
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>
</div>                      
<?php $this->endWidget(); ?>
  <?php
    //========= Dialog buat cari data Bidang =========================
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

    $modDaftarTindakan = new SADaftarTindakanM('search');
    $modDaftarTindakan->unsetAttributes();
    if (isset($_GET['SADaftarTindakanM'])) {
        $modDaftarTindakan->attributes = $_GET['SADaftarTindakanM'];
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
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectTindakan",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
                                    $(\"#' . CHtml::activeId($model, 'daftartindakan_nama') . '\").val(\'$data->daftartindakan_nama\');
                                    $(\'#dialogTindakan\').dialog(\'close\');
                                    return false;"))'
            ),
            array(
                'name' => 'kelompoktindakan.kelompoktindakan_nama',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kelompoktindakan_id', CHtml::listData(SAKelompokTindakanM::getItems(), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('empty' => '-- Pilih --')),
            ),
            array(
                'name' => 'kategoritindakan.kategoritindakan_nama',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'kategoritindakan_id', CHtml::listData(SAKategoriTindakanM::getItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('empty' => '-- Pilih --')),
            ),
            array(
                'name'=> 'komponenunit_id',
                'value'=> '$data->komponenunit->komponenunit_nama',
                'filter' => CHtml::activeDropDownList($modDaftarTindakan, 'komponenunit_id', CHtml::listData(SAKomponenUnitM::getItems(), 'komponenunit_id', 'komponenunit_nama'), array('empty' => '-- Pilih --')),
            ),
            'daftartindakan_kode',
            'daftartindakan_nama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>
<?php $this->renderPartial($this->path_view . "_jsFunctions", array('model' => $model)); ?>
