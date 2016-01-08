<div class="block-tabel" id="frmGridJurnalRek">
    <h6>Grid <b>Jurnal Rekening</b></h6>
    <table id="daftar-jural-rek-grid" class="table table-striped table-condensed">
        <thead>
            <tr>
                <th rowspan="2">Pilih<br><?php 
                    echo CHtml::checkBox('checkAllObat',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
                </th>
                <th rowspan="2">Tgl. Jurnal</th>
                <th rowspan="2">No. Bukti Jurnal</th>
                <th rowspan="2">Kode Jurnal</th>
                <th rowspan="2">Uraian Jurnal</th>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Nama Rekening</th>
                <!--<th rowspan="2">Saldo Normal</th>-->
                <th colspan="2"><center>Saldo<center></th>
                <th rowspan="2">Catatan</th>
            </tr>
            <tr>
                <th>Debit</th>
                <th>Kredit</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>