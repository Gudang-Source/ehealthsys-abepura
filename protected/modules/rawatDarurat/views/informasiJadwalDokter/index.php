<div class="white-container">
    <legend class="rim2">Informasi <b>Jadwal Dokter</b></legend>
    <?php
    //$arrMenu = array();
     //               array_push($arrMenu,array('label'=>Yii::t('mds','Pencarian pasien'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //$this->menu=$arrMenu;
    //$this->widget('bootstrap.widgets.BootAlert');
    ?> 
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'carijadwal-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#RDJadwaldokterM_jadwaldokter_hari',
                    'method'=>'GET',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#carijadwal-form').submit(function(){
            $.fn.yiiGridView.update('pencarianjadwal-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");?>
    <div class="block-tabel">
        <h6>Tabel Informasi <b>Jadwal Dokter</b></h6>
        <?php echo $this->renderPartial($this->path_view.'_tableJadwalDokter', array('model'=>$model));  ?> 
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> <?php echo  Yii::t('mds','Pencarian Pasien') ?></legend>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'jadwaldokter_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'- Pilih -')); ?>
                    <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RDPendaftaran::model()->getRuanganItems(($_GET['r']=='rawatDarurat/InformasiJadwalDokter/Index')?Params::INSTALASI_ID_RD:Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                                          array('empty'=>'-- Pilih --',
                                                                'onchange'=>"listDokterRuangan(this.value)",
                                                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model,'pegawai_id', CHtml::listData(RDPendaftaran::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'jadwaldokter_mulai', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'jadwaldokter_mulai',
                                                    'mode'=>'time',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,
                                                                         'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                         ),
                            )); ?> <?php echo $form->error($model, 'jadwaldokter_mulai'); ?>

                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'jadwaldokter_tutup', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'jadwaldokter_tutup',
                                                    'mode'=>'time',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,
                                                                         'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                         ),
                            )); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>

                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)',
               'ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route), 
                 'update' => '#pencarianjadwal-grid',
                 'beforeSend' => 'function(){
                                      $("#pencarianjadwal-grid").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#pencarianjadwal-grid").removeClass("animation-loading");
                                  }',
             ))); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php $content = $this->renderPartial('rawatDarurat.views.tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'create','content'=>$content)); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>