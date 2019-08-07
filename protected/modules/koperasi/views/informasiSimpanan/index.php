<div class="white-container">
<?php
/* @var $this InformasiSimpananController */

$this->breadcrumbs=array(
	'Informasi',
	'Kartu Simpanan',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('kartuSimpananAnggota-m-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<style type="text/css">
	.input-group-addon{
		cursor: pointer;
	}
</style>

<legend class="rim2">Informasi <b>Simpanan Anggota</b></legend>
<div class="col-md-12">
    <div class="block-tabel">
        <h6>Informasi <b>Simpanan Anggota</b></h6>											
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'kartuSimpananAnggota-m-grid',
		'dataProvider'=>$model->searchInformasi(),
		//'filter'=>$model,
		'itemsCssClass' => 'table table-striped table-condensed',
		'columns'=>array(
				array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            //	 'headerHtmlOptions'=>array('style'=>'vertical-align:text-top;color:#373E4A'),
                                    ),
                    array(
                        'header'=>'Tgl Simpanan',
                        'name'=>'tglsimpanan',
                        'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i", strtotime($data->tglsimpanan)))',
                        'filter'=>false,
                    ),
                    array(
                        'name'=>'nosimpanan',
            	//'headerHtmlOptions'=>array('style'=>'vertical-align:text-top;'),
                    ),
                    'nokeanggotaan',
                    'nama_pegawai',
                    array(
                        'name' => 'nama_pegawai',
                        'value' => '$data->namaLengkap'
                    ),
                    /*array(
                            'name'=>'namaunit',
                            //'filter'=>CHtml::activeDropDownList($model, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
                            ),*/
                    array(
                            'header'=>'Golongan',
                            'name'=>'golonganpegawai_id',
                            //'filter'=>CHtml::activeDropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
                            'value'=>'$data->golonganpegawai_nama',
                            //'headerHtmlOptions'=>array('style'=>'vertical-align:text-top'),
                            ),
                    array(
                            'header'=>'Simpanan <br/> Pokok',
                            'value'=>function ($data) {
                                            if(strtolower($data->jenissimpanan_id) == Params::ID_SIMPANAN_POKOK) {
                                                            return MyFormatter::formatNumberForPrint($data->jumlahsimpanan);
                                                    }
                                                    return 0;
                                    },
                            'htmlOptions'=>array('style'=>'text-align:right'),
                    //	'headerHtmlOptions'=>array('style'=>'text-align:center;color:#373E4A'),
                    ),
                    array(
                            'header'=>'Simpanan <br/> Wajib',
                            'value'=>function ($data) {
                                            if(strtolower($data->jenissimpanan_id) == Params::ID_SIMPANAN_WAJIB) {
                                                            return MyFormatter::formatNumberForPrint($data->jumlahsimpanan);
                                                    }
                                                    return 0;
                                    },
                            'htmlOptions'=>array('style'=>'text-align:right'),
                    //	'headerHtmlOptions'=>array('style'=>'text-align:center;color:#373E4A'),
                    ),
                    array(
                            'header'=>'Simpanan <br/> Sukarela',
                            'value'=>function ($data) {
                                            if(strtolower($data->jenissimpanan_id) == Params::ID_SIMPANAN_SUKARELA) {
                                                            return MyFormatter::formatNumberForPrint($data->jumlahsimpanan);
                                                    }
                                                    return 0;
                                    },
                            'htmlOptions'=>array('style'=>'text-align:right'),
                    //	'headerHtmlOptions'=>array('style'=>'text-align:center;color:#373E4A'),
                    ),
                    array(
                            'header'=>'Simpanan <br/> Deposit',
                            'value'=>function ($data) {
                                            if(strtolower($data->jenissimpanan_id) == Params::ID_SIMPANAN_DEPOSITO) {
                                                            return MyFormatter::formatNumberForPrint($data->jumlahsimpanan);
                                                    }
                                                    return 0;
                                    },
                            'htmlOptions'=>array('style'=>'text-align:right'),
                    //	'headerHtmlOptions'=>array('style'=>'text-align:center;color:#373E4A'),
                    ), /*
                    array(
                            'header'=>'Simpanan <br/> Lain - Lain',
                            'value'=>function ($data) {
                                            if(strtolower($data->jenissimpanan) == 'lain') {
                                                            return MyFormatter::formatNumberForPrint($data->jumlahsimpanan);
                                                    }
                                                    return 0;
                            },
                            'htmlOptions'=>array('style'=>'text-align:right'),
                            'headerHtmlOptions'=>array('style'=>'text-align:center;width:80px;color:#373E4A'),
                    ),
                    array(
                            'header'=>'BKM',
                            'type'=>'raw',
                            'value'=>'empty($data->buktikasmasuk_id)?"-":CHtml::link("<i class=\'entypo-print\'></i>", Yii::app()->controller->createUrl("/printKwitansi/kasmasuk",array("id"=>$data->buktikasmasuk_id)), array("target"=>"_blank"))',
                            'headerHtmlOptions'=>array('style'=>'vertical-align:text-top;color:#373E4A'),
                    ), */
            ),
    )); ?>

    <!--</div>
    <div class="panel-footer" style="text-align:center">
            <?php  //echo Chtml::link('<i class="entypo-print"></i> Print','#', array('onclick'=>'iPrint(); return false;','class' => 'btn btn-success')); ?>
    </div>

	</div>
</div>-->
    </div>
</div>
 <fieldset class="box search-form">
            <legend class="rim"><i class="entypo-search"></i> Pencarian</legend> 
                <?php $this->renderPartial('_search',array('model'=>$model,)); ?>
 </fieldset>
<?php
$urlPrint = $this->createUrl('print');
?>
<?php echo $this->renderPartial('subview/_js', array()); ?>
<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>

<script type="text/javascript">
/*$('#kartuSimpananAnggota-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
$('#kartuSimpananAnggota-m-grid').find("table >thead >tr >th").hover(function() {
  $(this).css("color","#818DA2");
},function(){
  $(this).css("color","#373E4A");
});

$(document).ajaxSuccess(function() {
   $('#kartuSimpananAnggota-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
	$('#kartuSimpananAnggota-m-grid').find("table >thead >tr >th").hover(function() {
	  $(this).css("color","#818DA2");
     },function(){
		  $(this).css("color","#373E4A");
	  });
});
*/
function iPrint() {
	var url = ($(".search-form :input").serialize()).split('&');
	url.shift();
	url = url.join('&');
	window.open('<?php echo $urlPrint; ?>&' + url, '_blank');
}
</script>
</div>
