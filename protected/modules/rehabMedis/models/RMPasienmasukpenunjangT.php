<?php
class RMPasienmasukpenunjangT extends PasienmasukpenunjangT{
    public $is_adakarcis = 0;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    protected function beforeValidate ()
    {
        // convert to storage format
        //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
        $format = new MyFormatter();
        foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if ($column->dbType == 'date'){
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
                        //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
        }

        return parent::beforeValidate ();
    }
}
?>
