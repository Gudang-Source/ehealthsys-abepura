<legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan : </legend>
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

        #caramasuk tr td label.checkbox{
            width: 190px;
            display:inline-block;
        }
        
        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }
        label.checkbox{
                width:200px;
                display:inline-block;
        }  

    </style>
        <div class="row-fluid">
            <div class="span4">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php echo CHtml::label('Periode Laporan', 'tglpasienpulang', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
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
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span2",
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
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => "span2",
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
                        echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
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
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span2",
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
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span2",
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
                        echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
            </div> 
        </div> 
        <table width="100%" border="0">
            <tr>
                <td>
                    <div id='searching'>
                        <fieldset>
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'form-2',
					'content'=>array(
						'content2'=>array(
							'header'=>'Berdasarkan Cara Masuk',
							'isi'=>'<table>'
                                                                . '<td>'.CHtml::hiddenField('filter', 'caramasuk').CHtml::checkBox('cek_all', true, array('value'=>'cek', 'onchange'=>'cek_all_tindakan(this)')).' Pilih Semua</td></tr></table>
                                                            <table id="caramasuk"><tr>								
								<td>'.$form->checkBoxList($model, 'caramasuk_id', CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")).'</td>
									</tr></table>',           
							'active'=>true,
						),   
					),
			)); ?>
                           
                        </fieldset>
                    </div>
            </td>              
                <td>
                     <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan1',
                            'slide'=>true,
                            'content'=>array(
                            'content4'=>array(
                                'header'=>'Berdasarkan Kondisi Pulang',
                                'isi'=>  CHtml::hiddenField('filter', 'kondisipulang').CHtml::checkBox('cek_all', true, array("id"=>"checkSemuaid",'value'=>'cek', "onclick"=>"checkSemua()")).'Pilih Semua <br\>                                             
                                            <table class="kondisipulang">                                            
                                            <tr>
                                                    <td>'.
                                                           $form->checkBoxList($model, 'kondisikeluar_id', CHtml::listData(KondisiKeluarM::model()->findAll(" kondisikeluar_aktif = TRUE AND carakeluar_id = '".Params::CARAKELUAR_ID_MENINGGAL."' ORDER BY kondisikeluar_nama ASC"), 'kondisikeluar_id', 'kondisikeluar_nama'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>false,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>	                    
                </td>                              
            </tr>
        </table>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            ?>
        </div>
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
', CClientScript::POS_READY);
?>
<script type="text/javascript">
    function cek_all_tindakan(obj){
        if($(obj).is(':checked')){
            $("#caramasuk").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#caramasuk").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }        
    
    function checkSemua() {
            if ($("#checkSemuaid").is(":checked")) {
                $('.kondisipulang input[name*="RILaporanpasienmeninggalriV"]').each(function(){
                   $(this).attr('checked',true);
                })
            } else {
               $('.kondisipulang input[name*="RILaporanpasienmeninggalriV"]').each(function(){
                   $(this).removeAttr('checked');
                })
            }
            //setAll();
    }
    
    cek_all_tindakan($("#cek_all"));
    checkSemua();
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>