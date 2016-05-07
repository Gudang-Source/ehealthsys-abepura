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
<br><br><br><br>
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
                        <td width="25%">: &nbsp;<?php echo $model->nobuktibayar;?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align:right;" align="right">Tanggal BKM</td>
                        <td>: &nbsp;<?php echo MyFormatter::formatDateTimeForUser($model->tglbuktibayar);?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>Telah Terima Dari</td>
                        <td>:&nbsp;<?php echo $model->darinama_bkm;?></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Angka </td>
                        <td>: <span>Rp. <?php echo number_format($model->jmlpembayaran,0,"",".");?>,-</span></td>
                    </tr>
                    <tr>
                        <td>Dalam Jumlah Huruf</td>
                        <td>: <i><?php echo $format->formatNumberTerbilang($model->jmlpembayaran); ?> rupiah</i></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;" align="center">&nbsp;</td>
        </tr>
        <tr>
            <td width="100%">
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Tanggal</th>
                            <th style="text-align:center;" >Keterangan</th>
                            <th style="text-align:center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $rows = "";
                            $biayaAdmin = 0;
                            $total = 0;
                            $jumlah = 0;
                            foreach($rincianTagihan as $i=>$rincian){
                                $jumlah = $rincian->qty_oa * $rincian->hargasatuan_oa;
                                $biayaAdmin += $rincian->biayaadministrasi + $rincian->biayaservice + $rincian->biayakonseling;
                                $total+=($jumlah+$biayaAdmin);
                                $rows .= '<tr>';
                                $rows .= '<td>&nbsp;'.MyFormatter::formatDateTimeForUser($rincian->tglpenjualan).'</td>';
                                $rows .= '<td>'.$modPenjualan->NoFaktur.' - '.$rincian->obatalkes_kode.' - '.$rincian->obatalkes_nama.' - '.$rincian->qty_oa.' '.$rincian->satuankecil_nama.'</td>';
                                $rows .= '<td style="text-align:right;">'.number_format($jumlah,0,"",".").'&nbsp;&nbsp;</td>';
                            }
                            if($biayaAdmin > 0){
                                $rows .= '<tr>';
                                $rows .= '<td>&nbsp;'.date("d-m-Y H:i:s", strtotime($rincian->tglpenjualan)).'</td>';
                                $rows .= '<td>'.$modPenjualan->NoFaktur.' - Biaya Racik ,dll.</td>';
                                $rows .= '<td style="text-align:right;">'.number_format($biayaAdmin,0,"",".").'&nbsp;&nbsp;</td>';
                            }
                            //total
                            $rows .= '<tr>';
                                $rows .= '<td colspan=2>&nbsp;</td>';
                                $rows .= '<td style="text-align:right;">'.number_format(($biayaAdmin + $total),0,"",".").'&nbsp;&nbsp;</td>';
                            echo $rows;
                        ?>              
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
            <tr>
                <td style="text-align:center;"><b><div>
                            <?php
                                if (!empty($modPenjualan->pasienpegawai_id) || !empty($modPenjualan->pasieninstalasiunit_id)){
                                    echo "PENJELASAN: <BR>".$modPenjualan->jenispenjualan;
                                    if(!empty($modPenjualan->pasienpegawai_id))
                                        echo ' / '.$modPegawai->gelardepan.' '.$modPegawai->nama_pegawai.', '.$modPegawai->gelarbelakang_nama.' / NIP. '.$modPegawai->nomorindukpegawai;
                                    else if (!empty($modPenjualan->pasieninstalasiunit_id))
                                        echo ' / '.$modInstalasi->instalasi_nama.' / '.$modInstalasi->instalasi_lokasi;
                                }
                            ?>
                        </div></b></td>
            </tr>
            <tr>
                <td><b><div>&nbsp;</div></b></td>
            </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="20%" style="text-align:center;">Dicatat Oleh</td>
                        <td style="text-align:center;">Manager Keuangan</td>
                        <td width="20%" style="text-align:center;">Kasir</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;" height="100">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div>......</div>
                        </td>
                        <td style="text-align:center;">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>                            
                            <div>......</div>
                        </td>
                        <td style="text-align:center;">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>                            
                            <div>......</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
