<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Sudah Bayar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
            'PasienKarcis',
    );?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#BKPembayaranpelayananT_no_rekam_medik',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Sudah Bayar</b></h6>
        <div class="table-responsive">
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'pencarianpasien-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                     array(
                        'header'=>'Tanggal Bukti Bayar/<br>No. Bukti Bayar',
                        'name'=>'tglbuktibayar',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglbuktibayar)."/<br>".$data->nobuktibayar',
                    ),
                     array(
                        'header'=>'Tanggal Pendaftaran/<br>No. Pendaftaran',
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'isset($data->tgl_pendaftaran)?MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran:null',
                    ),                   
                    array(
                        'name'=>'ruangan_id',
                        'type'=>'raw',
                        'value'=>'isset($data->ruangan_nama) ? $data->ruangan_nama : null',
                    ),
                    array(
                        'header'=>'No. Rekam Medik',
                        'value'=>'(isset($data->no_rekam_medik) ? $data->no_rekam_medik :null)',
                         ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->getNamaSapaan($data->no_rekam_medik)." ".$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Cara Bayar/<br>Penjamin',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'(isset($data->carabayar_nama)?$data->carabayar_nama:null)."/<br>".(isset($data->penjamin_nama) ? $data->penjamin_nama :null)',
                    ),
                    array(
                        'name'=>'total_tagihan',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totalbiayapelayanan,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header'=>'Subsidi Asuransi',
                        'name'=>'subsidi_asuransi',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totalsubsidiasuransi,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header'=>'Subsidi RS',
                        'name'=>'subsidi_rs',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totalsubsidirs,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header'=>'Total Pembebasan',
                        'name'=>'pembebasan',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totalpembebasan,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header'=>'Total Discount',
                        'name'=>'discount',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totaldiscount,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ), 
                    array(
                        'header'=>'Iur Biaya',
                        'name'=>'iur_biaya',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totaliurbiaya,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),                                       
                    array(
                        'header'=>'Jumlah Pembayaran',
                        'name'=>'jumlah_pembayaran',
                        'type'=>'raw',
                        'value'=>'"Rp".number_format($data->totalbayartindakan,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header'=>'Rincian Sudah Bayar/<br> RS',
                        'type'=>'raw',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-rincianbayar\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))."/<br>".CHtml::Link("<i class=\"icon-form-rincianrs\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianRSSudahBayar",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),  
                    array(
                        'header'=>'Kwitansi Pasien',
                        'type'=>'raw',
                        'value'=> function($data){
                                $cek = $data->getCekPrint($data->pendaftaran_id);
                                
                                if ($cek >= 1):
                                    //kwitansi lebih dari 1
                                    echo CHtml::link("<i class='icon-form-print'></i>",Yii::app()->controller->createUrl('kwitansi/view',array('idPembayaranPelayanan'=>$data->pembayaranpelayanan_id,'frame'=>true)),
                                            array(
                                                'class'=>'', 
                                                'target'=>'iframeKwitansi',
                                                'onclick'=>'notifKwitansi(1,'.$data->pendaftaran_id.')',
                                                'rel'=>'tooltip',
                                                'title'=>'Klik untuk cetak Kwitansi'));
                                else:                                    
                                    //kwitansi belum pernah cetak
                                    echo CHtml::link("<i class='icon-form-print'></i>",Yii::app()->controller->createUrl('kwitansi/view',array('idPembayaranPelayanan'=>$data->pembayaranpelayanan_id,'frame'=>true)),
                                            array(
                                                'class'=>'', 
                                                'target'=>'iframeKwitansi',
                                                'onclick'=>'notifKwitansi(0,'.$data->pendaftaran_id.')',
                                                'rel'=>'tooltip',
                                                'title'=>'Klik untuk cetak Kwitansi'));
                                endif;
                        }
                    ),//"onclick"=>"$(\"#dialogKwitansi\").dialog(\"open\");",
