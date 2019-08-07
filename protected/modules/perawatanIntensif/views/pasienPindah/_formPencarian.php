<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nama_pasien'),
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

)); ?>
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Pindah
                    </label>
                    <div class="controls">
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                        <?php   $format = new MyFormatter;
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        ));?>
                    </div>
                </div>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                         <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                         <?php  
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',  ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                    </div>
                </div>                
                 <?php //echo $form->dropDownListRow($model,'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 
            </td>
            <td>
                <div class="control-group">
                        <?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>                        
                            <div class="controls">
                                
                                <?php 
                                       
                                        $prefix = array(
                                            0 => Params::PREFIX_RAWAT_DARURAT,
                                            1 => Params::PREFIX_RAWAT_INAP,
                                            2 => Params::PREFIX_RAWAT_JALAN
                                        );

                                    echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                                ?>
                                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
                            </div>                        
                    </div>
                 <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>12)); ?>
                <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                 <?php //echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Ketik Nama Alias','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                 <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6)); ?>
                
                <div class = "">
                        <?php echo Chtml::label("Dokter PJP", 'nama_pegawai', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php //echo $form->textField($model,'nama_pegawai',array('placeholder'=>'Ketik Dokter PJP','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                        <?php //echo $form->dropDownList($model, 'nama_pegawai' ,  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'nama_pegawai', 'namaLengkap') ,array('empty' => '-- Pilih --')) ?>
                        <?php
                         echo $form->hiddenField($model,'namaDokter',array('placeholder'=>'Ketik Dokter PJP','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                            $this->widget('MyJuiAutoComplete',array(
                                'attribute'=>'nama_pegawai',    
                                'model'=>$model,
                                'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/ListDokter'),
                                'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val( ui.item.nama_pegawai);
                                        $("#'.CHtml::activeId($model,'namaDokter').'").val( ui.item.nama_pegawai);                                        
                                        return false;
                                    }',
                                    'select'=>'js:function( event, ui ) {                                     
                                            $("#'.CHtml::activeId($model,'namaDokter').'").val( ui.item.nama_pegawai);         
                                              }'

                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('onblur'=>'cekClear();','placeholder'=>'Ketik Dokter PJP','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'hurufs-only'),
                                ));
                        ?>
                    </div>
                </div>
            </td>
            <td> 
                <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
																'ajax' => array('type'=>'POST',
																	'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
			//                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
																	'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
																),
																'class'=>'span3',
				)); ?>
                 <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                <div class = "control-group">
                        <?php echo CHtml::label("Ruangan Tujuan",'ruangan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 
                            $ruangan = RIPasienAdmisiT::model()->getRuanganCustom(
                                    array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU),
                                    array(Yii::app()->user->getState('ruangan_id'))
                                    );                            
                        
                            echo $form->dropDownList($model,'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama') ,

                                         array('empty'=>'-- Pilih --',
                                               'onkeypress'=>"return $(this).focusNextInputField(event)",
                                               'class'=>'span2',
                                             'onchange' => 'getKelasPelKamarRuangan(this);'
                                             )); ?>
                    </div>
                </div>
                    <div class="control-group">
                    <?php echo Chtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kelaspelayanan_id', array(), array('empty'=>'-- Pilih --', 'class' => 'span2')); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo Chtml::label("Kamar Ruangan", 'kamarruangan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kamarruangan_id', array(), array('empty'=>'-- Pilih --', 'class' => 'span2')); ?>
                    </div>
                </div>
                
            </td>
        </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');

?>
&nbsp;
<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>&nbsp;
<?php 
        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang2'
        );
           $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
<?php $this->endWidget();?>
</fieldset>  
<script>
document.getElementById('RIPasienriyangpindahV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('RIPasienriyangpindahV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#RIPasienriyangpindahV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RIPasienriyangpindahV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RIPasienriyangpindahV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RIPasienriyangpindahV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RIPasienriyangpindahV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}

function cekClear(){
    var nama_pegawai = $("#RIPasienriyangpindahV_nama_pegawai").val();
    
    if (nama_pegawai == ''){
        $("#RIPasienriyangpindahV_namaDokter").val('');
    }
}

function getKelasPelKamarRuangan(obj)
{
    var ruangan_id = $(obj).val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/ActionAjax/GetKelasPelKamarRuangan'); ?>',
        data: {ruangan_id:ruangan_id},
        dataType: "json",
        success:function(data){           
            $("#RIPasienriyangpindahV_kelaspelayanan_id").find('option').remove().end().append(data.kelasPelayanan);
            $("#RIPasienriyangpindahV_kamarruangan_id").find('option').remove().end().append(data.kamarRuangan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);
            
    }
    });
}
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
if(isset($_GET['DokterV'])){
    $modDokter->attributes = $_GET['DokterV'];    
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modDokter->searchAllDokter(),
    'filter'=>$modDokter,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"                            
                            $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->namaLengkap\");                            
                            $(\"#'.CHtml::activeId($model,'namaDokter').'\").val(\"$data->nama_pegawai\");                            
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class'=>'numbers-only')),
        ),
         array(
            'name'=>'nama_pegawai',
            'header'=>'Nama Dokter',
            'value'=>'$data->namaLengkap',
             'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class'=>'hurufs-only')),
         ),       
        array(
            'header'=>'Jabatan',            
            'name'=>'jabatan_id',            
            'value' => function($data){
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                
                if ( count($j) > 0 ){
                    return $j->jabatan_nama;
                }else{
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
         ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
    . '}',
));
        
$this->endWidget();
?>