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

   label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }

    </style>
  <table>
            <tr>
            <td>
                <div class="control-group">
                    <div class="control-label"> Tanggal Pendaftaran </div>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'bulan',
                            array(
                                'hari'=>'Hari Ini',
                                'bulan'=>'Bulan',
                                'tahun'=>'Tahun',
                            ),
                            array(
                                'empty'=>'--Pilih--',
                                'id'=>'PeriodeName',
                                'onChange'=>'setPeriode()',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
                            )
                            );
                        ?>
                    </div>
                </div>
            </td>
            <td width="250px">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php echo CHtml::hiddenField('filter_tab', 'global'); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </td>
            <td width="50px">s/d</td>
            <td>
                <?php
                    $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3','onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <div class="control-label"> Instalasi </div>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'instalasi',
                            array(
                                'rawat_jalan'=>'Rawat Jalan',
                                'rawat_inap'=>'Rawat Inap',
                                'ugd'=>'UGD',
                            ),
                            array(
                                'empty'=>'--Pilih--',
                                'id'=>'instalasi',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
                            )
                            );
                        ?>
                    </div>
                </div>
            </td>
        </tr>
  </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('LaporanRekapTransaksi'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
</div>    
<?php $this->endWidget(); ?>
