<?php

echo '<tr>
                    <td>'
                        .CHtml::checkBox('checkList[]',true,array('class'=>'cekList','onclick'=>'hitungSemua()'))
                        .CHtml::activeHiddenField($modDetail, '[0]golbahanmakanan_id', array('value'=>$model->golbahanmakanan_id))
                        .CHtml::activeHiddenField($modDetail, '[0]bahanmakanan_id', array('value'=>$model->bahanmakanan_id))
                        .CHtml::activeHiddenField($modDetail, '[0]harganettobhn', array('value'=>$model->harganettobahan,'class'=>'integer2'))
                        .CHtml::activeHiddenField($modDetail, '[0]jmlkemasan', array('value'=>$model->jmldlmkemasan,'class'=>'integer2'))            
                        .CHtml::activeHiddenField($modDetail, '[0]hargajualbhn', array('value'=>$model->hargajualbahan,'class'=>'integer2'))
                        .CHtml::activeHiddenField($modDetail, '[0]ukuran_bahanterima', array('value'=>$ukuran))
                        .CHtml::activeHiddenField($modDetail, '[0]merk_bahanterima', array('value'=>$merk))
                    .'</td>
                    <td>'.CHtml::textField('noUrut',0,array('id'=>'noUrut','class'=>'noUrut span1', 'readonly'=>true)).'</td>
                    <td>'.$model->golbahanmakanan->golbahanmakanan_nama.'</span></td>
                    <td>'.$model->jenisbahanmakanan.'</td>
                    <td>'.$model->kelbahanmakanan.'</td>
                    <td>'.$model->namabahanmakanan.'</td>
                    <td style="text-align: right;">'.$model->jmlpersediaan.'</td>
                    <td>'.CHtml::activeDropDownList($modDetail, '[0]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array( 'class'=>'span2 satuanbahan')).'</td>
		    <td>'.CHtml::activeTextField($modDetail, '[0]harganettobahan', array('value'=>$model->harganettobahan, 'class'=>'span2 integer2 harganettobahan', 'onblur'=>'hitung(this);','readonly'=>false))
			 .CHtml::activeHiddenField($modDetail, '[0]hargajualbahan', array('value'=>$model->hargajualbahan, 'class'=>'span2 integer2 hargajualbahan', 'readonly'=>true)).'</td>
                    <td>'.CHtml::activeTextField($modDetail, '[0]discount', array('value'=>$model->discount, 'class'=>'discount span1 integer2', 'onkeyup'=>'hitungTotalDiscount();')).'</td>'.
                    // <td><span name="[0][tglkadaluarsabahan]">'.MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan).'</span></td>
                    '<td>'.
					//$this->renderPartial('_waktu', array('modDetail'=>$modDetail), true, true).
					'<div class="input-append">'.
					CHtml::activeTextField($modDetail, '[0]tglkadaluarsabahan', array('readonly'=>true,'value'=>MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan),'class'=>'tanggal dtPicker2', 'style'=>'float:left;')).
					'<span class="add-on tgl_tombol" onclick="$(this).parent().find(\'.tanggal\').datepicker(\'show\')"><i class="icon-calendar"></i></span>'.
					'</div>'.
					'</td>'.
                    '<td>'.CHtml::activeTextField($modDetail, '[0]qty_terima', array('value'=>$qty, 'class'=>'span1 integer2 qty', 'onblur'=>'hitung(this);')).'</td>
                    <td>'.CHtml::activeTextField($modDetail, '[0]subNetto', array('value'=>$subNetto, 'class'=>'span2 integer2 subNetto','readonly'=>true)).'</td>
                    <td>'.CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')).'</td>
                    </tr>';

