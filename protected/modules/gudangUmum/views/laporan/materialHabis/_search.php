<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'laporan-search',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
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
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php /*<div class="span4">
                            <?php echo CHtml::hiddenField('type', ''); ?>
                            <?php echo CHtml::label('Tanggal Inventarisasi', 'tglterimabahan', array('class' => 'control-label')) ?>
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
                        </div>     */ ?>                   
                        <div class = "span6">
                            
                            <div class = "control-group">
                                <?php echo Chtml::label("Nama Barang",'barang_nama',array('class'=>'control-label')) ?>
                                <div class = "controls">
                                    <?php echo $form->textField($model, 'barang_nama',array('class'=>'span4')) ?>
                                </div>
                            </div>
                             <div class = "control-group">
                                <?php echo Chtml::label("Kode Barang",'barang_kode',array('class'=>'control-label')) ?>
                                <div class = "controls">
                                    <?php echo $form->textField($model, 'barang_kode',array('class'=>'span4')) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class = "span6">
                            <div class = "control-group">
                                <?php echo Chtml::label("No Seri",'barang_noseri',array('class'=>'control-label')) ?>
                                <div class = "controls">
                                    <?php echo $form->textField($model, 'barang_noseri',array('class'=>'span4')) ?>
                                </div>
                            </div>
                            <div class = "control-group">
                                <?php echo Chtml::label("Merk",'barang_merk',array('class'=>'control-label')) ?>
                                <div class = "controls">
                                    <?php echo $form->textField($model, 'barang_merk',array('class'=>'span4')) ?>
                                </div>
                            </div>
                        </div>
                        
                         <div class = "span12">
                            <div class = "control-group">
                                <?php echo Chtml::label("Stok Barang",'stok',array('class'=>'control-label')) ?>
                                <div class = "controls">
                                    <?php echo $form->dropDownList($model, 'stok',array('0'=>'Habis','1'=>'Stok Ada'),array('class'=>'span4','empty'=>'-- Pilih --')) ?>
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
						'id'=>'big',
						'slide'=>false,
						'content'=>array(
							'content2'=>array(
							'header'=>'Berdasarkan Instalasi dan Ruangan',
							'isi'=>'<table>
                                                                    <tr>
                                                                        <td>'.'<label>Instalasi</label></td>
                                                                        <td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                                'ajax' => array('type' => 'POST',
                                                                                        'url' => $this->createUrl('/ActionDynamic/GetRuanganForCheckBox/', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
                                                                                        'update' => '#ruangan',  //selector to update
                                                                                ),
                                                                        )).'
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                                <label>Ruangan</label>
                                                                        </td>
                                                                        <td>
                                                                                <div id="ruangan">
                                                                                        <label>Data Tidak Ditemukan</label>
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                 </table>',
							 'active'=>true
							),
						),
//                                    'htmlOptions'=>array('class'=>'aw',)
				)); ?>										
                    </fieldset>	
                    </div>
                </td>                  
                
            </tr>
            </table>   
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', 
                array('{icon}' => '<i class="entypo-search"></i>')),array('class' => 'btn btn-primary', 
                    'type' => 'submit', 'id' => 'btn_simpan'));?>
       <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#supplier").find("input").attr("checked", "checked");
 
',  CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#GZLaporanmakanangiziV_tgl_awal').val(data.periodeawal);
            $('#GZLaporanmakanangiziV_tgl_akhir').val(data.periodeakhir);
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
      
    
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#laporan-search input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#laporan-search input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
</script>