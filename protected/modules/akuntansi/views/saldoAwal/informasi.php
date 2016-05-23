<div class="white-container">
    <legend class="rim2">Informasi Saldo Awal</legend>

<?php
	$this->breadcrumbs=array(
		'AKSaldoawal Ts'=>array('index'),
		'Manage',
	);

	Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('aksaldoawal-t-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");

	$this->widget('bootstrap.widgets.BootAlert'); 
?>
<?php //$this->widget('ext.bootstrap.widgets.BootGridView',array(
// 	'id'=>'aksaldoawal-t-grid',
// 	'dataProvider'=>$model->search(),
// 	'filter'=>$model,
//     'template'=>"{pager}{summary}\n{items}",
//     'itemsCssClass'=>'table table-striped table-bordered table-condensed',
// 	'columns'=>array(
//         array(
//           'header'=>'No',
//           'type'=>'raw',
//           'value'=>'$row+1',
//           'htmlOptions'=>array('style'=>'width:20px')
//         ),
//         'kdrekening1',
//         'kdrekening2',
//         'kdrekening3',
//         'kdrekening4',
//         'kdrekening5',
//         'nmrekening5',
//         'jmlsaldoawald',
//         'jmlsaldoawalk'
            
// 	),
//         'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
// )); ?>
<?php
	$a=0;
	foreach($rekening1 as $key => $jml) {
		if($key==0){
			$debit1[$key] 	= $jml['debit'];
			$kredit1[$key] 	= $jml['kredit'];
                        $kode1[$key]    = $jml['kdrekening1'];

			$jmlrekening[$key]	= $jml['jmlrekening'];
		}else{
			$jmlrekening[$key]	= $jml['jmlrekening'];
			$a += $jmlrekening[$key-1];
			$debit1[$a] 	= $jml['debit'];
			$kredit1[$a] 	= $jml['kredit'];
                        $kode1[$a]    = $jml['kdrekening1'];
		}
	}

	$a=0;
	foreach($rekening2 as $key => $jml) {
		if($key==0){
			$debit2[$key] 	= $jml['debit'];
			$kredit2[$key] 	= $jml['kredit'];
                        $kode2[$key]    = $jml['kdrekening2'];

			$jmlrekening[$key]	= $jml['jmlrekening'];
		}else{
			$jmlrekening[$key]	= $jml['jmlrekening'];
			$a += $jmlrekening[$key-1];
			$debit2[$a] 	= $jml['debit'];
			$kredit2[$a] 	= $jml['kredit'];
                        $kode2[$a]    = $jml['kdrekening2'];
		}
	}

	$a=0;
	foreach($rekening3 as $key => $jml) {
		if($key==0){
			$debit3[$key] 	= $jml['debit'];
			$kredit3[$key] 	= $jml['kredit'];
                        $kode3[$key]    = $jml['kdrekening3'];

			$jmlrekening[$key]	= $jml['jmlrekening'];
		}else{
			$jmlrekening[$key]	= $jml['jmlrekening'];
			$a += $jmlrekening[$key-1];
			$debit3[$a] 	= $jml['debit'];
			$kredit3[$a] 	= $jml['kredit'];
                        $kode3[$a]    = $jml['kdrekening3'];
		}
	}

	$a=0;
	foreach($rekening4 as $key => $jml) {
		if($key==0){
			$debit4[$key] 	= $jml['debit'];
			$kredit4[$key] 	= $jml['kredit'];
                        $kode4[$key]    = $jml['kdrekening4'];

			$jmlrekening[$key]	= $jml['jmlrekening'];
		}else{
			$jmlrekening[$key]	= $jml['jmlrekening'];
			$a += $jmlrekening[$key-1];
			$debit4[$a] 	= $jml['debit'];
			$kredit4[$a] 	= $jml['kredit'];
                        $kode4[$a]    = $jml['kdrekening4'];
		}
	}
?>
<div id="tableLaporan" class="grid-view">
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr>
          <!-- <th id="tableLaporan_c0" width="25px">
            No.
          </th> -->
            <th id="tableLaporan_c0">
                Kode Akun
            </th>
            <th id="tableLaporan_c0">
                Nama Akun
            </th>
            <th id="tableLaporan_c0">
                Debit
            </th>      
            <th id="tableLaporan_c0">
                Kredit
            </th>
        </tr>
      </thead>  
      <tbody>
      	<?php
      		$spasi = "&emsp;";
      		$namarekening1[-1] = '';
      		$namarekening2[-1] = '';
      		$namarekening3[-1] = '';
      		$namarekening4[-1] = '';
      		$namarekening5[-1] = '';
      		$i=0;
                if (count($rekening5) == 0) {
                    echo '<tr><td colspan="3">Tidak ditemukan hasil</td><tr>';
                }
      		foreach ($rekening5 as $key => $value1) {
      			$namarekening1[$key] = $value1['nmrekening1'];
      			if($namarekening1[$key-1]!=$namarekening1[$key] OR in_array($i, $debit1)){
	      			echo "<tr>";
                                echo "<td>".$kode1[$i]."</td>";
	      			echo "<td><b>".$value1['nmrekening1']."</b></td>";
	      			echo "<td>".number_format($debit1[$i])."</td>";
	      			echo "<td>".number_format($kredit1[$i])."</td>";
	      			echo "</tr>";
	      		}
	      		$namarekening2[$key] = $value1['nmrekening2'];
	      		if($namarekening2[$key-1]!=$namarekening2[$key] OR in_array($i, $debit2)){
	      			echo "<tr>";
                                echo "<td>".$kode2[$i]."</td>";
	      			echo "<td>".$spasi.$value1['nmrekening2']."</td>";
	      			echo "<td>".number_format($debit2[$i])."</td>";
	      			echo "<td>".number_format($kredit2[$i])."</td>";
	      			echo "</tr>";
	      		}
	      		$namarekening3[$key] = $value1['nmrekening3'];
	      		if($namarekening3[$key-1]!=$namarekening3[$key] OR in_array($i, $debit3)){
	      			echo "<tr>";
                                echo "<td>".$kode3[$i]."</td>";
	      			echo "<td>".$spasi.$spasi.$value1['nmrekening3']."</td>";
	      			echo "<td>".number_format($debit3[$i])."</td>";
	      			echo "<td>".number_format($kredit3[$i])."</td>";
	      			echo "</tr>";
	      		}
	      		$namarekening4[$key] = $value1['nmrekening4'];
	      		if($namarekening4[$key-1]!=$namarekening4[$key] OR in_array($i, $debit4)){
	      			echo "<tr>";
                                echo "<td>".$kode4[$i]."</td>";
	      			echo "<td>".$spasi.$spasi.$spasi.$value1['nmrekening4']."</td>";
	      			echo "<td>".number_format($debit4[$i])."</td>";
	      			echo "<td>".number_format($kredit4[$i])."</td>";
	      			echo "</tr>";
	      		}
	      		$namarekening5[$key] = $value1['nmrekening5'];
	      		if($namarekening5[$key-1]!=$namarekening5[$key]){
	      			echo "<tr>";
                                echo "<td>".$value1['kdrekening5']."</td>";
	      			echo "<td>".$spasi.$spasi.$spasi.$spasi.$value1['nmrekening5']."</td>";
	      			echo "<td>".number_format($value1['debit'])."</td>";
	      			echo "<td>".number_format($value1['kredit'])."</td>";
	      			echo "</tr>";
	      		}

	      		$i++;
      		}
      	?>
      </tbody> 
  </table>
</div>

<?php $this->renderPartial('_search',array('model'=>$model)); ?>

</div>