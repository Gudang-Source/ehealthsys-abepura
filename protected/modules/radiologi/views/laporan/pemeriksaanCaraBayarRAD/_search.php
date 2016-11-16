<legend class = "rim"><i class = "entypo-search"></i> Pencarian :</legend>
<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'searchLaporan',
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
                            <?php echo CHtml::label('Tanggal Pendaftaran', 'tglterimabahan', array('class' => 'control-label')) ?>
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
<table style="width:100%">
    <tr>
        <td>
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'kunjungan',
                        'slide'=>true,
                                                            'content'=>array(
                            'content2'=>array(
                                'header'=>'Berdasarkan Cara Bayar',
                                'isi'=>'<table><tr>
                                            <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
                                            <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'ajax' => array('type' => 'POST',
                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                    'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
                                                ),
                                            )).'</td>
                                                </tr><tr>
                                            <td><label>Penjamin</label></td><td>'.
                                            $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>',            
                                'active'=>true,
                                ),
                        ),
            //                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>
        </td>
        <td>
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'dokter',
                                    'slide'=>true,
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                                    'content'=>array(
                                        'content3'=>array(
                                            'header'=>'Berdasarkan Tindakan',
                                            'isi'=> '<table >
                                                        <tr>
                                                        <td >'.$form->hiddenField($model,'daftartindakan_id')
                                                        .'<div class="input-append"><span class="add-on">'.$form->textField($model, 'daftartindakan_nama', array('id'=>'daftartindakan','data-offset-top'=>200,'data-spy'=>'affix','style'=>'margin-top:-3px; margin-left:-3px','inline'=>false, 
                                                        'onblur'=>'IdKosong(this)','onkeypress' => "return $(this).focusNextInputField(event)",'sourceUrl'=> $this->createUrl('/ActionDynamic/DaftarDokter/'),'placeholder'=>'Ketikan Nama Tindakan')).'<a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
                                                    <i class="icon-list"></i>
                                                    <i class="icon-search">
                                                    </i>
                                                    </a>
                                                    </span>
                                                    </div></td></tr></table>',                                                                                              
                                            'active'=>true,
                                            ),
                                    ),
                                    'htmlOptions'=>array('class'=>'aw',)
                            ));
                        
                        
                        echo CHtml::hiddenField('idSupplier');  ?>                           
        </td>
    </tr>    
</table>
	<div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<?php
/**
 * Dialog untuk nama Supplier
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTindakan = new ROTindakanRuanganM;
if(isset($_GET['ROTindakanRuanganM'])){
    $modTindakan->attributes = $_GET['ROTindakanRuanganM']; 
    $modTindakan->daftartindakan_kode = $_GET['ROTindakanRuanganM']['daftartindakan_kode'];
    $modTindakan->daftartindakan_nama = $_GET['ROTindakanRuanganM']['daftartindakan_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modTindakan->searchTindakanRuangan(),
	'filter'=>$modTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#ROLaporanrekaptransaksi_daftartindakan_id\").val(\"$data->daftartindakan_id\");
                                                      $(\"#daftartindakan\").val(\"$data->NamaTindakan\");
                                                      $(\"#dialogDokter\").dialog(\"close\");    
                                                      return false;
                                            "))',
                    ),
                array(
                    'header' => 'Kode Tindakan',
                    'name' => 'daftartindakan_kode',
                    'value' => '$data->daftartindakan->daftartindakan_kode',
                    'filter' => Chtml::activeTextField($modTindakan, 'daftartindakan_kode', array('class'=>'custom-only'))
                ),
                array(
                    'header' => 'Daftar Tindakan',
                    'name' => 'daftartindakan_nama',
                    'value' => '$data->daftartindakan->daftartindakan_nama',
                    'filter' => Chtml::activeTextField($modTindakan, 'daftartindakan_nama', array('class'=>'custom-only'))
                ),
                
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
    . '}',
));

$this->endWidget();
?>

<script>
//$(document).ready(function(){
    /*jQuery('#dokternama').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
        $("#idSupplier").val( ui.item.pegawai_id);
        $("#dokternama").val( ui.item.nama_pegawai );
        $("#ROLaporanrekaptransaksi_nama_pegawai").val( ui.item.nama_pegawai );
        return false;
        },'select':function( event, ui ) {
        $("#idSupplier").val( ui.item.pegawai_id);
        $("#namadokter").val( ui.item.pegawai_id);
        return false;
        },'source':'<?php //echo $this->createUrl('/ActionAutoComplete/DaftarDokter/'); ?>'}); */
      
        
    //});
    
    function IdKosong(obj)
    {
        //alert(obj.value);
         //$("#ROLaporanrekaptransaksi_daftartindakan_id").val('');
        if (obj.value == ''){            
            $("#ROLaporanrekaptransaksi_daftartindakan_id").val('');
        }  
    }
</script>