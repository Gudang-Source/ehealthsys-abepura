<script type="text/javascript">
    function reseting()
    {
        setTimeout(function(){
            $.fn.yiiGridView.update('lapegawai-m-grid', {
                    data: $('#lapegawai-m-search').serialize()
            });
        },1000);

    }   
</script>
<fieldset class="box">
    
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'lapegawai-m-search',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'nomorindukpegawai'),
        )
    );
    ?>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                       // $format = new MyFormatter();
                       // $tgl_awal = date('Y-m-d', strtotime($model->tglpresensi));
                       // $model->tglpresensi= $format->formatDateTimeForUser($tgl_awal);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?> 
                </div>
            </div>
            
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        //$tgl_akhir = date('Y-m-d', strtotime($model->tglpresensi_akhir));
                        //$model->tglpresensi_akhir= $format->formatDateTimeForUser($tgl_akhir);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi_akhir',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?>
                </div>
            </div>  
                
                <?php
                    /*echo $form->dropDownListRow(
                        $model,'unit_perusahaan',LookupM::getItems('unit_perusahaan'),
                        array('class'=>'span3', 'empty'=>'-- Pilih --')
                    );*/
                ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true ORDER BY kelompokpegawai_nama ASC'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --')); ?>                
                <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --')); ?>                
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('Laporan/LaporanPegawai'), array('class'=>'btn btn-danger'));
                 
         ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#lapegawai-m-search').submit(function(){
    $.fn.yiiGridView.update('lapegawai-m-grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>