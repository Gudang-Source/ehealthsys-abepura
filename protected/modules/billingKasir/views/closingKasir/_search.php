<div class="search-form" style="">
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'POST',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'
            ),
        )
    );
?>
    <fieldset class="box">
        <legend class="rim">Filter Pencarian</legend>
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group">
                        <div class = 'control-label'>Tanggal Bukti Bayar</div>
                        <div class="controls">  
                            <?php
                                $this->widget('MyDateTimePicker',
                                    array(
                                        'model'=>$mBuktBayar,
                                        'attribute'=>'tgl_awal',
                                        'mode'=>'datetime',

                                        'options'=>array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly' => true,
                                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                                        'onchange'=>'setTanggalClosing()'),

                                        )
                                );
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class = 'control-label'>Sampai Dengan</div>
                        <div class="controls">  
                            <?php
                                $this->widget('MyDateTimePicker',
                                    array(
                                        'model'=>$mBuktBayar,
                                        'attribute'=>'tgl_akhir',
                                        'mode'=>'datetime',
                                        'options'=>array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly' => true,
                                        'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                    )
                                );
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php
                        echo $form->dropDownListRow($mBuktBayar, 'ruangan_id',
                            CHtml::listData(
                                $mBuktBayar->getRuanganKasir(), 'ruangan_id', 'ruangan_nama'
                            ),
                            array(
                                'inline'=>true,
                                'empty'=>'-- Pilih --',
                                'onkeypress'=>"return $(this).focusNextInputField(event)"
                            )
                        );
                    ?>
                    <?php
                        echo $form->dropDownListRow($mBuktBayar, 'shift_id',
                            CHtml::listData(ShiftM::model()->findAll(), 'shift_id', 'shift_nama'),
                            array(
                                'inline'=>true,
                                'empty'=>'-- Pilih --',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'onchange'=>'setFilterTanggalShift(this)',
                            )
                        );
                    ?>
                    <?php
                        $query = "
                            SELECT pegawai_m.* FROM loginpemakai_k 
                            JOIN ruanganpemakai_k ON ruanganpemakai_k.loginpemakai_id = loginpemakai_k.loginpemakai_id
                            JOIN pegawai_m ON loginpemakai_k.pegawai_id = pegawai_m.pegawai_id
                            WHERE ruanganpemakai_k.ruangan_id = ". Yii::app()->user->getState('ruangan_id') ."
                        ";
                        $pegawai = Yii::app()->db->createCommand($query)->queryAll();
                        echo $form->dropDownListRow($mBuktBayar, 'create_loginpemakai_id',
                            CHtml::listData($pegawai, 'pegawai_id', 'nama_pegawai'),
                            array(
                                'inline'=>true,
                                'empty'=>'-- Pilih --',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                            )
                        );
                    ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
        </div>
    </fieldset>
    <?php
        $this->endWidget();
    ?>
</div>
<script>
    function onReset() {
        window.open("<?php echo Yii::app()->createUrl($this->route); ?>","_self");
    }
    
    function setFilterTanggalShift(obj) {
        $.post('<?php echo $this->createUrl('setTglShift'); ?>', {id: $(obj).val()}, function(data)
        {
            $("#BKTandabuktibayarT_tgl_awal").val(data.awal);
            $("#BKTandabuktibayarT_tgl_akhir").val(data.akhir);
            
        }, 'json');
    }
    
    $(document).ready(function()
    {
        setFilterTanggalShift($("#BKTandabuktibayarT_shift_id"));
    });
</script>