﻿<?php defined('IN_FATE') or die('access deneid');
			
        /**
         * @brief 文件缓存类
         * @param $cacheDepth     缓存目录深度;
         * @param $cacheDir       缓存目录
         * @param $cacheSuffix    缓存文件后缀
         * @param $cacheKeyPrefix 缓存键名前缀
         * @param $gced           垃圾缓存回收标志符
         **/
			 
        class IFileCache extends ICache {

            private  $cacheDepth=2;
            private  $cacheDir;
            private  $cacheSuffix;
            private  $cacheKeyPrefix='fate_';
            private  $gced;

            /**
             * @brief 初始化函数
             **/
            public function init(){


            }

            /**
             * @brief 获取缓存
             * @param $key 自定义键名
             **/
            public function get($key){

                    $cacheKey  = $this->getCacheKey($key);
                    $cacheFile = $this->getCacheFile($cacheKey);

                    if(is_file($cacheFile) && ($time=@filemtime($cacheFile))>time()){

                                  return $content = unserialize(file_get_contents($cacheFile));

                          }else if($time>0){

                                  @unlink($cacheFile);	
                          }

                    return false;
            }

            /**
             * @brief 设置缓存
             **/
            public function set($key,$value=''){

                    $cacheKey  = $this->getCacheKey($key);
                    $cacheFile = $this->getCacheFile($cacheKey);
            }

            /**
             * @brief 删除缓存
             **/
            public function delete($key){


            }

            /**
            * @brief 获取缓存键名
            **/
            public function getCacheKey($key){

                   return md5($this->cacheKeyPrefix.$key);
            }

            /**
             * @brief 获取缓存文件地址
             **/
            public function getCacheFile($cacheKey){

                    $cacheFile = $cacheKey.$this->cacheSuffix;
                    $cachePath = $this->cacheDir;
                    for($i=1;$i<$this->cacheDepth;$i++){
                                  $cachePath.=substr($cacheKey,($i-1)*2,2).'/';
                    }
                    $cachePath.= $this->cacheDir.'/';
                          return $cachePath.$cacheFile;
            }

            /**
             * @brief 回收垃圾缓存
             **/
            public function gc(){


            }

        }


?>