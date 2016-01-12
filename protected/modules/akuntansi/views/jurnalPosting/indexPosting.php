<div class="white-container">
<legend class="rim2">Transaksi <b>Posting Jurnal</b></legend>
	
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#searchLaporan').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
?>
<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success',"Data Jurnal Berhasil di Posting");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="search-form">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
</div>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'jurnalposting-m-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
    <div class="block-tabel well">
        <h6><i class="icon-white icon-list-alt"></i> Tabel <b>Jurnal Rekening</b></h6>
            <div class="span12">
                    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
                            'id'=>'tableLaporan',
                            'dataProvider'=>$model->searchPostingJurnal(),
                            'template'=>"{summary}\n{items}",
                            'itemsCssClass'=>'table table-striped table-condensed',
                            'mergeHeaders'=>array(
                                    array(
                                            'name'=>'<center>Saldo</center>',
                                            'start'=>7,
                                            'end'=>8,
                                    ),
                            ),
                            'columns'=>array(
                                    array(
                                                    'header'=> 'Pilih'.CHtml::checkBox('is_pilihsemua',true,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih / tidak <br>semua jurnal','rel'=>'tooltip')),
                                            'type'=>'raw',
                                            'value'=>'
                                                    CHtml::activeHiddenField($data, \'[\'.$data->jurnaldetail_id.\']jurnaldetail_id\').
                                                    CHtml::checkBox(\'AKJurnalrekeningT[\'.$data->jurnaldetail_id.\'][cekList]\', \'\', array(\'onclick\'=>\'setUrutan(this)\', \'class\'=>\'cekList\'));
                                                    ',
                                            'htmlOptions'=>array('style'=>'width:30px;text-align:center'),
                                    ),
                                    array(
                                            'header'=>'Tgl. Jurnal',
                                            'type'=>'raw',
                                            'value'=>'MyFormatter::formatDateTimeId($data->tglbuktijurnal)',
                                    ),
                                    'nobuktijurnal',
                                    'kodejurnal',
                                    array(
                                            'header'=>'Uraian Jurnal',
                                            'type'=>'raw',
                                            'value'=>'CHtml::activeHiddenField($data, \'[\'.$data->jurnaldetail_id.\']urianjurnal\'). $data->urianjurnal',
                                    ),
                                    'KodeRekening',
                                    array(
                                            'header'=>'Nama Rekening',
                                            'type'=>'raw',
                                            'value'=>'$data->NamaRekening',
                                            'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right;font-style:italic;'),
                                                    'footer'=>'Saldo',
                                    ),
                                    array(
                                            'header'=>'<center>Debit</center>',
                                            'name'=>'saldodebit',
                                            'value'=>'MyFormatter::formatUang($data->saldodebit)',
                                            'htmlOptions'=>array('style'=>'width:100px;text-align:right'),
                                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                            'footer'=>'sum(saldodebit)',
                                    ),
                                    array(
                                            'header'=>'<center>Kredit</center>',
                                            'name'=>'saldokredit',
                                            'value'=>'MyFormatter::formatUang($data->saldokredit)',
                                            'htmlOptions'=>array('style'=>'width:100px;text-align:right'),
                                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                            'footer'=>'sum(saldokredit)',
                                    ),
                            ),
                                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); ?>
            </div>
    </div>
<div class="form-actions">
	<?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Posting Jurnal', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
				array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
	<?php
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/indexPosting'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
	?>
</div>
</div>
<script type="text/javascript">
    function setUrutan(obj)
    {
        var nilai = $(obj).val();
        if(nilai){
            $(obj).val('');
        }else{
            $(obj).val(1);
        }
    }
	/**
	* pilih / tidak semua jurnal
	* @param {type} obj
	* @returns {undefined}
	*/
   function pilihSemua(obj){
	   if($(obj).is(":checked")){
		   $(".cekList").val(1);
		   $(".cekList").attr("checked",true);
	   }else{
		   $(".cekList").val(0);
		   $(".cekList").attr("checked",false);
	   }
   }
</script>
<?php $this->endWidget(); ?>