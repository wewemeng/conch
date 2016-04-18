<?php  defined('IN_FATE') or exit('access denied');
			/**
			 * @brief �ļ�ϵͳ������
			 * @param $resource �ļ����
			 */

		  class IFile {
		  	
		  	    private $resource ;
		  	    
		  	    /**
		  	     * @brief ��ʼ�����ļ����
		  	     * @param $file Ҫ�򿪵��ļ�
		  	     * @param $mod  �򿪷�ʽ
		  	     */
		  			public function __construct($file,$mode='r')
						{
							$name = self::name($file);
							$dir  = self::dir($file);
							self::mkdir($dir);
							$this->resource = fopen($file,$mode.'b');
							if($this->resource)
							{
								flock($this->resource,LOCK_EX);
							}
						}
						
						/**
						 * @brief  ��򿪵��ļ�д������
						 * @param  $content Ҫд����ļ�
						 * @return $total д������� 
						 */
						public function write($content)
						{
							$total = fwrite($this->resource,$content);
							return is_bool($total) ? false : $total;
						}
						
						/**
						 * @brief �ͷ���
						 */
						public function save()
						{
							flock($this->resource,LOCK_UN);
						}
						
					  /**
						 * @brief �����������ͷ��ļ����Ӿ��
						 */
						public function __destruct()
						{
							if(is_resource($this->resource))
							{
								fclose($this->resource);
							}
						}
						
		  			/**
		  			 * @brief ��ȡ·���ļ��� ��ָ��ext �򲻷�����չ��
		  			*/
		  			public static function name($file,$ext=''){
		  					
		  					return empty($ext)? basename($file):basename($file,$ext); //pathinfo($file,PHPINFO_EXTENSION)
		  			}
		  			
		  			/**
		  			 * @brief ��ȡ·��Ŀ¼ 
		  			*/
		  			public static function dir($file){
		  				
		  					return dirname($file); //pathinfo($file,PHPINFO_DIRNAME)
		  			}
		  			
		  			/**
		  			 * @brief ��ȡ��չ��
		  			*/
		  			public static function suffix($file){
		  				
		  					return pathinfo($file,PHPINFO_EXTENSION);
		  			}
		  			
		  			/**
		  			 * @brief ��鲢����
		  			 */
						public static function mkdir($path,$chmod=0777)
						{	
								return is_dir($path) || (self::mkdir(dirname($path),$chmod) && mkdir($path,$chmod));
						}
		  			
		  			/**
		  			 * @brief socket ͨ��
		  			*/
		  			public static function socket($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 20, $block = TRUE)
						{
							$return = '';
							$matches = parse_url($url);
							!isset($matches['host']) && $matches['host'] = '';
							!isset($matches['path']) && $matches['path'] = '';
							!isset($matches['query']) && $matches['query'] = '';
							!isset($matches['port']) && $matches['port'] = '';
							$host = $matches['host'];
							$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
							$port = !empty($matches['port']) ? $matches['port'] : 80;
							if($post)
							{
								$out = "POST $path HTTP/1.0\r\n";
								$out .= "Accept: */*\r\n";
								$out .= "Accept-Language: zh-cn\r\n";
								$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
								$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
								$out .= "Host: $host\r\n";
								$out .= 'Content-Length: '.strlen($post)."\r\n";
								$out .= "Connection: Close\r\n";
								$out .= "Cache-Control: no-cache\r\n";
								$out .= "Cookie: $cookie\r\n\r\n";
								$out .= $post;
							}
							else
							{
								$out = "GET $path HTTP/1.0\r\n";
								$out .= "Accept: */*\r\n";
								$out .= "Accept-Language: zh-cn\r\n";
								$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
								$out .= "Host: $host\r\n";
								$out .= "Connection: Close\r\n";
								$out .= "Cookie: $cookie\r\n\r\n";
							}
							$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
							if(!$fp)
							{
								return '';
							}
							else
							{
								stream_set_blocking($fp, $block);
								stream_set_timeout($fp, $timeout);
								@fwrite($fp, $out);
								$status = stream_get_meta_data($fp);
								if(!$status['timed_out'])
								{
									while (!feof($fp))
									{
										if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))break;
									}
									$stop = false;
									while(!feof($fp) && !$stop)
									{
										$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
										$return .= $data;
										if($limit)
										{
											$limit -= strlen($data);
											$stop = $limit <= 0;
										}
									}
								}
								@fclose($fp);
								return $return;
							}
						}
		  			
		  			/**
		  			 * @brief urlץȡ
		  			*/
		  			public static function crawl($type='curl',$method='get'){
		  				
		  				
		  			}
		  			
		  }
		  
		  /*
		   *	chgrp($file,$grp) �ı��ļ������� $grp ��������ID
		   *  chmod($file,0755) �ı��ļ�Ȩ��
		   *  chown($file,$user)�ı��ļ������� $user�û������û�ID
		   *  is_dir()          �ж��Ƿ�ΪĿ¼
		   *  is_file()         �ж��Ƿ�Ϊ�ļ�
		   *  file_exists
		   */

?>