<div id="divSearch-form">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'rencana-t-search',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($model,'nostokopname'),
    )); ?> 
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Stock Opname','tglstokopname', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tgl_awal',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); 
                                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                            ?>
                        </div>
                </div>             
                <div class="control-group ">
                        <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                                    )); 
                                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                                ?>
                            </div>
                </div>                            
            </div>
            <div class="span4">
                <?php echo $form->textFieldRow($model,'nostokopname',array('placeholder'=>'Ketik No. Stock Opname','class'=>'angkahuruf-only')); ?>
                <?php echo $form->dropDownListRow($model, 'jenisstokopname', LookupM::getItems('jenisstokopname'),array('empty'=>'-- Pilih --')) ?>
            </div>    
            <div class="span4">
                
                <div class = "control-group">
                    <?php echo Chtml::label('Petugas Mengetahui','pegawaimengetahui_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'pegawaimengetahui_id', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --')) ?>
                    </div>
                </div>                               
                
                <div class = "control-group">
                    <?php echo Chtml::label('Petugas 1','petugas1_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'petugas1_id', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --')) ?>
                    </div>
                </div>
                
                 <div class = "control-group">
                    <?php echo Chtml::label('Petugas 2','petugas2_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'petugas2_id', Chtml::listData(PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"),'pegawai_id','namaLengkap'),array('empty'=>'-- Pilih --')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?><?php
               $content = $this->renderPartial($this->path_view.'tips/tipsInformasi',array(),true);
               $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>