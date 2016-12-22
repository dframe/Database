<?php
namespace Dframe\Database;
/**
* Autor: Sławek Kaleta
* Nakładka na PDO_Class_Wrapper_master
*/
include_once(dirname( __FILE__ ) . '/PDO_Class_Wrapper/classx/PdoWrapper.php');

class Database extends \PdoWrapper
{
    private $setWhere = null;
    private $setParams = array();
    private $setOrderBy = null;

    public $WhereChunkKey;
    public $WhereChunkValue;
    public $WhereChunkperator;
    public $addWhereEndParams = array();

    function __construct($dsn = array()){
        parent::__construct($dsn);
    }

    public function getWhere(){
        if(!isset($this->setWhere) OR empty($this->setWhere))
            $this->setWhere = null;
        
        return $this->setWhere;
    }

    public function getParams(){
        return $this->setParams;
    }

    public function getOrderBy(){
        return $this->setOrderBy;
    }

    public function addWhereBeginParams($params){
        array_unshift($this->setParams, $params);
    }

    public function addWhereEndParams($params){
        array_push($this->setParams, $params);
    }


    public function prepareWhere($whereObject, $order = null, $sort = null){
        $where = null;
        $params = null;
        if (!empty($whereObject)) {
            $arr = array();
            /** @var $chunk WhereChunk */
            foreach ($whereObject as $chunk) {
                list($wSQL, $wParams) = $chunk->build();
                $arr[] = $wSQL;
                foreach ($wParams as $k=>$v) {
                    $params[] = $v;
                }
            }
            $this->setWhere = " WHERE ".implode(' AND ', $arr);
            $this->setParams = $params;
        }else{
            $this->setWhere = null;
            $this->setParams = array();
        }

        if (!empty($order)) {
            if(!in_array($sort, array('ASC', 'DESC'))) 
                $sort = 'DESC';
    
            $this->setOrderBy = 'ORDER BY '.$order.' '.$sort;
        }

        return $this;

    }
 

}
