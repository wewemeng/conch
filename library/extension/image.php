<?php defined('IN_FATE') or exit('access denied');

	 /**
     * @brief ͼƬ������
     */
     
		class IImage {
				
					/** 
					 * @brief  ����ͼƬ��Դ
					 * @param  $file ��Ҫ������ͼƬ����
					 * @return $imageRes ͼƬ���
					 */
					public  function createResource($file){
						
									$ext  = pathinfo($file,PHPINFO_EXTENSION);
									$imageRes = '';
							    switch($ext)
							    {
							        case 'jpg' :
							        case 'jpeg':
							        {
							        	$imageRes = imagecreatefromjpeg($file);
							        }
							        break;
						
							        case 'gif' :
							        {
							        	$imageRes = imagecreatefromgif($file);
							        }
							        break;
						
							        case 'png' :
							        {
							        	$imageRes = imagecreatefrompng($file);
							        }
							        break;
						
							        case 'bmp' :
							        {
										$imageRes = imagecreatefromwbmp($file);
							        }
							        break;
							    }
							    return $imageRes;
					}
					
					/**
					 * @brief ����ͼƬ
					 * @param $imageRes ͼƬ���
					 * @param $thumbFilename ����ͼ�ļ�����
					 */
					public function createImage($imageRes,$thumbFileName){
						
									//���Ŀ¼����дֱ�ӷ��أ���ֹ�����׳�
									if(!is_writeable(dirname($thumbFileName)))
									{
										return false;
									}
							
									$imageResult = false;
									//��ȡ�ļ���չ��
									$fileExt  = IFile::getFileSuffix($thumbFileName);
							
								    switch($fileExt)
								    {
								        case 'jpg' :
								        case 'jpeg':
								        {
								        	$imageResult = imagejpeg($imageRes,$thumbFileName,100);
								        }
								        break;
							
								        case 'gif' :
								        {
								        	$imageResult = imagegif($imageRes,$thumbFileName);
								        }
								        break;
							
								        case 'png' :
								        {
								        	$imageResult = imagepng($imageRes,$thumbFileName);
								        }
								        break;
							
								        case 'bmp' :
								        {
													$imageResult = imagewbmp($imageRes,$thumbFileName);
								        }
								        break;
								    }
								  return $imageResult;
						
					}
					
					//��������ͼ
					public function thumb($file,$width,$height,$ext='_thumb',$cut=false){
						
									if(is_file($file))
									{
										//��ȡԭͼ��Ϣ
										list($imgWidth,$imgHeight) = getImageSize($file);
										//����λ��
										$cutx = $cuty = 0;
										//ճ��λ�� 
										$targetx = $targety = 0; 
							
										if($cut)
										{					
												if(($width/$height) >= ($imgWidth/$imgHeight))
												{
													$thumbWidth=$width;
													$thumbHeight=$thumbWidth*($imgHeight/$imgWidth);
												}
												else
												{
													$thumbHeight=$height;
													$thumbWidth=$thumbHeight*($imgWidth/$imgHeight);
												}					
										}else{
												if($imgWidth >= $imgHeight)
												{
													$thumbWidth  = $width;
													$thumbHeight = ($width / $imgWidth) * $imgHeight;
												}
												else
												{
													$thumbWidth  = ($height / $imgHeight) * $imgWidth;
													$thumbHeight = $height;
												}
										}
										$targetx = ($width-$thumbWidth)/2;
										$targety =  ($height-$thumbHeight)/2;
										//����$fileName�ļ�ͼƬ��Դ
									  $thumbRes = self::createResource($file);
								    $thumbBox = imageCreateTrueColor($width,$height);
								    //��䲹��
										$padColor = imagecolorallocate($thumbBox,255,255,255);
							      imagefilledrectangle($thumbBox,0,0,$width,$height,$padColor);
							
										//����ͼ��
								    imagecopyresampled($thumbBox, $thumbRes, $targetx , $targety, $cutx, $cuty, $thumbWidth, $thumbHeight, $imgWidth, $imgHeight);
								    //��������ͼ�ļ���
								    $fileExt       = pathinfo($file,PHPINFO_EXTENSION);
								    $thumbFileName = str_replace('.'.$fileExt,$ext.'.'.$fileExt,$file);
										//����ͼƬ�ļ�
								    $result = self::createImage($thumbBox,$thumbFileName);
						        if($result == true)
						        {
						        	return $thumbFileName;
						        }
									}
									
								  return null;
									
					}
			
		}


?>