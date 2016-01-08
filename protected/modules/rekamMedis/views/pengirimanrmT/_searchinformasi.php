<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'id'=>'rmpengirimanrm-t-search',
                'type'=>'horizontal',
)); ?>

<table width="100%">
    <tr>
        <td width="65%">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Tanggal</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <?php //echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span3')); ?>
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Pengiriman','tglpengirimanrm',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
                                        $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                                        $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'tgl_awal',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                )); 
                                        ?>
                            </div>
                            <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'tgl_akhir',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                )); ?>
                            </div>
                        </div>
        <!--                <?php // echo CHtml::label('No. Rekam Medik','no_rekam_medik',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php
        //                    $this->widget('MyJuiAutoComplete', array(
        //                        'model' => $model,
        //                        'attribute' => 'no_rekam_medik',
        //                        'value' => '',
        //                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekamMedikInformasi'),
        //                        'options' => array(
        //                            'showAnim' => 'fold',
        //                            'minLength' => 2,
        //                            'focus' => 'js:function( event, ui ) {
        //                                    $(this).val(ui.item.label);
        //                                    return true;
        //                                }',
        //                            'select' => 'js:function( event, ui ) {
        //                                $(this).val(ui.item.label);
        //                                     return true;
        //                                          }',
        //                        ),
        //                        'htmlOptions'=>array(
        //                            'onkeypress'=>'return $(this).focusNextInputField(event)',
        //                            'disabled'=>($model->isNewRecord)?'':'disabled',
        //                            'class'=>'span1',
        //                        ),
        //                        'tombolDialog'=>array('idDialog'=>'dialogPasien'),
        //
        //                    ));
                            ?>
                        </div>-->
                        <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3', 'autofocus'=>true, 'placeholder'=>'Ketik nama pasien')); ?>
                    </div>
                    <div class="span6">
                        <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3' , 'placeholder'=>'Ketik no. rekam medik')); ?>
                        <?php echo $form->DropDownListRow($model,'printpengiriman',array(''=>'-- Pilih ---','1'=>'Sudah diprint','0'=>'Belum diprint'),array('class'=>'span2')) ?>
                        <?php // echo CHtml::label('Nama Pasien','nama_pasien',array('class'=>'control-label')); ?>
        <!--            <div class="controls">
                        <?php
        //                $this->widget('MyJuiAutoComplete', array(
        //                    'model' => $model,
        //                    'attribute' => 'nama_pasien',
        //                    'value' => '',
        //                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienInformasi'),
        //                    'options' => array(
        //                        'showAnim' => 'fold',
        //                        'minLength' => 2,
        //                        'focus' => 'js:function( event, ui ) {
        //                                $(this).val(ui.item.label);
        //                                return true;
        //                            }',
        //                        'select' => 'js:function( event, ui ) {
        //                            $(this).val(ui.item.label);
        //                                 return true;
        //                                      }',
        //                    ),
        //                    'htmlOptions'=>array(
        //                        'onkeypress'=>'return $(this).focusNextInputField(event)',
        //                        'disabled'=>($model->isNewRecord)?'':'disabled',
        //                        'class'=>'span2',
        //                    ),
        //                    'tombolDialog'=>array('idDialog'=>'dialogPasien'),
        //
        //                ));
                        ?>
                    </div>-->
                    </div>
                </div>
        </td>
        <td>
            <div id="searching">
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Instalasi / Ruangan Asal</legend>
					<div class="control-group">
						<?php echo CHtml::label('Instalasi Asal', 'instalasipengirim_id', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'instalasipengirim_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), 
									array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
											'ajax'=>array('type'=>'POST',
														'url'=>$this->createUrl('SetDropdownRuanganAsal',array('encode'=>false,'model_nama'=>get_class($model))),
														'update'=>"#".CHtml::activeId($model, 'ruanganpengirim_id'),
											)));?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Ruangan Asal', 'ruanganpengirim_id', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'ruanganpengirim_id',CHtml::listData($model->getRuanganItems($model->instalasipengirim_id), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
						</div>
					</div>						
                </fieldset>
                <fieldset class="box2">	
                    <legend class="rim">Berdasarkan Instalasi / Ruangan Tujuan</legend>
					<div class="control-group">
						<?php echo CHtml::label('Instalasi Tujuan', 'instalasitujuan_id', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'instalasitujuan_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), 
									array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
											'ajax'=>array('type'=>'POST',
														'url'=>$this->createUrl('SetDropdownRuanganTujuan',array('encode'=>false,'model_nama'=>get_class($model))),
														'update'=>"#".CHtml::activeId($model, 'ruangantujuan_id'),
											)));?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Ruangan Tujuan', 'ruangantujuan_id', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->dropDownList($model,'ruangantujuan_id',CHtml::listData($model->getRuanganItems($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'--Pilih--')); ?>
						</div>
					</div>					
                </fieldset>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
	<?php
		echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
		echo "&nbsp;";
		echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
								Yii::app()->createUrl($this->module->id.'/pengirimanrmT/informasi'), 
								array('class'=>'btn btn-danger',
									  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
		echo "&nbsp;"; 
		$content = $this->renderPartial('rekamMedis.views.tips.informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>

<?php $this->endWidget(); ?>

<!-- ======================== Begin Widget Dialog Login Pemakai ============================= -->
<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogPasien',
//    'options' => array(
//        'title' => 'Data Pasien',
//        'autoOpen' => false,
//        'modal' => true,
//        'width' => 1000,
//        'height' => 550,
//        'resizable' => false,
//    ),
//));
//
//$modPasien = new PasienM(); 
//$modPasien->unsetAttributes();
//if (isset($_GET['LoginpemakaiK'])){
//    $modPasien->attributes = $_GET['PasienM'];
//}
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//    'id'=>'pasien-grid',
//    'dataProvider'=>$modPasien->search(),
//    'filter'=>$modPasien,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'columns'=>array(
//                        array(
//                            'header'=>'Pilih',
//                            'type'=>'raw',
//                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
//                                            array(
//                                                    "class"=>"btn-small",
//                                                    "id" => "selectPasien",
//                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
//                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
//                                                                          \$(\"#dialogPasien\").dialog(\"close\");"
//                                             )
//                             )',
//                        ),
//                        'nama_pasien',
//                        'no_rekam_medik',
//                        'jeniskelamin',
//                        'tanggal_lahir',
//        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
//$this->endWidget(); ?>
<!-- =============================== endWidget Dialog Login Pemakai ============================ -->

<!-- =============================== BeginWidget Dialog Rekam Medik ============================ -->
<?php 
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogNoRekamMedik',
//    'options' => array(
//        'title' => 'Data Pasien',
//        'autoOpen' => false,
//        'modal' => true,
//        'width' => 1000,
//        'height' => 550,
//        'resizable' => false,
//    ),
//));
//
//$modPasien = new PasienM(); 
//$modPasien->unsetAttributes();
//if (isset($_GET['LoginpemakaiK'])){
//    $modPasien->attributes = $_GET['PasienM'];
//}
// $this->widget('ext.bootstrap.widgets.BootGridView',array(
//    'id'=>'norekammedik-grid',
//    'dataProvider'=>$modPasien->search(),
//    'filter'=>$modPasien,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'columns'=>array(
//                        array(
//                            'header'=>'Pilih',
//                            'type'=>'raw',
//                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
//                                            array(
//                                                    "class"=>"btn-small",
//                                                    "id" => "selectPasien",
//                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
//                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
//                                                                          \$(\"#dialogNoRekamMedik").dialog(\"close\");"
//                                             )
//                             )',
//                        ),
//                        'nama_pasien',
//                        'no_rekam_medik',
//                        'jeniskelamin',
//                        'tanggal_lahir',
//        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
// $this->endWidget(); ?>
<!-- =============================== endWidget Dialog Rekam Medik ============================ -->
