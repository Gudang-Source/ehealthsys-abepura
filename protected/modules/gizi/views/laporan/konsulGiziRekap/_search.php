<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
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

    #penjamin label.checkbox{
        width: 100px;
        display:inline-block;
    }
    label.checkbox, label.radio{
        width:200px;
        display:inline-block;
    }

</style>
<table widht="100%">
  
                <div class='row-fluid'>
                    <div class="span4">
                        <?php echo CHtml::label('Tanggal Kunjungan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
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
                </div>
            <table width="100%" border="0">
            <tr>
                <td> 
                    <div id='searching'>
                    <fieldset>    
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan',
                            'slide'=>true,
                            'content'=>array(
                            'content1'=>array(
                                'header'=>'Berdasarkan Ruangan',
                                'isi'=>  '  <table><tr></tr></table>
                                            <table class="penjamin">                                            
                                            <tr>
                                                    <td><div class="controls">'.
                        CHtml::checkBox('pilihSemua', true, array('onclick'=>'checkAllKelas();')).'<label><b>Pilih Semua</b></label>
                        <div id="checkBoxList">
                            '.$form->checkBoxList($model,'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll('instalasi_id IN (2,3,4) AND ruangan_aktif = TRUE ORDER BY instalasi_id'), 'ruangan_id', 'ruangan_nama'), array('class'=>'ruanganAsal')).'<br>
                        </div>                
                    </div></td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>											
                    </fieldset>	
                    </div>
                </td>
                										
                    </fieldset>	
                    </div>
                </td>
            </tr>
            </table>  
    
<!--    <div class="control-group">
        <?php //echo CHtml::label('Jenis Instalasi', 'instalasi', array('class'=>'control-label')); ?>
        <div class="controls">
         <?php echo $form->dropDownList($model,'instalasi',
         array(
                'RJ'=>'Rawat Jalan',
                'RD'=>'Rawat Darurat',
                'RI'=>'Rawat Inap',
              ),
        array(
                'empty'=>'--Pilih--',
                'id'=>'NamaInstalasi',
                'onChange'=>'setPeriode()',
                'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
              )
              );
        ?>   
        </div>
    </div>-->   
<div class="form-actions">
    <?php //echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', 
            // array('{icon}' => '<i class="icon-ok icon-white"></i>')),array('class' => 'btn btn-primary', 
            //     'type' => 'submit', 'id' => 'btn_simpan','onclick'=>'CekCaraBayar();return false;'));?>
    <?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
         'type' => 'GET', 
         'url' => array("/".$this->route), 
         'update' => '#rekap',
         'beforeSend' => 'function(){
                              $("#rekap").addClass("animation-loading");
                          }',
         'complete' => 'function(){
                              $("#rekap").removeClass("animation-loading");
                          }',
     ))); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',
                array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger',
                    'onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));?> 
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#ruanganAsal").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#GZLaporankonsultasigizirekapV_tgl_awal').val(data.periodeawal);
            $('#GZLaporankonsultasigizirekapV_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode',$js,CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event){
            var namaPeriode = $('#PeriodeName').val();

            if(namaPeriode == ''){
                myAlert('Pilih Kategori Pencarian');
                event.preventDefault();
                $('#dtPicker3').datepicker("hide");
                return true;
                ;
            }
        }
    function checkAllKelas(){
        if($('#pilihSemua').is(':checked')){
            $('#checkBoxList').each(function(){
                $(this).find('input').attr('checked',true);
            });
        }else{
            $('#checkBoxList').each(function(){
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAllKelas();
</script>