<fieldset class="box">
    <legend class="rim">Data Supplier</legend>
    <table width="100%" class="table-condensed">
        <tr>            
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_nama',array('class'=>'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modSupplier,'supplier_id', array('readonly'=>true)); ?>
                    <div class="controls">
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$modSupplier,
                                            'attribute'=>'supplier_nama',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('keuangan/BayarUangMukaBeli/daftarSupplier').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val(""); //SUPAYA TERLIHAT DATA SUDAH TERPILIH ATAU BELUM
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) {
                                                        isiDataSupplier(ui.item);
                                                        return false;
                                                    }',
                                            ),
											'tombolDialog'=>array('idDialog'=>'dialogSupplier'),
                                        )); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_alamat',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_alamat', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_website',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_website', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_email',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_email', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_kode',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activetextField($modSupplier,'supplier_kode', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_telp',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_telp', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modSupplier, 'supplier_fax',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modSupplier,'supplier_fax', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td> 
        </tr>
<!--             <td><?php //echo CHtml::activeLabel($modSupplier, 'supplier_npwp',array('class'=>'control-label')); ?></td>
            <td><?php //echo CHtml::activeTextField($modSupplier,'supplier_npwp', array('readonly'=>true)); ?></td> -->
    </table>
</fieldset> 


<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupplier',
    'options'=>array(
        'title'=>'Daftar Supplier',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>620,
        'resizable'=>false,
    ),
));
$format = new MyFormatter();
$modSup = new KUSupplierM();
$modSup->unsetAttributes();
if(isset($_GET['KUSupplierM'])){
    $modSup->attributes = $_GET['KUSupplierM'];
 }

$provider = $modSup->searchSupplierDialog();
$provider->sort->defaultOrder = 'supplier_nama asc';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'supplier-m-grid',
	'dataProvider'=>$provider,
	'filter'=>$modSup,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
										
                                        isiDataSupplier(".json_encode($data->attributes).");
										$(\'#KUSupplierM_supplier_nama\').val(\'".$data->supplier_nama."\');
                                        $(\'#dialogSupplier\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
				'supplier_nama',
				'supplier_alamat',
                

                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); }',
)); 

$this->endWidget();
?>

<script type="text/javascript">
function isiDataSupplier(data)
{
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_kode');?>').val(data.supplier_kode);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_alamat');?>').val(data.supplier_alamat);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_telp');?>').val(data.supplier_telp);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_npwp');?>').val(data.supplier_npwp);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_fax');?>').val(data.supplier_fax);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_website');?>').val(data.supplier_website);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_email');?>').val(data.supplier_email);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_id');?>').val(data.supplier_id);
    $('#<?php echo CHtml::activeId($modSupplier, 'supplier_nama');?>').val(data.value);
    
    $('#KUTandabuktikeluarT_namapenerima').val(data.supplier_nama);
    $('#KUTandabuktikeluarT_alamatpenerima').val(data.supplier_alamat);
        
    $('.currency').each(function(){this.value = formatNumber(this.value)})
}
</script>

