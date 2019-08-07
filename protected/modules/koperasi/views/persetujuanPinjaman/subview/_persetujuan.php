<div class="span12">        
        <div class="span6">
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'tgl disetujui', array('class'=>'control-label col-sm-2')); ?>
                        <div class="controls">
                                <?php
                               // $this->widget('bootstrap.widgets.TbDateTimePicker', array(
                               //         'model'=>$approval, 'attribute'=>'tglapproval', 'htmlOptions'=>array('class'=>'form-control tanggal'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
                              //  ));
                                ?>
                            
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$approval,
                                    'attribute'=>'tglapproval',
                                    'mode'=>'date',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
                        </div>
                       
                </div>
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'cara_bayar', array('class'=>'control-label col-sm-2')); ?>
                        <div class="controls">
                                <?php echo CHtml::activeDropDownList($approval, 'cara_bayar', Params::caraBayarPinjaman(), array('class'=>'form-control')); ?>
                        </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'keterangan approval', array('class'=>'control-label col-sm-2')); ?>
                        <div class="controls">
                                <?php echo CHtml::activeTextArea($approval,'keteranganapproval',array('rows'=>3, 'cols'=>50, 'class'=>'form-control','style'=>'resize:none;')); ?>
                        </div>
                </div>
        </div>
    <div class = "span6">
        <div class="controls">
                                <?php echo CHtml::activeDropDownList($approval, 'status_disetujui', array(true=>'Diterima', false=>'Ditolak'), array('class'=>'form-control')); ?>
        </div>
    </div>
        <hr style="border: 1px solid #eee;">
        <div class="span6">
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'diperiksa', array('class'=>'control-label col-sm-3')); ?>
                        <div class="controls">
                                <?php 
                                $this->widget('MyJuiAutoComplete',array(
                                            'attribute'=>'appr_diperiksaoleh_id',
                                            'model'=>$approval,
                                            'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                                            'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 4,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $("#ApprovalT_appr_diperiksaoleh_id").val( ui.item.value );
                                                    return false;
                                                }', 
                                               'select'=>'js:function( event, ui ) {
                                                    loadAnggotaPegawai(ui.item.attr);
                                                }',

                                            ),
                                            'htmlOptions'=>array('readonly'=>true, 'placeholder'=>'Pemeriksa','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                                            'tombolModal'=>array('idModal'=>'dialog_pengurus','idTombol'=>'tombolAnggota', 'jsFunction'=>"$('#pengurus-switcher').val('diperiksaoleh'); $('#dialog_pengurus').modal('show');"),

                                ));
                                ?>
                        </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'tanggal', array('class'=>'control-label col-sm-3')); ?>
                        <div class="controls">
                                <?php
                                //$this->widget('bootstrap.widgets.TbDateTimePicker', array(
                                   //     'model'=>$approval, 'attribute'=>'appr_tgldiperiksa', 'htmlOptions'=>array('class'=>'form-control tanggal'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
                                //));
                                ?>
                            
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$approval,
                                    'attribute'=>'appr_tgldiperiksa',
                                    'mode'=>'date',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
                        </div>
                </div>
        </div>
        <div class="span6">
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'disetujui', array('class'=>'control-label col-sm-3')); ?>
                        <div class="controls">
                                <?php 
                                $this->widget('MyJuiAutoComplete',array(
                                            'attribute'=>'appr_disetujuioleh_id',
                                            'model'=>$approval,
                                            'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                                            'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 4,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $("#ApprovalT_appr_disetujuioleh_id").val( ui.item.value );
                                                    return false;
                                                }', 
                                               'select'=>'js:function( event, ui ) {
                                                    loadAnggotaPegawai(ui.item.attr);
                                                }',

                                            ),
                                            'htmlOptions'=>array('readonly'=>true, 'placeholder'=>'Penyetujui','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                                            'tombolModal'=>array('idModal'=>'dialog_pengurus','idTombol'=>'tombolAnggota', 'jsFunction'=>"$('#pengurus-switcher').val('disetujuioleh'); $('#dialog_pengurus').modal('show');"),

                                ));
                                ?>
                        </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::activeLabel($approval, 'tanggal', array('class'=>'control-label col-sm-3')); ?>
                        <div class="controls">
                                <?php
                               // $this->widget('bootstrap.widgets.TbDateTimePicker', array(
                                 //       'model'=>$approval, 'attribute'=>'appr_tgldisetujui', 'htmlOptions'=>array('class'=>'form-control tanggal'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
                               // ));
                                ?>
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$approval,
                                    'attribute'=>'appr_tgldisetujui',
                                    'mode'=>'date',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
                        </div>
                </div>
                <?php echo CHtml::hiddenField('pengurus-switcher'); ?>
                <?php echo CHtml::activeHiddenField($approval, 'appr_diperiksaoleh_id', array('id'=>'diperiksaoleh_id')); ?>
                <?php echo CHtml::activeHiddenField($approval, 'appr_disetujuioleh_id', array('id'=>'disetujuioleh_id')); ?>
        </div>
</div>          
            
