<?php defined('IN_FATE') or die('Access denied');

		/**
		 * @brief ��־���� 
		 **/
		abstract class ILog {
				
					/**
					 * @breif д����־
					 * @param $message ��־��Ϣ
					 * @param $file    ��־�ļ�
					 **/
					abstract protected function write($message,$filePath);
					
					
					/**
					 * @breif ��ȡ��־
					 * @param $file ��־�ļ�
					 **/
					abstract protected function read($file);
			
		}


?>