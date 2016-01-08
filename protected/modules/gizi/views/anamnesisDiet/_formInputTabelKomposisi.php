<div>
    <legend class="rim"> Table Komposisi Makanan </legend>
    <table class="items table table-bordered table-condensed" id="tblInputKomposisi">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Makanan</th>
                <th>Satuan</th>
                <th>Berat Bahan<br>(gr)</th>
                <th>Energi Kalori <br> (Kal)</th>
                <th>Protein <br> (g)</th>
                <th>Lemak <br> (g)</th>
                <th>Hidrat Arang <br> (g) </th>
                <th>Ket. Pekerjaan</th>
                <th>URT</th>
                <th>Keterangan</th>
                <th>Batal</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
           <tr class="trfooter">
                <td colspan="3">Total</td>
                <td>
                    <?php echo CHtml::textField("totBeratBahan", 0, array('readonly'=>false,'class'=>'inputFormTabel numbersOnly lebar3 totberatbahan','style'=>'width:80px;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totEnergiKalori", 0, array('readonly'=>false,'class'=>'inputFormTabel numbersOnly lebar3 totenergikalori','style'=>'width:80px;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totProtein", 0, array('readonly'=>false,'class'=>'inputFormTabel numbersOnly lebar3 totprotein','style'=>'width:80px;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totLemak", 0, array('readonly'=>false,'class'=>'inputFormTabel numbersOnly lebar3 totlemak','style'=>'width:80px;',)); ?>
                </td>
                <td>
                    <?php echo CHtml::textField("totHidratArang", 0, array('readonly'=>false,'class'=>'inputFormTabel numbersOnly lebar3 tothidratarang','style'=>'width:80px;',)); ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>