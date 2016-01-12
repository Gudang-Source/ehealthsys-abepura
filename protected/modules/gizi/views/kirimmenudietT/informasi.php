<div class="white-container">
    <legend class="rim2">Informasi Pengiriman <b>Menu Diet</b></legend>
    <?php 
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gzkirimmenudiet-t-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pengiriman <b>Menu Diet</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gzkirimmenudiet-t-grid',
            'dataProvider'=>$model->searchInformasi(),
        //    'filter'=>$model,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-condensed',
			'columns'=>array(       
				array(
					'header'=>'No. Kirim Menu',
					'type'=>'raw',
					'value'=>'isset($data->nokirimmenu) ? $data->nokirimmenu : ""',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Jenis Pesan Menu',
					'type'=>'raw',
					'value'=>'isset($data->jenispesanmenu) ? $data->jenispesanmenu : ""',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Tanggal Kirim Menu',
					'type'=>'raw',
					'value'=>'isset($data->tglkirimmenu) ? MyFormatter::formatDateTimeForUser($data->tglkirimmenu) : ""',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Nama Pasien',
					'type'=>'raw',
					'value'=>'isset($data->kirimmenupasien->kirimmenupasien_id) ? $data->kirimmenupasien->pasien->nama_pasien : isset($data->kirimmenupegawai->kirimmenupegawai_id) ? $data->kirimmenupegawai->pegawai->NamaLengkap : ""',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Instalasi / Ruangan',
					'type'=>'raw',
					'value'=>'isset($data->kirimmenupasien->kirimmenupasien_id) ? $data->kirimmenupasien->ruangan->instalasi->instalasi_nama." / ".$data->kirimmenupasien->ruangan->ruangan_nama : isset($data->kirimmenupegawai->kirimmenupegawai_id) ? $data->kirimmenupegawai->ruangan->instalasi->instalasi_nama." / ".$data->kirimmenupegawai->ruangan->ruangan_nama : ""',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Nama Bahan Diet',
					'type'=>'raw',
					'value'=>'isset($data->bahandiet_id) ? $data->bahandiet->bahandiet_nama : ""',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Nama Jenis',
					'type'=>'raw',
					'value'=>'(isset($data->jenisdiet_id)?$data->jenisdiet->jenisdiet_nama:"")',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'No. Pesan Menu',
					'type'=>'raw',
					'value'=>'(isset($data->pesanmenudiet)?$data->pesanmenudiet->nopesanmenu:"")',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Ket. <br/> Kirim',
					'type'=>'raw',
					'value'=>'$data->keterangan_kirim',
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center;')
				),
				array(
					'header'=>'Rincian',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/KirimmenudietT/detailKirimMenuDiet",array("id"=>$data->kirimmenudiet_id)),array("id"=>"$data->kirimmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pengiriman menu diet", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',
					'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
					'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:center; width:40px')
				),
				array(
					'header'=>'Retur /<br/> Ubah Menu Diet',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i> ",  Yii::app()->controller->createUrl("/gizi/InformasiMenuDiet/indexKirim",array("idKirimmenudiet"=>$data->kirimmenudiet_id)),array("idKirimmenudiet"=>"$data->kirimmenudiet_id","target"=>"frameUbahMenu","rel"=>"tooltip","title"=>"Klik untuk Retur  / Ubah Menu Diet", "onclick"=>"window.parent.$(\'#dialogUbahMenu\').dialog(\'open\')"));',
					'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
				array(
					'header'=>'Batal <br/> Kirim',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=icon-form-silang></i>","javascript:batalKirim(\'$data->kirimmenudiet_id\')",array("idKirimDiet"=>$data->kirimmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik Untuk Batal Pesan Menu Diet",))',
				),
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
        'title' => 'Detail Pemesanan Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500"></iframe>';

$this->endWidget();
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogUbahMenu',
    'options' => array(
        'title' => 'Retur / Ubah Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 1200,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameUbahMenu" width="100%" height="500"></iframe>';

$this->endWidget();
?>

<?php 
// Dialog untuk Batal Kirim Menu Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogBatalKirim',
    'options'=>array(
        'title'=>'Batal Kirim Menu Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>600,
        'resizable'=>false,
    ),
));

echo '<div class="divForForm"></div>'; 


$this->endWidget();
//========= Dialog untuk Batal Kirim Menu Diet =============================
?>

<script>
function batalKirim(idKirimDiet){
    var idKirimDiet = idKirimDiet;
//    var answer = confirm('Yakin Akan Membatalkan Pengiriman Diet ?');
//    if (answer){
          $.post('<?php echo $this->createUrl('batalKirimMenuDiet');?>', 
          {idKirimDiet:idKirimDiet}, function(data){
            if (data.status == 'create_form')
            {
                setTimeout("$('#dialogBatalKirim').dialog('open') ",1000);
                $('#dialogBatalKirim div.divForForm').html(data.div);
                $('#dialogBatalKirim div.divForForm form #idKirimDiet').val(data.idKirim);
                $('#dialogBatalKirim div.divForForm form').submit(konfirmBatal);            
            }
            else
            {
               $('#dialogBatalKirim div.divForForm').html(data.div);
               $.fn.yiiGridView.update('gzkirimmenudiet-t-grid');
               setTimeout("$('#dialogBatalKirim').dialog('close') ",1000);

            }
                      
        }, 'json');
//    }
}
function konfirmBatal()
{
    
    <?php 
            echo CHtml::ajax(array(
            'url'=>$this->createUrl('batalKirimMenuDiet'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogBatalKirim div.divForForm').html(data.div);
                    $('#dialogBatalKirim div.divForForm form').submit(konfirmBatal);
                }
                else
                {
                    $('#dialogBatalKirim div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('gzkirimmenudiet-t-grid');
                    setTimeout(\"$('#dialogBatalKirim').dialog('close') \",3000);
                }
 
            } ",
    ))
?>;
    return false; 
}
</script>