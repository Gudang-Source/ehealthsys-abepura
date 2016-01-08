<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));
?>
<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0){
    Yii::app()->user->setFlash('success',"Transaksi Pemakaian Ambulans berhasil disimpan !");
}

?>
<div class="white-container">
    <legend class="rim2">Transaksi Pemakaian <b>Mobil Jenazah</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'pemakaianambulans-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                                 'onsubmit'=>'return cekValidasi();'),
            'focus'=>'#'.CHtml::activeId($modPemakaian,'norekammedis'),
    )); ?>
    <?php echo $form->errorSummary($modPemakaian); ?>
    
    <?php echo CHtml::activeHiddenField($modPemakaian,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php echo CHtml::activeHiddenField($modPemakaian,'pesanambulans_t',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <fieldset class="box" id="form-datakunjungan">
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <legend class="rim"><span class='judul'>Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial('_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan,'format'=>$format,'modPemakaian'=>$modPemakaian)); ?>
        </div>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Pemakaian Mobil Jenazah</legend>
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Pemakaian Mobil Jenazah', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('MyDateTimePicker',array(
                                                                  'model'=>$modPemakaian,
                                                                  'attribute'=>'tglpemakaianambulans',
                                                                  'mode'=>'datetime',
                                                                  'options'=> array(
                                                                      'dateFormat'=>Params::DATE_FORMAT,
                                                                      //'minDate' => 'd',
                                                                  ),
                                                                  'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                                          )); 
                            ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modPemakaian,'tglkembaliambulans',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo CHtml::activeLabel($modPemakaian, 'Tanggal Kembali Mobil Jenazah', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('MyDateTimePicker',array(
                                'model'=>$modPemakaian,
                                'attribute'=>'tglkembaliambulans',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'minDate' => 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>false,'class'=>'dtPicker2-5'),
                                )); 
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'Untuk_keperluan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian,'untukkeperluan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <div class="control-label">
                            Ruangan <font style="color:red"> * </font>
                        </div>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('instalasi', $instalasi, CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                                                            array('empty' =>'-- Instalasi --',
                                                                  'ajax'=>array('type'=>'POST',
                                                                                'url'=>  CController::createUrl('dynamicRuangan'),
                                                                                'update'=>'#PJPemakaianambulansT_ruangan_id',),'class'=>'span2 reqPasien')); ?>
                            <?php echo CHtml::activeDropDownList($modPemakaian, 'ruangan_id',  CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi),'ruangan_id','ruangan_nama'),array('empty' =>'-- Ruangan --','class'=>'span2 reqPasien')); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'tempat_tujuan <span class="required">*</span>', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian,'tempattujuan',array('class'=>'span3 reqPasien','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'alamat_tujuan <span class="required">*</span>', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPemakaian,'alamattujuan',array('class'=>'span3 reqPasien','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php //echo $form->textFieldRow($modPemakaian,'nomobile',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                    <?php //echo $form->textFieldRow($modPemakaian,'notelepon',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>

                    <?php //echo $form->textFieldRow($modPemakaian,'supir_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'supir_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPemakaian,'supir_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textField($modPemakaian,'supir_nama',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>


                                                    <?php
                                echo CHtml::htmlButton('<i class="icon-search icon-white"></i> <i class="icon-white icon-chevron-right"></i> ', array('class' => 'btn btn-search', 'onclick' => "$('#dialogSupir').dialog('open');",
                                    'id' => 'btnAddSupir', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('supir_id')))
                            ?>
                            <?php echo $form->error($modPemakaian, 'supir_id'); ?>
                        </div>
                    </div>

                    <?php //echo $form->textFieldRow($modPemakaian,'pelaksana_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'pelaksana_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPemakaian,'pelaksana_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textField($modPemakaian,'pelaksana_nama',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php
                                echo CHtml::htmlButton('<i class="icon-search icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-search', 'onclick' => "$('#dialogPelaksana').dialog('open');",
                                    'id' => 'btnAddPelaksana', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('pelaksana_id')))
                            ?>
                            <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
                        </div>
                    </div>

                    <?php //echo $form->textFieldRow($modPemakaian,'paramedis1_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'paramedis1_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPemakaian,'paramedis1_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textField($modPemakaian,'paramedis1_nama',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php
                                echo CHtml::htmlButton('<i class="icon-search icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-search', 'onclick' => "$('#dialogParamedis').dialog('open');$('#dialogParamedis #paramedisKe').val(1);",
                                    'id' => 'btnAddParamedis1', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('paramedis1_id')))
                            ?>
                            <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
                        </div>
                    </div>

                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'paramedis2_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($modPemakaian,'paramedis2_id',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->textField($modPemakaian,'paramedis2_nama',array('readonly'=>true, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php
                                echo CHtml::htmlButton('<i class="icon-search icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-search', 'onclick' => "$('#dialogParamedis').dialog('open');$('#dialogParamedis #paramedisKe').val(2);",
                                    'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('paramedis2_id')))
                            ?>
                            <?php echo $form->error($modPemakaian, 'paramedis2_id'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modPemakaian,'tglpemakaianambulans',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <table width="100%">
        <tr>
            <td width="50%">
                <fieldset class="box">
                    <legend class="rim">Data Penanggung Jawab</legend>		   
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'Nama', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian,'namapj',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </div>
                    </div>   
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'Hubungan', array('class' => 'control-label refreshable')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPemakaian,'hubunganpj', LookupM::getItems('hubungankeluarga'),array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
                        </div>
                    </div>   
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPemakaian, 'Alamat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPemakaian,'alamatpj',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </div>
                    </div>
					<div class="control-group ">
						<?php echo $form->labelEx($modPemakaian,'rt_rw', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->textField($modPemakaian,'rt',array('class'=>'span1 numbers-only reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?> /
						   <?php echo $form->textField($modPemakaian,'rw',array('class'=>'span1 numbers-only reqPasien', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?>
							<?php echo $form->error($modPemakaian, 'rt_rw'); ?>
						</div>
						<?php echo $form->error($modPemakaian, 'rt_rw'); ?>
					</div>
                </fieldset>
            </td>
            <td>
                <?php //echo $form->textFieldRow($modPemakaian,'namapj',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php //echo $form->dropDownListRow($modPemakaian,'hubunganpj', LookupM::getItems('hubungankeluarga'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --')); ?>
                <?php //echo $form->textAreaRow($modPemakaian,'alamatpj',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textAreaRow($modPemakaian,'untukkeperluan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <fieldset class="box">
                    <legend class="rim">Pemakaian Mobil Jenazah</legend>
                        <div class="control-group ">
                            <?php echo $form->labelEx($modPemakaian, 'mobil_Jenazah', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modPemakaian,'mobilambulans_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textField($modPemakaian,'mobilambulans_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php
                                    echo CHtml::htmlButton('<i class="icon-search icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-search', 'onclick' => "$('#dialogKendaraan').dialog('open');",
                                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari ' . $modPemakaian->getAttributeLabel('mobilambulans_id')))
                                ?>
                                <?php echo $form->error($modPemakaian, 'mobilambulans_id'); ?>
                            </div>
                        </div>

                        <div class="control-group ">
                            <?php echo $form->labelEx($modPemakaian, 'km awal', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemakaian,'kmawal',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->error($modPemakaian, 'kmawal'); ?> sampai dengan <span style="font-size:11px;"><?php echo $modPemakaian->getAttributeLabel('km_akhir'); ?></span>
                                <?php echo $form->textField($modPemakaian,'kmakhir',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->error($modPemakaian, 'kmakhir'); ?>
                            </div>
                        </div>
                        <?php //echo $form->textFieldRow($modPemakaian,'mobilambulans_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($modPemakaian,'kmawal',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($modPemakaian,'kmakhir',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
						<div class="control-group ">
                            <?php echo $form->labelEx($modPemakaian, 'Jml bbm liter', array('class' => 'control-label')) ?>
                            <div class="controls">
                        <?php echo $form->textField($modPemakaian,'jmlbbmliter',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>  
                </fieldset>
            </td>
        </tr>
    </table>   
    <div class="block-tabel">
        <h6>Tarif <b>Mobil Jenazah</b>  
                <?php
                    echo CHtml::htmlButton('<i class="icon-search icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-search', 'onclick' => "$('#dialogTarif').dialog('open');",
                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari Tarif Ambulans'))
                ?>
        </h6>
            <?php //echo $form->textFieldRow($modPemakaian,'jumlahkm',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($modPemakaian,'tarifperkm',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($modPemakaian,'totaltarifambulans',array('class'=>'span1 number', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <table id="tblTarifAmbulans" class="table table-striped">
            <thead>
                <tr>
                    <th colspan="4" style='vertical-align:middle;text-align:center;'>Tujuan</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:center;'>Jumlah Km</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:center;'>Tarif / Km</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:center;'>Total Tarif</th>
                </tr>
                <tr>
                    <th>Propinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0;$i<count($tarif['tarifAmbulans']);$i++) : ?>
                <?php if(!empty($tarif['tarifAmbulans'][$i])){ ?>
                <tr>
                    <td><input type="text" value="<?php echo $tarif['propinsi'][$i]; ?>" name="tarif[propinsi][]" class="span2" /></td>
                    <td><input type="text" value="<?php echo $tarif['kabupaten'][$i]; ?>" name="tarif[kabupaten][]" class="span2" /></td>
                    <td><input type="text" value="<?php echo $tarif['kecamatan'][$i]; ?>" name="tarif[kecamatan][]" class="span2" /></td>
                    <td><input type="text" value="<?php echo $tarif['kelurahan'][$i]; ?>" name="tarif[kelurahan][]" class="span2" /></td>
                    <td><input type="text" value="<?php echo $tarif['jmlKM'][$i]; ?>" name="tarif[jmlKM][]" class="span1 number" />
                        <input type="hidden" value="<?php echo $tarif['daftartindakanId'][$i]; ?>" name="tarif[daftartindakanId][]" class="span1 number" /></td>
                    <td><input type="text" value="<?php echo $tarif['tarifKM'][$i]; ?>" name="tarif[tarifKM][]" class="span1 currency" /></td>
                    <td><input type="text" value="<?php echo $tarif['tarifAmbulans'][$i]; ?>" name="tarif[tarifAmbulans][]" class="span2 currency" /></td>
                </tr>
                <?php } ?>
                <?php endfor;?>
            </tbody>
        </table>
    </div>
    
    <?php $this->renderPartial('_formPemakaianBahan',array()); ?>
    
    <div class="form-actions">
                <?php 
                    if(isset($_GET['sukses'])){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'disabled'=>true,'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                    }
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/pemakaianMobil/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda ingin mengulang ?').'")) return false;')); ?>
							  		<?php 
$content = $this->renderPartial('../tips/transaksi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div>

<?php $this->endWidget(); ?>
    
<script type="text/javascript">
//$('.number').each(function(){this.value = formatNumber(this.value)});
//$('.currency').each(function(){this.value = formatNumber(this.value)});
function clearDataPasien()
{
    $("#<?php echo CHtml::activeId($modPemakaian, 'pasien_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modPemakaian, 'norekammedis') ?>").val('');
    $("#<?php echo CHtml::activeId($modPemakaian, 'noidentitas') ?>").val('');
}

function cekValidasi(){
    var kosong = '';
    var reqPasien = $("#pemakaianambulans-t-form").find(".reqPasien[value="+kosong+"]");
    var pasienKosong = reqPasien.length;
    var tarif = $("#tblTarifAmbulans > tbody > tr");
    var tarifkosong = tarif.length;
    if(pasienKosong != 0){
        myAlert ('Harap Isi Semua Bagian Yang Bertanda * pada Data Transaksi Pemakaian Mobil Jenazah');
        return false;
    }else{
		if(tarifkosong != 0){
			$('.currency').each(function(){this.value = unformatNumber(this.value)});
			$('.number').each(function(){this.value = unformatNumber(this.value)});
			return true;
		}else{
			myAlert ('Harap Isi Tarif Mobil Jenazah');
			return false;
		}
    }
    return false;
}

function setRuanganPemesan(instalasiasalId,ruanganasalId)
{
    $("#instalasi").val(instalasiasalId);
    $("#instalasi").change();
    myAlert('Otomatis mengambil dari instalasi/ruangan/unit pasien terakhir diperiksa');$("#<?php echo CHtml::activeId($modPemakaian, 'ruangan_id') ?>").val(ruanganasalId);
}
</script>

<?php 
//========= Dialog buat daftar paramedis  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogParamedis',
    'options'=>array(
        'title'=>'Daftar Paramedis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarParamedis');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis =============================
//========= Dialog buat daftar supir  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupir',
    'options'=>array(
        'title'=>'Daftar Supir',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarSupir');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar supir =============================
//========= Dialog buat daftar pelaksana  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPelaksana',
    'options'=>array(
        'title'=>'Daftar Pelaksana',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarPelaksana');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar pelaksana =============================
//========= Dialog buat daftar ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKendaraan',
    'options'=>array(
        'title'=>'Daftar Kendaraan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarKendaraan');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar ambulans =============================
//========= Dialog buat daftar tarif ambulans  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTarif',
    'options'=>array(
        'title'=>'Daftar Tarif Ambulans',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarTarifAmbulans');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tarif ambulans =============================
?> 

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasienJenazah',
    'options' => array(
        'title' => 'Pencarian Jenazah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPasien = new PasienM('search');
$modPasien->unsetAttributes();
if (isset($_GET['PasienM'])) {
    $modPasien->attributes = $_GET['PasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->search(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#PJPemakaianambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
                                                          $(\"#PJPemakaianambulansT_namapasien\").val(\"$data->nama_pasien\");
                                                          $(\"#PJPemakaianambulansT_alamattujuan\").val(\"$data->alamat_pasien\");
                                                          $(\"#PJPemakaianambulansT_nomobile\").val(\"$data->no_mobile_pasien\");
                                                          $(\"#PJPemakaianambulansT_notelepon\").val(\"$data->no_telepon_pasien\");
														  setDataPasien();
                                                          $(\"#dialogPasienJenazah\").dialog(\"close\");    
                                                "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>