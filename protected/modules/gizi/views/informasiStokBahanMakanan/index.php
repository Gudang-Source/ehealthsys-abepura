<div class="white-container">
    <legend class="rim2">Informasi Stok <b>Bahan Makanan</b></legend>
    <?php 
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gzstokbahanmakanan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Stok <b>Bahan Makanan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'gzstokbahanmakanan-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",                        
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(

                   array(
                       'header' => 'Nama Bahan Makanan',
                       'value' => '$data->namabahanmakanan',
                   ),
                    array(
                        'header' => 'Tanggal Terima',
                        'value' => function($data){
                            $criteria = new CDbCriteria();
                            $criteria->select = "tbm.tglterimabahan AS tgl";
                            $criteria->join = "JOIN terimabahanmakan_t tbm ON tbm.terimabahanmakan_id = t.terimabahanmakan_id";
                            $criteria->addCondition("bahanmakanan_id = ".$data->bahanmakanan_id);
                            $criteria->order = "tglterimabahan DESC";
                            $criteria->limit = 1;
                            $tglterima = GZTerimabahandetailT::model()->find($criteria);
                            
                            if (count($tglterima)>0){
                                return MyFormatter::formatDateTimeForUser($tglterima['tgl']);
                            }else{
                                return '-';
                            }
                        }
                    ),
                    array(
                        'header' => 'Masuk',
                        'value' => '!empty($data->masuk)?number_format($data->masuk,0,"","."):"0"',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header' => 'Keluar',
                        'value' => '!empty($data->keluar)?number_format($data->keluar,0,"","."):"0"',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header' => 'Jumlah',
                        'value' => '!empty($data->jumlah)?number_format($data->jumlah,0,"","."):"0"',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                        'header' => 'Keterangan',
                        'value' => function($data){
                            $criteria = new CDbCriteria();
                            $criteria->addCondition("bahanmakanan_id = ".$data->bahanmakanan_id);
                            $criteria->order = "tgltransaksi DESC";
                            $criteria->limit = 1;
                            $keterangan = GZStokbahanmakananT::model()->find($criteria);
                            
                            if (count($keterangan)>0){
                                return $keterangan['keterangan_makanan'];
                            }else{
                                return '-';
                            }
                        }
                    )
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
