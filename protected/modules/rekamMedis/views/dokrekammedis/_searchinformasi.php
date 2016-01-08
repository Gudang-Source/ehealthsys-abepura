<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmdokrekammedisrm-t-search',
                'type'=>'horizontal',
)); ?>
<div class="control-group ">
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php echo CHtml::label('Tanggal Rekam Medis','tgl_awal',array('class'=>'control-label')); ?>
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
                    </div><br /><br />
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
                    </div><br /><br />
                    <?php echo $form->dropDownListRow($model,'lokasirak_id',CHtml::listData($model->getLokasirakItems(),'lokasirak_id','lokasirak_nama'),array('empty'=>'-- Pilih --','class'=>'span2')); ?>
                    <?php echo $form->dropDownListRow($model,'subrak_id',CHtml::listData($model->getSubrakItems(),'subrak_id','subrak_nama'),array('empty'=>'-- Pilih --','class'=>'span2')); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'nodokumenrm',array('style'=>'width:70px','maxlength'=>11, 'autofocus'=>true)); ?>
                    <?php echo $form->textFieldRow($model,'nomortertier',array('style'=>'width:35px','maxlength'=>2)); ?>
                    <?php echo $form->textFieldRow($model,'nomorsekunder',array('style'=>'width:35px','maxlength'=>2)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'nomorprimer',array('style'=>'width:35px','maxlength'=>2)); ?>
                    <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span2')); ?>
                    <?php echo $form->dropDownListRow($model,'statusrekammedis',  LookupM::getItems('statusrekammedis'),array('empty'=>'-- Pilih --','style'=>'width:75px;')) ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->module->id.'/dokrekammedis/informasi'),array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
                $content = $this->renderPartial('../tips/informasi',array(),true);
                echo "&nbsp;";
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
	</div>
    </fieldset>
</div>

	

<?php $this->endWidget(); ?>

<!-- ======================== Begin Widget Dialog Login Pemakai ============================= -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php 
$modPasien = new PasienM(); 
$modPasien->unsetAttributes();
if (isset($_GET['LoginpemakaiK'])){
    $modPasien->attributes = $_GET['PasienM'];
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pasien-grid',
    'dataProvider'=>$modPasien->search(),
    'filter'=>$modPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectPasien",
                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
                                                                          \$(\"#dialogPasien\").dialog(\"close\");"
                                             )
                             )',
                        ),
                        'nama_pasien',
                        'no_rekam_medik',
                        'jeniskelamin',
                        'tanggal_lahir',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php $this->endWidget(); ?>