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
        #penjamin, #ruangan, #statusBayar{
            width:250px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox, #statusBayar label.checkbox{
            width: 120px;
            display:inline-block;
        }

    </style>
    <div class="row-fluid">
        <div class="span12">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Tanggal Pelayanan</legend>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::hiddenField('src', ''); ?>
                <div class = 'control-label'>Tanggal Pelayanan</div>
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
                <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
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
            </fieldset>
        </div>
        <div class="span12">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Cara Bayar </legend>
                <table width="100%" border="0">
                    <tr>
                        <td width="51">   
                            <div id='searching'>
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo $form->dropDownListRow($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'),array('empty'=>'-- Pilih --', 'autofocus'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                        </td>
                                    </tr>
									<tr>
                                        <td>
                                            <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3')); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php $model->carabayar_id = (!empty($model->carabayar_id))?$model->carabayar_id:1;?>
                                            <?php
        //                                    echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 

                                            echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'ajax' => array('type' => 'POST',
                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                                    'update' => '#penjamin', //selector to update
                                                ),
                                            ));
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="control-group ">
                                                <?php echo $form->labelEx($model, 'penjamin_id', array('class'=>'control-label')); ?>
                                                <div class="controls">
                                                    <div id="penjamin">
                                                        <?php echo $form->checkBoxList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('value' => 'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td width="51">   
                            <div id='searching'>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="control-group ">
                                                <?php // echo $form->labelEx($model, 'oasudahbayar_id', array('class'=>'control-label')); ?>
                                                <label class="control-label"> Status Bayar </label>
                                                <div class="controls">
                                                    <div id="statusBayar">
                                                        <?php //$model->statusbayar = array(true,false); ?>
                                                        <?php //echo $form->checkBoxList($model, 'statusbayar', array(true=>'Sudah Bayar', false=>'Belum Bayar'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                        <?php
                    //                            
                                                        echo $form->dropDownList($model, 'statusbayar', 
                                                            array('Sudah Bayar'=>'Sudah Bayar', 'Belum Bayar'=>'Belum Bayar'), 
                                                            array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")
                                                        );
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
        //                                    echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                                            echo $form->dropDownListRow($model, 'instalasiasal_nama', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_nama', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'ajax' => array('type' => 'POST',
                                                    'url' => $this->createUrl('GetRuanganAsalNamaForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                                    'update' => '#ruangan', //selector to update
                                                ),
                                            ));
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="control-group ">
                                                <?php echo $form->labelEx($model, 'ruanganasal_nama', array('class'=>'control-label')); ?>
                                                <div class="controls">
                                                    <div id="ruangan">
                                                       <label>Data Tidak Ditemukan</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>       
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
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
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPenjualanObat', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD); ?>
