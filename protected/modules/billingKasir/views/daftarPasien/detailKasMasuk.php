<?php 
    if(!is_null($caraPrint))
    {
        if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
            header('Cache-Control: max-age=0');     
        }     
    }
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<style>
    .grid th {
        border: 1px solid;
        padding: 2px;
        background-color: transparent;
        text-align: center;
    }
    .grid td{
        border: 1px solid;
        padding: 2px;
        background-color: transparent;
    }
</style>
    <table width="100%">
        <tr>
            <td style="text-align:center;" align="center"><b>BUKTI KAS MASUK</b></td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                        <td style="text-align:right;" width="25%" align="right">No. BKM</td>
                        <td width="25%">: &nbsp;<?php echo $data['header']['no_bkm']?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right;" align="right">Tgl. BKM</td>
                        <td>: &nbsp;<?php echo $data['header']['tgl_bkm']?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1024">
                    <tr>
                        <td width="150">Telah Terima Dari</td>
                        <td>:&nbsp;<?php echo $data['header']['pembayar']?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: &nbsp;<span class="currency"><?php echo $data['header']['total_bayar']?></span></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>:<i>&nbsp;<?php echo $data['header']['total_bayar_huruf']?> Rupiah</i></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table width="1024" class="<?php echo (!is_null($caraPrint) ? "grid" : "table-striped table-bordered table-condensed")?>">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="150">Tanggal</th>
                            <th style="text-align:center;" >Keterangan</th>
                            <th style="text-align:center;" width="150">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $rows = '';
                            if(count($data['detail']) > 0)
                            {
                                $rows = '';
                                foreach($data['detail'] as $val)
                                {
                                    $rows .= '<tr>';
                                    $rows .= '<td>'. MyFormatter::formatDateTimeForUser($val['tglpembayaran']) .'</td>';
                                    $rows .= '<td>'. $val['keterangan'] .'</td>';
                                    $rows .= '<td style="text-align:right;">'. $format->formatUang($val['jumlah']) .'</td>';
                                    $rows .= '</tr>';                                    
                                }
                            }else{
                                $rows .= '<tr>';
                                $rows .= '<td colspan="3">data kosong</td>';
                                $rows .= '</tr>';
                            }
                            echo $rows;
                        ?>              
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
<?php
    if(!empty($caraPrint))
    {
        
    }else{
?>
        <div class="form-actions">
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')), 
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PRINT")'
                    )
                );
            ?>
            <?php
                echo CHtml::link(
                    Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')), 
                    'javascript:void(0);',
                    array(
                        'class'=>'btn btn-info',
                        'onClick'=>'print("PDF")'
                    )
                );
            ?>
<?php
$urlPrint = $actionUrl;
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=890px');

}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);

    }
?>
<!-- <script type="text/javascript">
//	$(document).ready(function(){
//		$(".currency").each(
//                    function()
//                    {
//                        var val = $(this).text();
//                        $(this).text(formatNumber(val));
//                    }
//		);                
//	});
 </script>-->