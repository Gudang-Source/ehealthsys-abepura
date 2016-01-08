<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
     <style>

       label.checkbox{
                width:150px;
                display:inline-block;
            }

    </style>
    <?php echo CHtml::hiddenField('type', ''); ?>
    <?php //echo CHtml::hiddenField('src', ''); ?>
    <fieldset class="box2">
        <legend class="rim">Berdasarkan Tanggal</legend>
        <table width="100%" border="0">
            <tr>
                <td>
                    <div class = 'control-label'>Tanggal Pemakaian</div>
                        <div class="controls">  
                            <?php
                                $this->widget('MyDateTimePicker',array(
                                            'model' => $model,
                                            'attribute' => 'tgl_awal',
                                            'mode' => 'date',
											'options' => array(
												'maxDate'=>'d',
												'dateFormat' => Params::DATE_FORMAT,
											),
											'htmlOptions' => array('readonly' => true,
											'class'=>'dtPicker2',
											'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                            ?>
                     </div>
                </td>
                <td style="padding:0px 100px 0 0;">
                        <?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                            <div class="controls">  
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                                'model' => $model,
                                                'attribute' => 'tgl_akhir',
                                                'mode' => 'date',
												'options' => array(
													'maxDate'=>'d',
													'dateFormat' => Params::DATE_FORMAT,
												),
												'htmlOptions' => array('readonly' => true,
												'class'=>'dtPicker2',
												'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                ?>
                            </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <div id='searching'>
        <fieldset class="box2">
            <legend class="rim">Berdasarkan Jenis Obat</legend>
            <div class="controls">
                <?php
                    echo $form->CheckBoxList($model,'jenisobatalkes_id',CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'),'jenisobatalkes_id','jenisobatalkes_nama'));
                ?>
            </div>
        </fieldset>
    </div>
   
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
		<?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
?> 
    </div>   
</div>    

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
