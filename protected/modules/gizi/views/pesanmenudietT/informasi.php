<div class="white-container">
    <legend class="rim2">Informasi Pemesanan <b>Menu Diet</b></legend>
    <?php 
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gzpesanmenudiet-t-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pemesanan <b>Menu Diet</b></h6>
        <?php
		
		$artab = array(
                        array(
                                'header' => 'Tanggal Pesan',
				'name'=>'tglpesanmenu',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
			),
                        array(
                            'header' => 'No Pesan',
                            'name' => 'nopesanmenu',                            
                        ),
                    );
                 if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
			array_push($artab, array(
				'header'=>'Instalasi / Ruangan',
				'type'=>'raw',
				'value'=>'$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
				'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:left;')
			));
                    }
                        array_push($artab, array(
                            'header' => 'Jenis Pesanan',
                            'name' => 'jenispesanmenu',                            
                        ),		                        			
			'nama_pemesan',
                        array(
                            'header' => 'Jenis Diet',
                            'name' => 'jenisdiet.jenisdiet_nama',
                        ),
                        array(
                            'header' => 'Bahan Diet',
                            'name' => 'bahandiet.bahandiet_nama',
                        ),			
			'adaalergimakanan',
			'keterangan_pesan',
			array(
				'header'=>'Rincian',
				'type'=>'raw',
				'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/PesanmenudietT/detailPesanMenuDiet",array("id"=>$data->pesanmenudiet_id)),array("id"=>"$data->pesanmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pemesanan menu diet", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: left')
			));
                
               
		
		if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
			array_push($artab, array(
				'header'=>'Kirim Menu Diet',
				'type'=>'raw',
				//'value'=>'(($data->jenispesanmenu == "'.Params::JENISPESANMENU_PASIEN.'") ? CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")) : CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")))','htmlOptions'=>array('style'=>'text-align: left')
                                'value'=> function ($data){
                                if (empty($data->kirimmenudiet_id)){
                                    if ($data->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
                                    }else{
                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
                                    }                                    
                                }else{
                                    if ($data->status_terima == TRUE){
                                        echo "Sudah Dikirim";
                                    }else{
                                        echo "Sedang Dikirim";
                                    }
                                }                            
                        }
                        ));
                
            
		}
		
		array_push($artab, array(
			'header'=>'Batal <br/> Pesan',
			'type'=>'raw',
			//'value'=>'CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik Untuk Batal Pesan Menu Diet","onclick"=>"batalPesan(\'$data->pesanmenudiet_id\'); return false;"))',
                        'value'=> function ($data){
                            if (empty($data->kirimmenudiet_id)){
                                echo CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik Untuk Batal Pesan Menu Diet","onclick"=>"batalPesan('".$data->pesanmenudiet_id."'); return false;"));
                            }else{
                                echo "Sudah Diproses";
                            }                            
                        }
		));
                
                 array_push($artab, array(
                        'header'=>'Status Terima',
                        'type'=>'raw',
                        'value'=> function ($data){
                            if (empty($data->kirimmenudiet_id)){
                                echo "Pemesanan Belum Diproses";
                            }else{
                                if ($data->status_terima == TRUE){
                                    echo "Sudah Diterima";
                                }else{
                                    if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')){
                                        echo Chtml::link("<button class = 'btn btn-danger'><i class = 'entypo-check'></i> Konfirmasi</button>", '#', array("onclick"=>"terimaKonfirmasi('".$data->pesanmenudiet_id."')"));
                                    }else{
                                        echo "Belum Diterima";
                                    }
                                }
                            }
                        }
                    ));
		
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gzpesanmenudiet-t-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>$artab,
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
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
        'title' => 'Rincian Pemesanan Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => true,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="550">
</iframe>';

$this->endWidget();
?>
<?php 
// Dialog untuk Batal Pesan Menu Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogBatalPesan',
    'options'=>array(
        'title'=>'Batal Pesan Menu Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
		'height'=>600,
        'resizable'=>false,
    ),
));

echo '<div class="divForForm"></div>'; 


$this->endWidget();
//========= Dialog untuk Batal Pesan Menu Diet =============================
?>

<script>
function batalPesan(idPesanDiet){
    var idPesanDiet = idPesanDiet;
		//var answer = myConfirm('Yakin Akan Membatalkan Pemesanan Diet ?');
    myConfirm('Apakah Anda yakin ingin membatalkan pemesanan menu diet?','Perhatian!',function(r){
    if (r){
          $.post('<?php echo $this->createUrl('batalMenuDiet');?>', 
          {idPesanDiet:idPesanDiet}, function(data){
            if (data.status == 'create_form')
            {
                setTimeout("$('#dialogBatalPesan').dialog('open') ",1000);
                $('#dialogBatalPesan div.divForForm').html(data.div);
                $('#dialogBatalPesan div.divForForm form #idPesanDiet').val(data.idPesan);
                $('#dialogBatalPesan div.divForForm form').submit(konfirmBatal);            
            }
            else
            {
               $('#dialogBatalPesan div.divForForm').html(data.div);
               $.fn.yiiGridView.update('gzpesanmenudiet-t-grid');
               setTimeout("$('#dialogBatalPesan').dialog('close') ",1000);

            }
                      
        }, 'json');
    }
    });
}

function konfirmBatal()
{
    
    <?php 
            echo CHtml::ajax(array(
            'url'=>$this->createUrl('batalMenuDiet'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogBatalPesan div.divForForm').html(data.div);
                    $('#dialogBatalPesan div.divForForm form').submit(konfirmBatal);
                }
                else
                {
                    $('#dialogBatalPesan div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('gzpesanmenudiet-t-grid');
                    setTimeout(\"$('#dialogBatalPesan').dialog('close') \",3000);
                }
 
            } ",
    ))
?>;
    return false; 
}

function terimaKonfirmasi(idPesan){
     var url = '<?php echo $this->createUrl("terimaKonfirmasi"); ?>';
        myConfirm('Apakah Anda yakin ingin mengubah status menjadi <b>Sudah Diterima</b> ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {idPesan: idPesan},
                     function(data){
                        if(data.status == 'sukses'){
                                $.fn.yiiGridView.update('gzpesanmenudiet-t-grid');
                            }else if (data.status == 'gagal'){
                                myAlert('Data gagal diubah menjadi status diterima');
                            }else{
                                myAlert(data.pesan);
                            }
                },"json");
           }
        });
}

</script>