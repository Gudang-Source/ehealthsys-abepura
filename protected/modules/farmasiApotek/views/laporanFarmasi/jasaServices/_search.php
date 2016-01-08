<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus' => '#FAPenjualanResepT_pegawai_id',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        #penjamin, #ruangan{
            width:650px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <table width="100%" style="margin-top:10px;">
        <tr>
            <td>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::hiddenField('src', ''); ?>
                <?php echo CHtml::label('Tanggal Penjualan', 'tgl_awal', array('class'=>'control-label')); ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
//                                          'maxDate'=>'d',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div>
<!--                <div class="control-group">
                    <?php //echo $form->labelEx($model, 'no_rekam_medik', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php //echo $form->textField($model, 'no_rekam_medik', array('class'=>'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo $form->labelEx($model, 'no_pendaftaran', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_pendaftaran', array('class'=>'span2')); ?>
                    </div>
                </div>-->
            </td>
            <td> <?php echo CHtml::label('Sampai dengan', ' tgl_akhir', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
//                                         'maxdate'=>'d',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 
<!--                <div class="control-group">
                    <?php //echo $form->labelEx($model, 'nama_pasien', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php //echo $form->textField($model, 'nama_pasien', array('class'=>'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo $form->labelEx($model, 'noresep', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php //echo $form->textField($model, 'noresep', array('class'=>'span2')); ?>
                    </div>
                </div>-->
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Dokter','pegawai_id', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(PegawaiM::model()->findAll(array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),array('class'=>'span3', 'empty'=>'-- Pilih Nama Dokter --')); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type'=>'reset'));
        ?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPemakaianKategoriObat', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD); ?>