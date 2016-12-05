<div class="white-container">
    <legend class="rim2">Informasi <b>Daftar Pasien</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php 
        if(isset($_GET['status'])){
            if($_GET['status'] > 0){ // Jika berhasil disimpan
                Yii::app()->user->setFlash('success',"Data pemeriksaan lab berhasil disimpan !");
            }
        }
    ?>
    <?php
    //============= PRINT LABEL sebelumnya ==============
    // if(isset($_GET['caraPrint'])){
    // $pendaftaran_id = $_GET['id'];
    // $urlPrint=  Yii::app()->createAbsoluteUrl('laboratorium/pendaftaranPasienLuar/print', array('id_pendaftaran'=>$pendaftaran_id));
    // $js = <<< JSCRIPT
    // function printLabel(caraPrint)
    // {
    //     window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    // }
    //     printLabel('PRINT');
    // JSCRIPT;
    // Yii::app()->clientScript->registerScript('printLabel',$js,CClientScript::POS_HEAD);     
    // }
    ?>

    <?php
    //============= PRINT LABEL DAN TINDAKAN ==============
    if(isset($_GET['caraPrint'])){
    $pendaftaran_id = $_GET['id'];
    $id_pasienpenunjang = $_GET['idPasienPenunjang'];
    $labelOnly = 1;
    $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/pendaftaranPasienLuar/print', array('id_pendaftaran'=>$pendaftaran_id,'id_pasienpenunjang'=>$id_pasienpenunjang, 'labelOnly'=>$labelOnly)); 
    $urlPrintTindakan=  Yii::app()->createAbsoluteUrl($this->module->id.'/pendaftaranLab/print', array('id_pendaftaran'=>$pendaftaran_id, 'labelOnly'=>$labelOnly)); 
$js = <<< JSCRIPT
function printLabel(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
    window.open("${urlPrintTindakan}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}
    printLabel('PRINT');
JSCRIPT;
    
    Yii::app()->clientScript->registerScript('printLabel',$js,  CClientScript::POS_HEAD);
    }
    ?>


    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari cari', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarpasien-v-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?> 
    <fieldset>
    <?php
      $daftar = $modPasienMasukPenunjang->searchLab();
      if(Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_LAB_ANATOMI){
        $daftar = $modPasienMasukPenunjang->searchLabAnatomi();
      }

    ?>     
    <div class="block-tabel">
        <h6>Tabel <b>Daftar Pasien</b>  <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')); ?></h6>    
        <?php $this->widget('bootstrap.widgets.BootAlert');
         $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'daftarpasien-v-grid',
                'dataProvider'=>$daftar,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
        //            'tgl_pendaftaran',
                    array(
                            'name'=>'no_urutperiksa',
                            'type'=>'raw',
                            'header'=>'No. Antrian <br>/ Panggil Antrian',
                            'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))'
                    ),
                    array(
                        'header'=>'Tgl. Pendaftaran<br/>No. Pendaftaran',
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
                    ),
                    array(
                        'header'=>'Tgl. Masuk Penunjang<br/>No. Penunjang',
                        'name'=>'no_masukpenunjang',
                        'type'=>'raw',
                        'value'=>'(($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-ubah\"></i><br/>".MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang,Yii::app()->controller->createUrl("pemeriksaanPasienLaboratorium/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Pemeriksaan")) : MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang)',
                    ),
                    array(
                        'header'=>'Ruangan<br/>Dokter Asal',
                        'name'=>'ruanganasal_nama',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $pegawai = PegawaiM::model()->findByAttributes(array(
                                'nama_pegawai'=>$data->nama_dokterasal,
                            ));
                            return $data->ruanganasal_nama."/<br/>".(empty($pegawai)?"-":$pegawai->namaLengkap);
                        },
                    ),
                    'nama_perujuk',
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'header'=>'No. RM',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
        //                'value'=> '((substr($data->no_rekam_medik,0,-6)) == "LB" || (substr($data->no_rekam_medik,0,-6)) == "RD" ? CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien.\' / \'.$data->nama_bin, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->nama_pasien.\' / \'.$data->nama_bin )',
                        'value'=> '(($data->instalasiasal_id == '.PARAMS::INSTALASI_ID_LAB.') ? CHtml::link("<i class=\"icon-form-ubah\"></i> ".$data->namadepan.$data->nama_pasien, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id","pendaftaran_id"=>"$data->pendaftaran_id","modul_id"=>"'.Yii::app()->session['modul_id'].'")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->namadepan.$data->nama_pasien )',
                    ),
                    array(
                        'header'=>'Jenis Kelamin/<br/>Umur',
                        'type'=>'raw',
                        'value'=>'$data->jeniskelamin."/<br/>".$data->umur',
                    ),
                    'alamat_pasien',

                    array(
                        'header'=>'Cara Bayar /<br/> Penjamin',
                        'name'=>'CaraBayarPenjamin',
                        'type'=>'raw',
                        'value'=>'$data->caraBayarPenjamin',    
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    'statusperiksa',
                    array(
                        'header'=>'Status Pemeriksaan Hasil',
                        'type'=>'raw',
        //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->statusperiksahasil,Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/CancelPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan", "onclick"=>"return confirm(\"Apakah anda akan membatalkan pemeriksaan ini?\");")) : ((empty($data->pasienbatalperiksa_id)) ? $data->statusperiksahasil : "DIBATALKAN")',
                        'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>".$data->statusperiksahasil, "javascript:batalstatusperiksa($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",array("rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan")) : ((empty($data->pasienbatalperiksa_id)) ? $data->statusperiksahasil : "DIBATALKAN")',
                    ),
                    array(
                        'header'=>'Dokter Pemeriksa',
                        'type'=>'raw',
        //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                        'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>".$data->getNamaLengkapDokter($data->pegawaipenunjang_id), "javascript:approveperiksa($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan")) : $data->getNamaLengkapDokter($data->pegawaipenunjang_id)',
                    ),
        //            array(
        //                'header'=>'Status Print',
        //                'type'=>'raw',
        //                'value'=>'($data->printhasillab == true) ? "SUDAH" : "BELUM"',
        //            ),
                     array(
                        'name'=>'ambilSample',
                        'type'=>'raw',
                        'value'=>'($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-form-ambilsample\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/updateSample",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample")) : ""',    
                                         //dicomment RND-5771
        //                'value'=>'($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/updateSample",array("pendaftaran_id"=>$data->pendaftaran_id,"idPengambilanSample"=>$data->pengambilansample_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample")) : ""',    
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
        //             array(
        //                'name'=>'masukanHasil',
        //                'type'=>'raw',
        //                'value'=>'(($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG || $data->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) ? CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan")) 
        //                  : 
        //                  CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab Anatomi")))',    
        //                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
        //            ),
                    //TEST NEW
                     array(
                        'name'=>'masukanHasil',
                        'type'=>'raw',
                        'value'=>'(($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-input\"></i>",Yii::app()->controller->createUrl("/laboratorium/pencatatanHasilPemeriksaan/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab")) : "")',    
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                        'header'=>'Lihat Hasil',
                        'type'=>'raw',
                        'value'=>'(Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_LAB_KLINIK) ? 
                                    CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/print",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                                        array("class"=>"", 
                                              "target"=>"iframeLihatHasil",
                                              "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat hasil pemeriksaan", 
                                        )) : 
                                    CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/PrintPA",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                                        array("class"=>"", 
                                              "target"=>"iframeLihatHasil",
                                              "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat hasil pemeriksaan", 
                                        ))  
                                    ',
                        'htmlOptions'=>array('style'=>'text-align: left; width:40px')

        //                'value'=>'CHtml::Link("<i class=\"icon-file-silver\"></i>",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/Details",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id, "popup"=>"true")),
        //                            array("class"=>"", 
        //                                  "target"=>"iframeLihatHasil",
        //                                  "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
        //                                  "rel"=>"tooltip",
        //                                  "title"=>"Klik untuk melihat hasil pemeriksaan", 
        //                            ))','htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                       'header'=>'Batal Periksa',
                       'type'=>'raw',
                       'value'=>'($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan")) : null',
                       'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                    ),

                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php 
    // Dialog untuk Lihat Hasil =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogLihatHasil',
        'options'=>array(
            'title'=>'Hasil Pemeriksaan Laboratorium',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>980,
            'minHeight'=>450,
            'resizable'=>true,
        ),
    ));
    ?>

    <iframe src="" name="iframeLihatHasil" width="100%" height="500">
    </iframe>

    <?php
    $this->endWidget();
    //========= end Lihat Hasil =============================
    ?>

    <?php
     //CHtml::link($text, $url, $htmlOptions)
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'daftarPasien-form',
            'type'=>'horizontal',
            'focus'=>'#'.CHtml::activeId($modPasienMasukPenunjang, 'no_rekam_medik'),
            'htmlOptions'=>array(),

    )); ?>

    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Tanggal Masuk Penunjang','tglmasukpenunjang', array('class'=>'control-label')) ?>
                        <div class="controls">  
                           <?php $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal); ?>
                           <?php $this->widget('MyDateTimePicker',array(
                                               'model'=>$modPasienMasukPenunjang,
                                               'attribute'=>'tgl_awal',
                                               'mode'=>'date',
      //                                          'maxDate'=>'d',
                                               'options'=> array(
                                               'dateFormat'=>Params::DATE_FORMAT,
                                              ),
                                               'htmlOptions'=>array('readonly'=>true,
                                               'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                          )); ?>
                            <?php $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($modPasienMasukPenunjang->tgl_awal); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label(' Sampai Dengan',' s/d', array('class'=>'control-label')) ?>
                        <div class="controls">  
                            <?php $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir); ?>
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPasienMasukPenunjang,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
       //                                         'maxdate'=>'d',
                                                'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                               ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                           )); ?>
                            <?php $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($modPasienMasukPenunjang->tgl_akhir); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Status Permeriksaan</label>
                        <div class="controls">
                            <?php // echo $form->textField($modPasienMasukPenunjang,'statusperiksahasil',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                            <?php echo $form->dropDownList($modPasienMasukPenunjang,'statusperiksahasil',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'statusperiksahasil', 'lookup_aktif'=>true)), 'lookup_value', 'lookup_name'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                        </div>
                    </div>
                </td>
                <td>
                   
                    <div class="control-group">
                <?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>                        
                    <div class="controls">

                        <?php 

                                $prefix = array(
                                    0 => Params::PREFIX_RAWAT_DARURAT,
                                    1 => Params::PREFIX_RAWAT_INAP,
                                    2 => Params::PREFIX_RAWAT_JALAN,
                                    3 => Params::PREFIX_LABORATORIUM
                                );

                            echo $form->dropDownList($modPasienMasukPenunjang,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                        ?>
                        <?php echo $form->textField($modPasienMasukPenunjang, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
                    </div>                                                
            </div>                    
                     <div class="control-group">
                        <label class="control-label">No. Rekam Medik</label>
                        <div class="controls">
                            <?php echo $form->textField($modPasienMasukPenunjang,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6)); ?>
                        </div>
                    </div>
                    
                    <?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php //echo $form->textFieldRow($modPasienMasukPenunjang,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td>
                    
                    <?php //echo $form->textFieldRow($modPasienMasukPenunjang,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>

            </tr>
        </table>
        <div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                    array('autofocus' => true, 'class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                                                                 ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
      <?php 
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>

        </div>
    </fieldset>  
    <?php $this->endWidget();?>
    </fieldset>
    <iframe id="suarapanggilan" src="#" style="display: none;"></iframe>
    <script type="text/javascript">

    function batalstatusperiksa(pendaftaran_id,idPenunjang)
    {
       myConfirm('Apakah anda akan membatalkan status pemeriksaan ini?', 'Perhatian!', function(r)
       {
           if(r){
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/CancelPemeriksaanAjax')?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
                          function(data){
                              if(data.status == 'ok'){
                                  window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')?>";
                              }else{
                                  if(data.status == 'gagal')
                                  {
                                      myAlert('Pembatalan pemeriksaan gagal');
                                  }

                              }
                          },'json'
                      );
            }
       });
    }

    function approveperiksa(pendaftaran_id,idPenunjang)
    {
       myConfirm('Apakah Anda akan menyetujui pemeriksaan ini?', 'Perhatian!', function(r)
       {
           if(r){
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/ApprovePemeriksaanAjax')?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
                          function(data){
                              if(data.status == 'ok'){
                                  window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')?>";
                              }else{
                                  if(data.status == 'gagal')
                                  {
                                      myAlert('Pemeriksaan gagal disetujui');
                                  }

                              }
                          },'json'
                      );
            }
       });
    }

    function batalperiksa(pendaftaran_id,idPenunjang)
    {
       myConfirm('Anda yakin akan membatalkan pemeriksaan laboratorium pasien ini?', 'Perhatian!', function(r)
       {
            if(r){
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/batalPenunjang')?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
                          function(data){
                              if(data.status == 'ok'){
                                /*
                                if(data.smspasien==0){
                                  var params = [];
                                  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                                  insert_notifikasi(params);
                                }
                                */
                                if (data.pesan == 'exist') {
                                    myAlert(data.keterangan);
                                } else {
                                    window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')?>";
                                }
                              }else{
                                  if(data.status == 'exist')
                                  {
                                      myAlert('Pasien telah melakukan pemeriksaan');
                                  }

                              }
                          },'json'
                      );
            }else{
         //       myAlert('tidak');
            }
       });
    }
    function ambilAntrianTerakhir(){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
            dataType: "json",
            success:function(data){
                if(data.pesan == ""){
                    panggilAntrian(data.pasienmasukpenunjang_id);
                    setSuaraPanggilanSingle(data.ruangan_singkatan,data.no_urutperiksa,data.ruangan_id);
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    } 

    /**
     * memanggil antrian ke poliklinik
     * @param {type} pendaftaran_id
     * @returns {undefined} */
    function panggilAntrian(pasienmasukpenunjang_id){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('Panggil'); ?>',
            data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                }
                if(data.smspasien==0){
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                    insert_notifikasi(params);
                } 
                <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
                socket.emit('send',{conversationID:'antrian',panggil:3,antrian_id:pasienmasukpenunjang_id});
                <?php } ?>
                $.fn.yiiGridView.update('daftarpasien-v-grid');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }



    /**
     * suara panggilan per ruangan
     * @param {type} param
     * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
     */
    function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
        $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
    }
    //    if(alasan==''){
    //        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    //    }else{
    //        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
    ////            if(data.error != '')
    ////                myAlert(data.error);
    ////            $('#'+data.cssError).addClass('error');
    //            if(data.status=='success'){
    //                batal();
    //                myAlert('Data Berhasil Disimpan');
    //                location.reload();
    //            }else{
    //                myAlert(data.status);
    //            }
    //        }, 'json');
    //   }     

    </script>
</div>