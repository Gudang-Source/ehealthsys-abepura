<div class="white-container">
    <legend class="rim2">Informasi Pengajuan <b>Bahan Makanan</b></legend>
    <?php 
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pengajuan <b>Bahan Makanan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gzpengajuanbahanmkn-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'pengajuanbahanmkn_id',
    //		array(
    //                        'name'=>'pengajuanbahanmkn_id',
    //                        'value'=>'$data->pengajuanbahanmkn_id',
    //                        'filter'=>false,
    //                ),
    //		'terimabahanmakan_id',
                    'tglpengajuanbahan',
                    'nopengajuan',
                    'sumberdanabhn',                    
                    array(
                        'header' => 'Tanggal Minta Dikirim',
                        'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime(MyFormatter::formatDateTimeForDb($data->tglmintadikirim))))'
                    ),
                    array(
                        'name'=>'idpegawai_mengajukan',
                        'value'=>'GZPegawaiM::getNamaPegawai($data->idpegawai_mengajukan)',
                    ),
                    array(
                        'name'=>'idpegawai_mengetahui',
                        'value'=>'GZPegawaiM::getNamaPegawai($data->idpegawai_mengetahui)',
                    ), 
                    //'alamatpengiriman',
                    array(
                        'header' => 'Keterangan Pengajuan',
                        'value' => '$data->keterangan_bahan',
                    ),
                    array(
                        'header' => 'Total Harga',
                        'value' => 'number_format($data->totalharganetto,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right')
                    ),                                                      
                    array(
                        'header' => 'Pegawai Menyetujui',
                        'value' => 'GZPegawaiM::getNamaPegawai($data->idpegawai_menyetujui)'
                    ),
                    array(
                        'header' => 'Status Persetujuan',
                        'type' => 'raw',
                        'value' => '($data->status_persetujuan==FALSE)?"BELUM DISETUJUI"."<br>".CHtml::link("<i class=\'icon-ok\'></i> ","javascript:persetujuan($data->pengajuanbahanmkn_id, \'$data->nopengajuan\', \'cek\')",array("id"=>"$data->pengajuanbahanmkn_id","rel"=>"tooltip","title"=>"Klik Untuk Melakukan Persetujuan")):"SUDAH DISETUJUI"',
                        'htmlOptions' => array('style'=>'text-align:center')
                    ),
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/Pengajuanbahanmkn/detailPengajuan",array("id"=>$data->pengajuanbahanmkn_id,"frame"=>TRUE)),array("id"=>"$data->pengajuanbahanmkn_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk melihat Rincian Pengajuan Bahan Makanan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: left')
                    ),
                    array(
                        'header'=>'Terima Bahan',
                        'type'=>'raw',
                        //'value'=>'(\'empty($data->terimabahanmakan_id)\')? CHtml::link("<i class=\'icon-form-terimabahan\'></i> ", Yii::app()->controller->createUrl("/gizi/Terimabahanmakan/index",array("idPengajuan"=>$data->pengajuanbahanmkn_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Penerimaan")) : "Telah Diterima"','htmlOptions'=>array('style'=>'text-align: left')
                        'value' => function ($data){
                            if ( !empty($data->terimabahanmakan_id) ):
                                return "Telah Diterima";
                            else:    
                              //  if ($data->status_persetujuan == TRUE)
                             //   {    
                                    return CHtml::link("<i class='icon-form-terimabahan'></i> ", "javascript:persetujuan($data->pengajuanbahanmkn_id, '$data->nopengajuan', '')",array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Penerimaan"));
                               //}else{
                               //     return "INVALID";
                               // }                                
                            endif;
                        }
                    ),
    //		'ruangan_id',
    //		'supplier_id',	
    /*        	'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    */

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->
</div>
<?php 
$js = <<< JSCRIPT
function openDialog(id){
    $('#dialogDetail').dialog('open');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('head',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengajuan Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 850,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="100%" onload="javascript:resizeIframe(this);">
</iframe>';

$this->endWidget();

$controller = Yii::app()->controller->id; 
$module = Yii::app()->controller->module->id; 
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
?>

<script>
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}    

    function persetujuan(id,no,cek){
        var url = '<?php echo $url."/persetujuan"; ?>';
        
        if (cek == "cek")
        {
            myConfirm('Anda Akan Melakukan Persetujuan Untuk Pengajuan Bahan Makanan No Pengajuan <b>'+no+'</b> ?','Perhatian',function(r){
                if (r){
                     $.post(url, {id: id, no:no,cek:cek},
                         function(data){
                            if(data.status == 'proses_form'){
                                    $.fn.yiiGridView.update('gzpengajuanbahanmkn-grid');
                                    myAlert('No Pengajuan <b>'+data.nopengajuan+'</b> Sukses <b>DISETUJUI</b>')
                                }else {
                                    myAlert('Data Gagal <b>DISETUJUI</b>')
                                }
                    },"json");
               }
            });
        }else{
           // alert(url);
            //myConfirm('Apakah Anda yaki','Perhatian',function(r){
              //  if (r){
                     $.post(url, {id: id, no:no,cek:cek},
                         function(data){
                            if(data.status == 'cek_form'){                                    
                                    myAlert('<b>('+data.no+')</b> Pengajuan Bahan Makanan Belum Disetujui','Perhatian')
                                }else{
                                    //alert(data.url);
                                    window.location.href = data.url;
                                }
                    },"json");
              // }
          //  });
        }
    }

</script>