/*'CHtml::Link("<i class=\"icon-form-print\"></i>",Yii::app()->controller->createUrl("kwitansi/view",array("idPembayaranPelayanan"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeKwitansi",
                                          "onclick"=>"notifKwitansi($data->getCekPrint($data->pendaftaran_id))",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk cetak Kwitansi",
                                    ))',           'htmlOptions'=>array('style'=>'text-align: left; width:40px')*/                            
                    array(
                        'header'=>'Retur Tagihan',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("returTagihanPasien/index",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk meretur tagihan pasien",
                                    ))',           'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
        //            array(
        //                'header'=>'Rincian Sudah Bayar',
        //                'type'=>'raw',
        //                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
        //                'value'=>'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianSudahBayar",array("id"=>$data->pendaftaran_id, "idpembayaran"=>$data->pembayaranpelayanan_id, "frame"=>true)),
        //                            array("class"=>"", 
        //                                  "target"=>"iframeRincianTagihan",
        //                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
        //                                  "rel"=>"tooltip",
        //                                  "title"=>"Klik untuk melihat Rincian Tagihan",
        //                            ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
        //            ),           
                   /* array(
                        'header'=>'Rincian Sudah Bayar',
                        'type'=>'raw',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-rincianbayar\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),      
                    array(
                        'header'=>'Rincian Untuk RS',
                        'type'=>'raw',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-rincianrs\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianRSSudahBayar",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),   */        
                    
                    
                   /* array(
                        'header'=>'BKM',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-bkm\"></i>",Yii::app()->controller->createUrl("detailKasMasuk",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeDetPembayaran",
                                          "onclick"=>"$(\"#dialogDetPembayaran\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk detail BKM",
                                    ))',
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: left;'
                                    )
                    ),*/
