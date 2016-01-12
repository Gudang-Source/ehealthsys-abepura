<div class="white-container">
    <legend class="rim2">Pemakaian Ambulan <b>Pasien Rumah Sakit</b></legend>
    <?php
        $sukses = null;
        if(isset($_GET['sukses'])){
            $sukses = $_GET['sukses'];
        }
        if($sukses > 0) 
            Yii::app()->user->setFlash('success',"Transaksi Pemakaian Ambulans berhasil disimpan !");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'pemakaianambulans-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($modPemakaian,'norekammedis'),
    )); ?>
    <?php echo $form->errorSummary($modPemakaian); ?>
    <fieldset class="box" id="form-datakunjungan">
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan,'format'=>$format,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
        </div>
    </fieldset>       
    <fieldset class="box" id="form-datapemakaian">
        <legend class="rim"><span class='judul'>Pemakaian Ambulan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formPemesananAmbulan', array('form'=>$form,'modPemakaian'=>$modPemakaian,'instalasi'=>$instalasi,'modInstalasi'=>$modInstalasi,'format'=>$format,'modObatAlkesPasien'=>$modObatAlkesPasien,'latitude'=>$latitude,'longitude'=>$longitude)); ?>
        </div>
    </fieldset>       
            
    <div class="block-tabel">
        <h6>Tarif <b>Ambulans</b>
                <?php
                    echo CHtml::htmlButton('<i class="icon-search icon-white"></i>', array('class' => 'btn btn-primary', 'onclick' => "$('#dialogTarif').dialog('open');",
                        'id' => 'btnAddParamedis2', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk mencari Tarif Ambulans'))
                ?>
        </h6>
        <table id="tblTarifAmbulans" class="table table-striped">
            <thead>
                <tr>
                    <th colspan="4" style='vertical-align:middle;text-align:center;'>Tujuan</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:left;'>Jumlah Km</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:left;'>Tarif / Km</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:center;'>Total Tarif</th>
                    <th rowspan="2" style='vertical-align:middle;text-align:left;'>Batal</th>
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
                    <td><input type="text" value="<?php echo $tarif['tarifKM'][$i]; ?>" name="tarif[tarifKM][]" class="span1 integer" /></td>
                    <td><input type="text" value="<?php echo $tarif['tarifAmbulans'][$i]; ?>" name="tarif[tarifAmbulans][]" class="span2 integer" /></td>
                    <td><i class="icon-remove" onclick="batalTarif(this);return false;"></i></td>
                </tr>
                <?php } ?>
                <?php endfor;?>
            </tbody>
        </table>
    </div>
    <div class="row-fluid">        
            <?php 
                if(isset($_GET['sukses'])){
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'riwayat-obatalkespasien-t',
                            'content'=>array(
                                'content-riwayat-obatalkespasien-t'=>array(
                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk menampilkan obat alkes pasien')).'<b> Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                                    'isi'=>'
                                        <table class="table table-condensed table-bordered">
                                            <thead>
                                                <th>No.</th>
                                                <th>Tgl. Pelayanan</th>
                                                <th>Obat / Alat Kesehatan</th>
                                                <th>Satuan Kecil</th>
                                                <th>Jumlah</th>
                                                <th>Hapus</th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
                                    'active'=>true,
                                ),   
                            ),
                    )); 
                }
                else{
                ?>
        <div class="span4">
            <fieldset class="box">
                <legend class="rim">Pemakaian Obat dan Alat Kesehatan</legend>
                <div id="form-tambahobatalkes">
                    <?php $this->renderPartial('_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
                </div>
            </fieldset>
        </div>
        <div class="span8">
            <fieldset class="box">
                <legend class="rim">Tabel BMHP</legend>
                <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Obat / Alat Kesehatan</th>
                            <th>Satuan Kecil</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                            <th>Batal</th>                    
                        </tr>
                    </thead>
                    <tbody>                
                    </tbody>
                </table>
            </fieldset>
        </div>
        <?php } ?>
    </div>
    
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
            if($modPemakaian->isNewRecord){
                echo CHtml::htmlButton($modPemakaian->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'disabled'=>true,'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
            }   
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('Index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));  ?>
            <?php
                if(!isset($_GET['pemakaian_id'])){
                    echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bmhp', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false"));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan BMHP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemakaianOa(".$_GET['pemakaian_id'].");return false"));
                }
            ?>
            <?php $content = $this->renderPartial('../tips/transaksi_pemakaian',array(),true);
                  $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
        </div>
    </div>
<?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan,'modPemakaian'=>$modPemakaian,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
<?php $this->endWidget(); ?>

<?php 
//========= Dialog buat daftar paramedis 1  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogParamedis1',
    'options'=>array(
        'title'=>'Daftar Paramedis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarParamedis1');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis 1 =============================
//========= Dialog buat daftar paramedis 2  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogParamedis2',
    'options'=>array(
        'title'=>'Daftar Paramedis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarParamedis2', array('modPemakaian'=>$modPemakaian));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar paramedis 2 =============================

//========= Dialog buat daftar supir  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupir',
    'options'=>array(
        'title'=>'Daftar Supir',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
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
        'resizable'=>false,
    ),
));
    $this->renderPartial('_daftarPelaksana',array('modPemakaian'=>$modPemakaian));

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
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPasien = new InfopasienrirdambulansV('search');
$modPasien->unsetAttributes();
if (isset($_GET['InfopasienrirdambulansV'])) {
    $modPasien->attributes = $_GET['InfopasienrirdambulansV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
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
                "onClick" => "$(\"#AMPemakaianambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
                  $(\"#AMPemakaianambulansT_pasien_id\").val(\"$data->pasien_id\");
                  $(\"#AMPemakaianambulansT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                  $(\"#AMPemakaianambulansT_namapasien\").val(\"$data->nama_pasien\");



                  $(\"#dialogPasien\").dialog(\"close\");    
            "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>