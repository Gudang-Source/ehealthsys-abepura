<?php
$this->breadcrumbs=array(
	'Jurnal Piutang Pasien',
);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
?>
<div class="white-container">
<legend class="rim2">Transaksi <b>Posting Jurnal Piutang Pasien</b></legend>
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
<fieldset class="box">
	<?php echo $this->renderPartial('_search', array('model'=>$model)); ?>
</fieldset>
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'jurnalpiutangpasien-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event)',
                'onSubmit'=>'return unformatNumberSemua();'
            ),
            'focus'=>'#',
        )
    );
?>
<div class="block-tabel">
<h6>Tabel <b>Jurnal Rekening</b></h6>
<div id="jurnalpiutangpasien-grid" class="grid-view">
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>Pilih<br><?php 
                    echo CHtml::checkBox('checkAllRekening',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAllDetail()','checked'=>'checked')) ?>
                </th>
                <th width="10px">No.</th>
                <th>Nama Pasien</th>
                <th>No. RM <br> / No. Pendaftaran</th>
                <th>Instalasi <br>/ Ruangan</th>
                <th>Cara Bayar <br>/ Penjamin</th>
                <th>Uraian Transaksi</th>
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
                <td colspan ='9' style="text-align:right;font-weight:bold;" > Total </td>
                <td><?php echo CHtml::textField('totalDebit',0,array('class'=>'inputFormTabel currency integer','readonly'=>true)); ?></td>
                <td><?php echo CHtml::textField('totalKredit',0,array('class'=>'inputFormTabel currency integer','readonly'=>true)); ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<div>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Posting Jurnal',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id."/".$this->id), 
        array('class'=>'btn btn-danger')); ?>
</div>
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
$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
// $modRekDebit->rekening5_nb = "D";
$modRekKredit->rekening5_aktif = true;
$account = "";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);


//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
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
                                            rekening5_id:$data->rekening5_id,
                                            kelompokrek:$data->kelompokrek,
                                            koderekeningkel:$data->koderekeningkel,
                                            nmrekening5:$data->nmrekening5,
                                            nmrekeninglain5:\"$data->nmrekeninglain5\",
                                            rekening5_nb:\"$data->rekening5_nb\",
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
                    'header'=>'Rek. 2',
                    'name'=>'kelompokrek',
                    'value'=>'$data->kelompokrek',
                ),
                array(
                    'header'=>'Rek. 4',
                    'name'=>'koderekeningkel',
                    'value'=>'$data->koderekeningkel',
                ),
                array(
                    'header'=>'Rek. 5',
                    'name'=>'rekening5_id',
                    'value'=>'$data->rekening5_id',
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
                    'value'=>'$data->rekening5_nb',
                    'filter'=>  CHtml::dropDownList('RekeningakuntansiV[rekening5_nb]', $modRekKredit->rekening5_nb, array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>'-- Pilih --', 'style'=>'width:64px;'))
                ),
            
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
</div>