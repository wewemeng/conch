<?php defined('IN_FATE') or die('Access denied');

    /**
     * @brief 模型基类
     * @param $db     数据库操作对象
     * @param $fields 要查询的字段
     * @param $join   关联字串
     * @param $where  查询字串
     * @param $group  分组字串
     * @param $order  排序字串
     * @param $limit  取得条数
     * @param $table  表名
     **/

    class IModel extends IComponent{

            protected $db='';      
            protected $fields='*'; 
            protected $join='';    
            protected $where='';
            protected $group='';
            protected $order='';  
            protected $limit='';
            private   $table ='';

            /**
             * @breif 初始化函数
             **/
            public function  __construct(){ 
                 $this->db = Fate::app()->db;
                 parent::__construct();
            }
            
            /**
             *	@brief 设置fields字段
             *  @param $fields 查询的字串
             **/
             public function fields($fields='*'){

                   $this->fields = $fields;
                   return $this;
             }

            /**
             *	@brief 设置join字串 
             **/
            public function join($join=''){

                $this->join  = empty($join)?'':$join;
                return $this;
            }

            /**
             * @brief 设置where字串
             **/	 
             public function where($where=''){

                    $this->where  = empty($where)?'':' WHERE '.$where;
                    return $this;
             }
             
             /**
              * @brief 设置group字串
              */
             public function group($group=''){
                 
                    $this->group = empty($group)?'':' GROUP BY '.$group;
                    return $this;
             }

            /**
             * @brief 设置order字串
             **/
             public function order($order=''){

                    $this->order  = empty($order)?'':' ORDER BY '.$order;
                    return $this;
             }

            /**
            * @brief 设置 limit 字串
            **/
            public function limit($limit=''){

                    $this->limit  = empty($limit)?'':' LIMIT '.$limit;
                    return $this;
            }

            /**
             * @brief 拼装sql 
             **/
             public function sql(){
                    $sql = "SELECT ".$this->fields." FROM ".$this->table." ".$this->join." ".$this->where." ".$this->group." ".$this->order." ".$this->limit;       
                    //echo $sql."<br>";
                    $this->freeCondition();
                    return $sql;
             }
             
             /**
              * @brief 释放sql语句条件
              */
             public function freeCondition(){
                    
                    $this->fields='';
                    $this->join='';
                    $this->where='';
                    $this->group='';
                    $this->order='';
                    $this->limit='';
             }

            /**
             * @brief 执行sql语句 获取所有数据
             **/ 
             public function fetchAll($sql='',$type='assoc',$cacheResult=true){
                 
                    $sql = !empty($sql)?$sql:$this->sql();
                    //echo $sql."<br>";
                    return $this->db->fetchAll($sql,$type='assoc',$cacheResult=true);
             }

            /**
             * @brief 执行sql语句 获的一条数据
             **/
             public function fetchOne($sql='',$type='assoc',$cacheResult=true){
                 
                    $sql = !empty($sql)?$sql:$this->sql();
                    return $this->db->fetchOne($sql,$type='assoc',$cacheResult=true);
             }

            /**
             * @breif 插入操作
             **/	  
             public function insert($arr){
                 
                   return $this->db->insert($this->table,$arr);
             }

             public function insertStr($fields,$values){

                   return $this->db->insertStr($this->table,$fields,$values);
             }

            /**
             * @breif 修改操作
             **/
            public function update($arr,$where='1=1'){

                    return $this->db->update($this->table,$arr,$where);
            }

            /**
             * @breif 删除操作 
             **/
            public function delete($where){

                    $this->db->delete($this->table,$where);
            }
                         
            /**
             * @brief 返回数据库对象
             **/					  
             public function getDb(){
                 
                   return $this->db;
             }
             
             /**
              * @brief 设置表名 
              **/
             public function setTable($value){
                 $this->table = $this->db->prefix.$value;
             }
             
             /**
              * @brief 获取表名
              */
             public function getTable(){
                 return $this->table;
             }
             
    }

?>