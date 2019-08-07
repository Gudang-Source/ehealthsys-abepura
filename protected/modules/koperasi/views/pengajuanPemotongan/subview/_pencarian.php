<div class =" row" id="panel-pencarian">		
            <div class="span6">
                    <div class="control-group">
                            <?php echo $form->label($permintaanv, 'tglAwal', array('class'=>'control-label col-sm-4')); ?>
                            <div class="controls">
                                    <!--<div class="input-group">-->
                                    <?php
                                    //$this->widget('bootstrap.widgets.TbDatePicker', array(
                                    //	'model'=>$permintaanv, 'attribute'=>'tglAwal', 'htmlOptions'=>array('disabled'=>!empty($no), 'class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
                            //	));
                                    ?>
                                         <?php   
                                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$permintaanv,
                                                'attribute'=>'tglAwal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                                    <!--<div class='input-group-addon' onclick="$('#PengajuanpembangsuranV_tglAwal').focus();">
                                            <a href='#'>
                            <i class='entypo-calendar'></i>
                                            </a>
                                    </div>
                                    </div>-->
                            </div>
                    </div>
                    <div class="control-group">
                            <?php echo $form->label($permintaanv, 'tglAkhir', array('class'=>'control-label col-sm-4')); ?>
                            <div class="controls">
                                    <!--<div class="input-group">-->
                                    <?php
                                    //$this->widget('bootstrap.widgets.TbDatePicker', array(
                                    //	'model'=>$permintaanv, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('disabled'=>!empty($no), 'class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
                                    //));
                                    ?>
                                     <?php   
                                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$permintaanv,
                                                'attribute'=>'tglAkhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                    )); ?>
                                    <!--<div class='input-group-addon' onclick="$('#PengajuanpembangsuranV_tglAkhir').focus();">
                                            <a href='#'>
                            <i class='entypo-calendar'></i>
                                            </a>
                                    </div>
                                    </div>-->
                            </div>
                    </div>
            </div>
            <div class="span6">
                <?php /*
                    <div class="form-group">
                            <?php echo $form->label($permintaanv, 'unit_id', array('class'=>'control-label col-sm-4')); ?>
                            <div class="col-sm-8">
                                    <?php echo $form->dropDownList($permintaanv, 'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true', 'order'=>'namaunit asc')), 'unit_id', 'namaunit'), array('disabled'=>!empty($no), 'empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
                            </div>
                    </div> */ ?>
                    <div class="control-group">
                            <?php echo $form->label($permintaanv, 'golonganpegawai_nama', array('class'=>'control-label col-sm-4')); ?>
                            <div class="controls">
                                    <?php echo $form->dropDownList($permintaanv, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true', 'order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'), array('disabled'=>!empty($no), 'empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
                            </div>
                    </div>
                    <div class="control-group">
                            <?php echo $form->label($permintaanv, 'potongansumber_id', array('class'=>'control-label col-sm-4')); ?>
                            <div class="controls">
                                    <?php echo $form->dropDownList($permintaanv, 'potongansumber_id', CHtml::listData(PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true', 'order'=>'namapotongan asc')), 'potongansumber_id', 'namapotongan'), array('empty'=>'-- Pilih --', 'disabled'=>!empty($no), 'class'=>'form-control')); ?>
                            </div>
                    </div>
            </div>
            
</div>
<div class="span12">
                    <?php //if (empty($no)) echo CHtml::button('<>Cari', array('class'=>'btn btn-primary', 'id'=>'btn-cari')); ?>
    <div class="form-actions">
        <?php  echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    </div>
</div> 	