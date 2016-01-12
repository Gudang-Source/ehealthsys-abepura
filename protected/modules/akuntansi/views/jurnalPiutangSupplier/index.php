<?php
$this->breadcrumbs=array(
	'Jurnal Hutang Supplier',
);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
?>
<div class="white-container">
	<legend class="rim2">Transaksi <b>Posting Jurnal Utang Supplier</b></legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>'.',
        'thousands'=>',',
        'precision'=>0,
    )
));?>
<?php echo $this->renderPartial('_search', array('model'=>$model)); ?>

<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'jurnalpiutangsupplier-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)',
                'onSubmit'=>'return unformatSemuaInput();'
            ),
            'focus'=>'#',
        )
    );
?>
<div class="block-tabel"> 
<h6>Tabel <b>Jurnal Rekening</b></h6>
<div id="jurnalpiutangsupplier-grid" class="grid-view">
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>Pilih<br><?php 
                    echo CHtml::checkBox('checkAllRekening',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAllDetail()','checked'=>'checked')) ?>
                </th>
                <th width="10px">No.</th>
                <th>Tgl. Faktur</th>
                <th>No. Faktur</th>
                <th>Supplier</th>
                <th width="156px">No. Rek</th>
                <th width="256px">Rekening</th>
                <th width="64px">Debit</th>
                <th width="64px">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php $this->renderPartial('_rowRekening',array('modRekenings'=>$modRekenings)); ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan ='7' style="text-align:right;font-weight:bold;" > Total </td>
                <td><?php echo CHtml::textField('totalDebit',0,array('class'=>'inputFormTabel currency integer','readonly'=>true)); ?></td>
                <td><?php echo CHtml::textField('totalKredit',0,array('class'=>'inputFormTabel currency integer','readonly'=>true)); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
</div>
<div>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Posting Jurnal',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id."/".$this->id), 
        array('class'=>'btn btn-danger')); ?>
</div>

<?php $this->renderPartial('_jsFunctions');?>


<?php $this->endWidget(); ?>

<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebitKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit dan Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));
echo CHtml::hiddenField('row',0,array('readonly'=>true)); //untuk mencatat asal baris di klik
$modRekKredit = new RekeningakuntansiV('searchAccounts');
$modRekKredit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
//    $modRekKredit->rincianobyek_nb = $_GET['RekeningakuntansiV']['rincianobyek_nb'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekkreditdebit-m-grid',
	'dataProvider'=>$modRekKredit->searchAccounts(),
	'filter'=>$modRekKredit,
        'template'=>"{pager}{summary}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Kode Rekening</center>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebitKredit",
                                    "onClick" =>"
                                        var data = {
                                            rincianobyek_id:$data->rekening5_id,
                                            obyek_id:$data->rekening4_id,
                                            jenis_id:$data->rekening3_id,
                                            kelompok_id:$data->rekening2_id,
                                            struktur_id:$data->rekening1_id,
                                            nmrincianobyek:\"$data->nmrekening5\",
                                            kdstruktur:\"$data->kdrekening1\",
                                            kdkelompok:\"$data->kdrekening2\",
                                            kdjenis:\"$data->kdrekening3\",
                                            kdobyek:\"$data->kdrekening4\",
                                            kdrincianobyek:\"$data->kdrekening5\",
                                            saldodebit:\"$data->saldodebit\",
                                            saldokredit:\"$data->saldokredit\",
                                            status:\"debit\"
                                        };
                                        var row = $(\"#dialogRekDebitKredit #row\").val();
                                        editDataRekeningFromGrid(data, row);
                                        $(\"#dialogRekDebitKredit\").dialog(\"close\");    
                                        return false;
                            "))',
                ),
                array(
                    'header'=>'No Urut',
                    'value'=>'$data->nourutrek',
                ),
                array(
                    'header'=>'Rek. 1',
                    'name'=>'kdrekening1',
                    'value'=>'$data->kdrekening1',
                ),
                array(
                    'header'=>'Rek. 2',
                    'name'=>'kdrekening2',
                    'value'=>'$data->kdrekening2',
                ),
                array(
                    'header'=>'Rek. 3',
                    'name'=>'kdrekening3',
                    'value'=>'$data->kdrekening3',
                ),
                array(
                    'header'=>'Rek. 4',
                    'name'=>'kdrekening4',
                    'value'=>'$data->kdrekening4',
                ),
                array(
                    'header'=>'Rek. 5',
                    'name'=>'kdrekening5',
                    'value'=>'$data->kdrekening5',
                ),
                array(
                    'header'=>'Nama Rekening',
                    'name'=>'nmrekening5',
                    'value'=>'$data->nmrekening5',
                ),
                array(
                    'header'=>'Nama Lain',
                    'name'=>'nmrekeninglain5',
                    'value'=>'$data->nmrekeninglain5',
                ),
                array(
                    'header'=>'Saldo Normal',
                    'name'=>'rekening5_nb',
                    'value'=>'$data->saldonormal',
                    'filter'=>  CHtml::dropDownList('RekeningakuntansiV[saldonormal]', $modRekKredit->rekening5_nb, array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>'-- Pilih --', 'style'=>'width:64px;'))
                ),
            
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
</div>