//                    array(
//                        'header'=>'Batal Pembayaran',
//                        'type'=>'raw',
//                        'value'=>'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("detailKasMasuk",array("idTandabuktibayar"=>$data->tandabuktibayar_id,"frame"=>true)),
//                                    array("class"=>"", 
//                                          "target"=>"iframeDetPembayaran",
//                                          "onclick"=>"cekHakBatalBayar(this,$data->tandabuktibayar_id,$data->pembayaranpelayanan_id);return false;",
//                                          "rel"=>"tooltip",
//                                          "title"=>"Klik untuk Membatalkan Pembayaran",
//                                    ))',
//                                    'htmlOptions'=>array(
//                                        'style'=>'text-align: left;'
//                                    )
//                    ),
                     array(                        
                        'header'=>'Status Closing',
                        'type'=>'raw',
                        'value'=>'(isset($data->closingkasir_id) ? "SUDAH" :"BELUM")',
                        'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
                    ),
                     array(
                        'header'=>'Pegawai Kasir',                        
                        'type'=>'raw',
                        'value'=>'$data->getNamaUsername($data->petugasadministrasi_id)',
                        'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
                    ),
                    array(
                        //'header'=>'Batal Pembayaran',
                        'header'=>'Pembatalan',
                        'type'=>'raw',
                       // 'value'=>'isset($data->closingkasir_id)?"Sudah Bayar":CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalBayar($data->tandabuktibayar_id,$data->pembayaranpelayanan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Membatalkan Pembayaran"))',
                      //  'value'=>'isset($model->getCekBayar($data->tandabuktibayar_id))?"Sudah Bayar":CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalBayar($data->tandabuktibayar_id,$data->pembayaranpelayanan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Membatalkan Pembayaran"))',
                      //  'value' => function($model, $data){
                         //   $cek = $model->getCekBayar();
                         //   if ($cek ==NULL)
                         //   {
                         //       $data = '';
                         //   }
                         //   return $cek;
                       // },
                        'value' => '($data->getCekBayar($data->tandabuktibayar_id))?"SUDAH BAYAR":CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalBayar($data->tandabuktibayar_id,$data->pembayaranpelayanan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Membatalkan Pembayaran"))',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
            ?>
        </div>
    </div>
    <fieldset class="box">
        <?php echo $this->renderPartial('_formKriteriaPencarianBkm', array('model'=>$model,'form'=>$form),true);  ?> 
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
            $content = $this->renderPartial('../tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRetur',
    'options'=>array(
        'title'=>'Retur Tagihan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframePembayaran" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogKwitansi',
    'options'=>array(
        'title'=>'Kwitansi Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeKwitansi" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetPembayaran',
    'options'=>array(
        'title'=>'Detail Pembayaran',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeDetPembayaran" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianTagihan',
    'options'=>array(
        'title'=>'Rincian Tagihan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>1024,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'loginDialog',
    'options'=>array(
        'title'=>'Login',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>190,
        'resizable'=>false,
    ),
));?>
<?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formLogin')); ?>
    <div class="control-group ">
        <?php echo CHtml::label('Login Pemakai','username', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('username', '', array()); ?>
            <?php echo CHtml::hiddenField('tandabuktibayar_id', '', array()); ?> 
            <?php echo CHtml::hiddenField('pembayaranpelayanan_id', '', array()); ?> 
        </div>
    </div>

    <div class="control-group ">
        <?php echo CHtml::label('Password','password', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::passwordField('password', '', array()); ?>
        </div>
    </div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'cekLogin();return false;')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), '#', array('class'=>'btn btn-danger','onclick'=>"$('#loginDialog').dialog('close');return false",'disabled'=>false)); ?>
    </div> 
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>

<script type="text/javascript">
function notifKwitansi(cekPrint, pendaftaranid)
{
    if (cekPrint >= 1 )
    {
         $.ajax({
				 type:'POST',
				 'url':'<?php echo $this->createUrl('/ActionAjax/DataRincian')?>',
				 'data':{pendaftaranid:pendaftaranid},
				 dataType: "json",
				 success:function(data){
                                    if(data.hasil == "BERHASIL")
                                    {
                                        myConfirm(" Kwitansi Sebelumnya Sudah Dicetak Oleh:\n\
                                            <?php 
                                         /*       $rincian = getRincianCetak($pendaftaran_id);                                            
                                                echo "<table>";
                                                echo "<tr>";
                                                echo "<td>Nama</td>";echo "<td>:</td>";echo "<td>data dimari</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td>Tanggal Dicetak</td>";echo "<td>:</td>";echo "<td>data dimari</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td>Ruangan</td>";echo "<td>:</td>";echo "<td>data dimari</td>";
                                                echo "</tr>";
                                                echo "</table>"*/
                                            ?> Apakah Anda ingin mencetak lagi?"," Perhatian!", function(r){
                                            if(r){
                                              $("#dialogKwitansi").dialog("open"); 
                                            }
                                        });                    
                                    }
                                    else
                                    {
                                            myConfirm(" Kwitansi Sebelumnya Sudah Dicetak Oleh:\n\
                                                        Nama : "+data.nama+"\n\
                                                        Tanggal Cetak : "+data.tanggal+"\n\
                                                        Ruangan : "+data.ruangan+"\n\
                                                        \n\
                                                        Apakah Anda ingin mencetak lagi?"," Perhatian!", function(r){
                                            if(r){
                                              $("#dialogKwitansi").dialog("open"); 
                                            }
                                        }); 
                                    }
				 },				 
			 });
        
    }
    else
    {        
        $("#dialogKwitansi").dialog("open"); 
    }
            
    
}

function batalBayar(tandabuktibayar_id,pembayaranpelayanan_id)
{
	 myConfirm("Yakin Akan Membatalkan Pembayaran ini ?","Perhatian!",function(r) {
		 if(r){
			  $.ajax({
				 type:'POST',
				 'url':'<?php echo $this->createUrl('BatalBayar')?>',
				 'data':{tandabuktibayar_id:tandabuktibayar_id, pembayaranpelayanan_id:pembayaranpelayanan_id},
				 dataType: "json",
				 success:function(data){
					 if(data.hasil == "BERHASIL"){
						$.fn.yiiGridView.update('pencarianpasien-grid', {
							data: $(this).serialize() });
					 }else{
						 myAlert(data.hasil);
					 }
				 },
				 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			 });
		 }
	 });
}


function cekLogin()
{
    $.post('<?php echo $this->createUrl('CekLoginBatalBayar',array('task'=>'BatalBayar'));?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
            myAlert(data.error);
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){


            

            var idTandabuktibayar = $('#tandabuktibayar_id').val();
            var idPembayaranpelayanan = $('#pembayaranpelayanan_id').val();
            jQuery.ajax({
                'url':'<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/BatalBayar')?>',
                'data':{idTandabuktibayar:idTandabuktibayar, idPembayaranpelayanan:idPembayaranpelayanan},
                'type':'post',
                'dataType':'json',
                'success':function(data){
                    // myAlert(data);
                    if(data.hasil=='GAGAL'){
                        myAlert('Pembatalan pembayaran gagal, data sudah di Closing.');
                    }else{
                        myAlert('Pembatalan pembayaran sudah dilakukan');
                        // reloadTable();
                        $.fn.yiiGridView.update('pencarianpasien-grid', {}); 
                    }
                },
                'cache':false
            });

            $('#loginDialog').dialog('close');
            return true;
        }else{
            myAlert(data.status);
        }
    }, 'json');
}
</script>
