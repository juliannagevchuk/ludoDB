<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne Kalleland
 * Date: 21.12.12

 */
class LudoDBIterator extends LudoDBObject implements Iterator
{
    private $loaded;
    private $dbResource;
    private $isValid;
    private $position;
    protected $currentRow;

    function rewind() {
        if ($this->dbResource) {
            $this->dbResource = null;
        }
        $this->position = -1;
        $this->loaded = false;
        $this->isValid = false;
    }

    /**
     * Return current value when iterating collection
     * @method current
     * @return mixed
     */
    public function current() {
        return $this->currentRow;
    }

    /**
     Return key used for iterator. default is numeric.
     @method key
     @return mixed
     @example
        function key(){
            return $this->currentRow['key']
        }
     to return key
     */
    function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
        $this->currentRow = $this->db->nextRow($this->dbResource);
        $this->isValid = $this->currentRow ? true : false;
    }

    public function valid() {
        if (!$this->loaded) {
            $this->load();
        }
        return $this->isValid;
    }

    private function load(){
        $this->dbResource = $this->db->query($this->sqlHandler()->getSql(), $this->arguments);
        $this->loaded = true;
        $this->next();
    }

    private $valueCache;
    /**
     * Return collection data
     * @method getValues
     * @return array
     */
    public function getValues(){
        if(!isset($this->valueCache)){
            $groupBy = $this->parser->getGroupBy();
            $this->valueCache = array();
            $staticValues = $this->parser->getStaticValues();
            foreach($this as $key=>$value){
                if(is_array($value)) $value = array_merge($value, $staticValues);
                if(isset($groupBy) && isset($value[$groupBy])){
                    if(!isset($this->valueCache[$groupBy])){
                        $this->valueCache[$groupBy] = array();
                    }
                    $this->valueCache[$groupBy] = $value;
                }else{
                    $this->valueCache[$key] = $value;
                }
            }
        }
        return $this->valueCache;
    }
}
