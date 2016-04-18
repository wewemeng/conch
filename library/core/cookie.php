<?php defined('IN_FATE') or die('Access denined!');
		
        /**
         * @brief cookie处理组件
         * @param $prefix cookie前缀
         **/
		 
        class ICookie extends IComponent{
            
            protected $prefix;
            
            /**
             * @brief 设置cookie
             * @param string $name 字段名
             * @param string $value 对应的值
             * @param string $time 有效时间
             * @param string $path 工作路径
             * @param string $domain 作用域
             **/
             public function set($name,$value='',$time='3600',$path='/',$domain=null){

                     $time = ($time<=0) ? -100 :time()+$time;
                     if(is_array($value) || is_object($value)) $value=serialize($value);
                     $value = ICrypt::encode($value);
                     setCookie($this->prefix.$name,$value,$time,$path,$domain);
              }

             /**
              * @brief 取得cookie
              * @param string $name 字段名
              * @return mixed 对应的值
              **/
              public function get($name){

                    if(isset($_COOKIE[$this->prefix.$name]))
                    {
                            $cookie= ICrypt::decode($_COOKIE[$this->prefix.$name]);
                            $tem = substr($cookie,0,10);
                            if(preg_match('/^[Oa]:\d+:.*/',$tem)) return unserialize($cookie);
                            else return $cookie;
                    }

                    return null;
              }	
        }

?>