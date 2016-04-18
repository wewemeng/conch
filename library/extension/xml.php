<?php //defined('IN_FATE') or exit('access denied'); 当 XML 生成时，它通常会在节点之间包含空白 XML文档只能包含一个根元素

        class IXml {
               
            private $handler;         
            private $document=array();
            private $unFinishTag = NULL;
            private $tree=array();

            public function __construct(){
                $this->handler = xml_parser_create('ISO-8859-1');                     
                xml_parser_set_option($this->handler, XML_OPTION_CASE_FOLDING, false); 
                xml_set_object($this->handler, $this);                                 
                xml_set_element_handler($this->handler, 'parseTagStart','parseTagEnd');  
                xml_set_character_data_handler($this->handler, 'parseData');                      
            }
               
            /**
             * @brief 打开创建XML文档 
             **/
            public function openXml($file){
           
                $xmlData = file_get_contents($file); 
                xml_parse($this->handler,$xmlData,true);
                return $this->tree;
            }
               
            /**
             * @brief 解析XML文档标签开始
             **/
            public function parseTagStart($handler,$tag,$attributes){
                
                $this->data = '';

                if(empty($this->unFinishTag)){
                    $this->unFinishTag = $tag;
                    $this->document = &$this->tree[$tag];
                    $this->sy = $this->document;
                }else{
                    $this->sy = &$this->document;
                    $this->document = &$this->document[$tag];
                }
            }
            
            /**
             * @brief 解析XML标签内数据
             **/
            public function parseData($handler,$data){
                   $this->data.=$data; 
            }
            
            /**
             * @brief 解析XML文档标签结束
             */
            public function parseTagEnd($handler,$tag){
                
                    if(!is_array($this->document)){
                         $this->document = $this->data;
                    }
                    
                    if($this->unFinishTag==$tag){
                         $this->unFinishTag = NULL;
                    }else{
                         $this->document = &$this->sy;
                    }
            }
               
            /**
             * @brief 创建XML文档节点 
             **/
            public function addXmlElement(){

            }
               
            /**
             * @brief 删除XML文档节点 
             **/
            public function removeXmlElement(){

            }
              
            /**
             * @brief XML文档转换为数组 
             **/
            public function xmlToArray(){

            }

            /**
             * @brief 数组转换成XML数据 
             **/
            public function arrayToXml(){

            }
               

        }


?>