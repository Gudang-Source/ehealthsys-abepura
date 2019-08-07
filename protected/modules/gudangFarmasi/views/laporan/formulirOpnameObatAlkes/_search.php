<legend class = "rim"><i class = "entypo-search"></i> Pencarian :</legend>
<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search-laporan',
        'type'=>'horizontal',
)); ?>
           <style>

        #penjamin label.checkbox{
            width: 200px;
            display:inline-block;
        }
        label.checkbox, label.radio{
            width:260px;
            display:inline-block;
        }

    </style>
    
                    <div class="row-fluid">
                        <div class="span4">
                            <?php echo CHtml::hiddenField('type', ''); ?>
                            <?php echo CHtml::label('Tanggal Formulir', 'tglterimabahan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('onchange'=>'ubahJnsPeriode();')); ?>
                            </div>
                        </div>
                        <div class="span4">
                            <div class='control-group hari'>
                                <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                                <div class="controls">  
                                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                                   <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_awal',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate'=>'d',
                                        ),
                                        'htmlOptions' => array('readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                    ?>
                                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                                </div> 

                            </div>
                            <div class='control-group bulan'>
                                <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                                    <?php 
                                        $this->widget('MyMonthPicker', array(
                                            'model' => $model,
                                            'attribute' => 'bln_awal', 
                                            'options'=>array(
                                                'dateFormat' => Params::MONTH_FORMAT,
                                            ),
                                            'htmlOptions' => array('readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));  
                                    ?>
                                    <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                                </div> 
                            </div>
                            <div class='control-group tahun'>
                                <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php 
                                    echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('onkeypress' => "return $(this).focusNextInputField(event)")); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class='control-group hari'>
                                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                                <div class="controls">  
                                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_akhir',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate'=>'d',
                                        ),
                                        'htmlOptions' => array('readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                                    ));
                                    ?>
                                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                                </div> 
                            </div>
                            <div class='control-group bulan'>
                                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                                <div class="controls"> 
                                    <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                                    <?php 
                                        $this->widget('MyMonthPicker', array(
                                            'model' => $model,
                                            'attribute' => 'bln_akhir', 
                                            'options'=>array(
                                                'dateFormat' => Params::MONTH_FORMAT,
                                            ),
                                            'htmlOptions' => array('readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                                        ));  
                                    ?>
                                    <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                                </div> 
                            </div>
                            <div class='control-group tahun'>
                                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php 
                                    echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('onkeypress' => "return $(this).focusNextInputField(event)")); 
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="span12">                        
                            <div class="control-group">
                                <?php echo Chtml::label("No Formulir",'noformulir', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'noformulir', array('class'=>'span4 angkahuruf-only')) ?>
                                </div>
                            </div>
                            
                             <div class="control-group">
                                <?php echo Chtml::label("Status Stok",'status', array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList($model, 'status', array('2'=>'Belum Stok Opname','1'=>'Sudah Stok Opname'),array('empty'=>'-- Pilih --','class'=>'span4')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
       
</table>
	<div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>