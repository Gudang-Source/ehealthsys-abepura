<div class="white-container">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'hasilpmeriksaan-radiologi-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#kolHasil_0',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); 
    $this->renderPartial('../_ringkasDataPasien',array('modPasienMasukPenunjang'=>$modPasienMasukPenunjang));
    ?>
    <fieldset class="box">
        <div class="row-fluid">
            <div class="span4">
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'riwayat-anamnesa',
                    'content'=>array(
                        'content-riwayat-anamnesa'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat anamnesa')).'<b> Riwayat Anamnesa</b>',
                            'isi'=>$this->renderPartial('_riwayat_anamnesa',array('modAnamnesa'=>$modAnamnesa),true),
                            'active'=>false,
                            ),   
                        ),
                        )); ?>  
            </div>
            <div class="span4">
                <?php 
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'riwayat-pemeriksaan-fisik',
                    'content'=>array(
                        'content-riwayat-pemeriksaan-fisik'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pemeriksaan fisik')).'<b> Riwayat Pemeriksaan Fisik</b>',
                            'isi'=>$this->renderPartial('_riwayat_pemeriksaan_fisik',array('modPemeriksaan'=>$modPemeriksaan),true),
                            'active'=>false,
                            ),   
                        ),
                        )); 
                ?>  
            </div>
            <div class="span4">
                <?php 
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'riwayat-diagnosa',
                    'content'=>array(
                        'content-riwayat-diagnosa'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat diagnosa')).'<b> Riwayat Diagnosa</b>',
                            'isi'=>$this->renderPartial('_riwayat_diagnosa',array('modPasienMorbiditas'=>$modPasienMorbiditas,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang),true),
                            'active'=>false,
                            ),   
                        ),
                        )); 
                ?>  
            </div>
        </div>
    </fieldset>
    <!--    <thead>
            <tr>
                <th>Pemeriksaan</th>
                <th>Hasil Expertise</th>
                <th>Kesan</th>
                <th>Kesimpulan</th>
                <th>&nbsp;</th>
            </tr>
        </thead>-->
    <?php foreach($modHasilpemeriksaanRad as $i=>$hasil): ?>
    <table width="100%"  id="tblFormHasilPemeriksaanRad" class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th colspan="5"><div style="text-align: center; font-size: 11pt;"><a href="javascript:void(0);" onclick="ambilReferensi(<?php echo $hasil->pemeriksaanrad_id; ?>,<?php echo $i; ?>);return false;" rel="tooltip" title="Klik untuk hasil Referensi"><?php echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama; ?> : <?php echo $hasil->pemeriksaanrad->pemeriksaanrad_nama; ?></a></div></th>
            </tr>
        </thead>
        <tr>
            <td style="font-size:10pt; ">
                <?php echo CHtml::css('ul.redactor_toolbar{z-index:10;}'); ?>
                <?php // echo $hasil->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama; ?> 
                Hasil Expertise<br/>
                <b><?php // echo $hasil->pemeriksaanrad->pemeriksaanrad_nama; ?></b> <br/>
                <?php echo CHtml::activeHiddenField($hasil, "[$i]hasilpemeriksaanrad_id", array('readonly'=>true)); ?>
                <?php // echo $hasil->tglpemeriksaanrad; ?>
            </td>
            <td id="kolHasil_<?php echo $i;?>" style="text-align:center;">
                <?php // echo CHtml::activeTextArea($hasil, "[$i]hasilexpertise", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php
    //            echo $i;
                if ($i == 0) {
                    $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']hasilexpertise','name'=>'ROHasilPemeriksaanRadT_'.$i.'_hasilexpertise','toolbar'=>'mini','height'=>'300px'));
                } else {
                   $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']hasilexpertise','name'=>'ROHasilPemeriksaanRadT_'.$i.'_hasilexpertise','toolbar'=>'mini','height'=>'300px'));
                }
                 ?>
            </td>
            <!--<td rowspan="2" style="text-align:center; vertical-align: middle;"><?php //echo CHtml::button('Referensi', array('onclick'=>"ambilReferensi($hasil->pemeriksaanrad_id,$i);return false;",'class'=>'btn btn-info','disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>-->
        </tr>

        <tr>
            <td style="font-size:10pt; ">Kesan</td>
            <td id="kolKesan_<?php echo $i;?>" style="text-align:center;">: 
                <?php // echo CHtml::activeTextArea($hasil, "[$i]kesan_hasilrad", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']kesan_hasilrad','name'=>'ROHasilPemeriksaanRadT_'.$i.'_kesan_hasilrad','toolbar'=>'mini','height'=>'300px')) ?>
            </td>
        </tr>
        <tr>
            <td style="font-size:10pt; ">Kesimpulan</td>
            <td id="kolKesimpulan_<?php echo $i;?>" style="text-align:center;">: 
                <?php // echo CHtml::activeTextArea($hasil, "[$i]kesimpulan_hasilrad", array('rows'=>3, 'style'=>'width:750px; font-size:11pt;', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$hasil,'attribute'=>'['.$i.']kesimpulan_hasilrad','name'=>'ROHasilPemeriksaanRadT_'.$i.'_kesimpulan_hasilrad','toolbar'=>'mini','height'=>'300px')) ?>
            </td>
        </tr>
    </table>
    <?php endforeach;?>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($modHasilpemeriksaanRad[0],'tglpegambilanhasilrad', array('class'=>'control-label inline')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modHasilpemeriksaanRad[0],
                                                'attribute'=>'[0]tglpegambilanhasilrad',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'minDate' => 'd',
                                                    //
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>

                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Pemeriksa','Dokter Pemeriksa',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php
                            echo CHtml::activeHiddenField($modPasienMasukPenunjang,'pegawai_id', array('class'=>'span1'));
                            echo CHtml::dropDownList('ROPasienmasukpenunjangT[pegawai_id]',$modPasienMasukPenunjang->pegawai_id,CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>  Yii::app()->user->getState('ruangan_id'))),'pegawai_id','NamaLengkap'),array('empty'=>'--Pilih--','class'=>'span3', 'readonly'=>false, 'onchange'=>'konfirmUbahDokterPemeriksa(this);'));
            //              echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id',CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>  Yii::app()->user->getState('ruangan_id'))),'pegawai_id','NamaLengkap'),array('empty'=>'--Pilih--','class'=>'span3', 'readonly'=>false));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table> 
    <?php if(isset($modRujukan->rujukandari_id)){ ?>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Perujuk','Dokter Perujuk',array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php
    //                           echo CHtml::dropDownList('ROPasienKirimKeUnitLainT[pegawai_id]',$modPasienKirimKeUnitLain->pegawai_id,CHtml::listData(DokterV::model()->findAll(),'pegawai_id','nama_pegawai'),array('empty'=>'--Pilih--','style'=>'width:160px;', 'readonly'=>false));
                               echo CHtml::activeHiddenField($modRujukan,'asalrujukan_id', array('class'=>'span1'));
                               echo CHtml::activeHiddenField($modRujukan,'rujukandari_id', array('class'=>'span1'));
    //                           echo CHtml::dropDownList('RORujukanT[rujukandari_id]',$modPasienMasukPenunjang->rujukandari_id,CHtml::listData(RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$modPasienMasukPenunjang->asalrujukan_id)),'rujukandari_id','namaperujuk'),array('empty'=>'--Pilih--','class'=>'span3'));
                               echo $form->dropDownList($modRujukan,'rujukandari_id',CHtml::listData(RujukandariM::model()->findAll(),'rujukandari_id','namaperujuk'),array('empty'=>'--Pilih--','class'=>'span3', 'onchange'=>'konfirmUbahDokterPerujuk(this);'));
    //                           echo CHtml::textField('RORujukanT[rujukandari_id]',$modPasienMasukPenunjang->namaperujuk,array('empty'=>'--Pilih--','class'=>'span3', 'readonly'=>true));

                            ?>
                    </div>
                </div>
    <?php } ?>
    <div class='form-actions'>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                          array('class'=>'btn btn-primary', 'type'=>'submit', 
                                          'onKeypress'=>'return formSubmit(this,event)',
                                          'id'=>'btn_simpan',)); ?>
    	<?php // echo CHtml::link(Yii::t('mds', '{icon} Batal', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl(''), array('class'=>'btn btn-danger')); ?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('index',array('modul_id'=>Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger')); ?>
        <?php 
        $content = $this->renderPartial('../tips/tips',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
function ambilReferensi(idPemeriksaanRad,row)
{
    //myAlert(<?php //echo Yii::app()->user->pegawai_id; ?>);
    $.post("<?php echo $this->createUrl('GetReferensiHasilRad');?>",{idPemeriksaanRad: idPemeriksaanRad},
        function(data){
           //menambahkan nilai ke elemen yang di hide oleh widget redactor.js
           $('#ROHasilPemeriksaanRadT_'+row+'_hasilexpertise').val(data.refhasilrad_hasil); 
           $('#ROHasilPemeriksaanRadT_'+row+'_kesan_hasilrad').val(data.refhasilrad_kesan); 
           $('#ROHasilPemeriksaanRadT_'+row+'_kesimpulan_hasilrad').val(data.refhasilrad_kesimpulan); 
           //menambahkan nilai referensi ke masukan hasil pemeriksaan
           $('#kolHasil_'+row ).find('iframe').contents().find('#page').html(data.refhasilrad_hasil); 
           $('#kolKesan_'+row ).find('iframe').contents().find('#page').html(data.refhasilrad_kesan); 
           $('#kolKesimpulan_'+row ).find('iframe').contents().find('#page').html(data.refhasilrad_kesimpulan); 
    },"json");
}

function konfirmUbahDokterPerujuk(obj){
    var sblm = $('#RORujukanT_rujukandari_id').val();
    myConfirm("Apakah anda yakin akan merubah Dokter Perujuk ?","Perhatian!",function(r) {
        if(r){
            obj.value = sblm;
        }
    });
}
function konfirmUbahDokterPemeriksa(obj){
    var sblm = $('#ROPasienMasukPenunjangV_pegawai_id').val();
    myConfirm("Apakah anda yakin akan merubah Dokter Pemeriksa ?","Perhatian!",function(r) {
        if(r){
            obj.value = sblm;
        };
    });
}
</script>