<?php

#if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

/*
$avatars_settings = array(
	'thumbs' => array(
		array('w' => 36, 'h' => 36, 'name' => $hashName.'_60', 'ext' => '.jpg', 'crop' => true),
		array('w' => 60, 'h' => 60, 'name' => $hashName.'_36', 'ext' => '.jpg', 'crop' => true)
	),
	'newimg' => array(
		array('max_w' => 200, 'max_h' => 9999999, 'name' => $hashName.'_original')
	),
	'newimg_folder' => $uploadData['file_path'],
	'thumb_folder' => $uploadData['file_path']
	'deleteFile' => false
);
 */

function createImage($file) {
	ignore_user_abort(1);
	if (!function_exists('imagecreatetruecolor') || !function_exists('imagecopyresampled') || !function_exists('imagejpeg')) {
		return array(false, 'imagecreatetruecolor() OR imagecopyresampled() OR imagejpeg() NOT EXISTS');
	}
	if (!file_exists($file)) {
		return array(false, basename($file) . ' - file not exists');
	}
	$type = explode('.', basename($file));
	$type = strtolower(array_pop($type));
	if ($type == 'jpeg' || $type == 'jpg') {
		@$image = imagecreatefromjpeg($file);
	}
	elseif ($type == 'gif') {
		@$image = imagecreatefromgif($file);
	}
	elseif ($type == 'png') {
		@$image = imagecreatefrompng($file);
	}
	elseif ($type == 'bmp') {
		@$image = imagecreatefromwbmp($file);
	}
	else {
		return array(false, basename($file) . ' - bad file format');
	}
	if (!$image) {
		$functions = array('imagecreatefromjpeg', 'imagecreatefromgif', 'imagecreatefrompng', 'imagecreatefromwbmp');
		$i = 0;
		while (!$image && $i < count($functions)) {
			$function = $functions[$i];
			@$image = $function($file);
			$i++;
		}
		if (!$image) {
			return array(false, basename($file) . ' - not image');
		}
		else {
			return array(true, 'im' => $image, 'w' => imagesx($image), 'h' => imagesy($image));
		}
	}
	else {
		return array(true, 'im' => $image, 'w' => imagesx($image), 'h' => imagesy($image));
	}
}

function updateAvatar($file = false, $settings = false) {
	$imgResult = array(true, 'empty message');
	
	if ($settings===false || $file===false) {
		$imgResult = array(false, 'EMPTY settings OR file');
	}
	
	if ($imgResult[0]) {
		$img = createImage($file);
		$imgResult = $img;
	}
	
	if ($imgResult[0] && isset($settings['thumbs']) && is_array($settings['thumbs']) && count($settings['thumbs']) > 0) {
		foreach ($settings['thumbs'] as $thumb) {
			$thumb['fullpath'] = $settings['thumb_folder'].$thumb['name'].'.jpg';
			
			$thumb['im'] = imagecreatetruecolor($thumb['w'], $thumb['h']);
			if ($thumb['im'] !== false) {
				if ( imagecopyresampled(
						/*изображение назначения*/
					$thumb['im'],
						/*изображение источник*/
					$img['im'],
						/*Точка на изображении назначения, которая определяет левый верхний угол прямоугольника в который будет вставляться копируемая область.*/
					0, 0,
						/*Точка на изображении-источнике, которая определяет левый верхний угол прямоугольника, содержащего копируемую.*/
					$thumb['x1'], $thumb['y1'],
						/*ширина и высота прямоугольника в который будет вписана копируемая область.*/
					$thumb['w'], $thumb['h'],
						/*ширина и высота копируемой области на изображении-источнике.*/
					($thumb['x2'] - $thumb['x1']), ($thumb['y2'] - $thumb['y1'])) !== false ) {
						
						$previosFile = file_exists($thumb['fullpath']);
						if (!$previosFile || $previosFile && unlink($thumb['fullpath'])) {
							if ( imagejpeg($thumb['im'], $thumb['fullpath'], 100) !== false ) {
								imagedestroy($thumb['im']);
								unset($thumb['im']);
							}
							else { $imgResult = array(false, 'cant imagejpeg THUMB'); }
						}
						else { $imgResult = array(false, 'cant unlink previos THUMB'); }
					}
					else { $imgResult = array(false, 'cant imagecopyresampled THUMB'); }
			}
			else { $imgResult = array(false, 'cant imagecreatetruecolor THUMB'); }
				
			// Esli hotyabi 1 thumba ne smogla sohranitsya - ydalyaem vse
			if (!$imgResult[0]) {
				foreach ($settings['thumbs'] as $thumb) {
					$thumbFile = $settings['thumb_folder'].$thumb['name'].'.jpg';
					if (file_exists($thumbFile)) { unlink($thumbFile); }
				}
				break;
			}
		}
	}
	return $imgResult;
}

function createAvatar($file = false, $settings_img = false) {
	$imgResult = array(true, 'empty message');
	
	if ($settings_img===false || $file===false) {
		$imgResult = array(false, 'EMPTY settings OR file');
	}
	
	if ($imgResult[0]) {
		$img = createImage($file);
		$imgResult = $img;
	}
	
	#
	if ($imgResult[0] && isset($settings_img['thumbs']) && is_array($settings_img['thumbs']) && count($settings_img['thumbs']) > 0) {
		foreach ($settings_img['thumbs'] as $thumb) {
			if ($thumb['crop']) {
				if ($img['w'] > $img['h']) {
					$tmp = array(($thumb['w'] - $img['w'] * $thumb['h'] / $img['h']) / 2, 0, ($img['w'] * $thumb['h'] / $img['h']), $thumb['h']);
				}
				else {
					$tmp = array(0, ($thumb['h'] - $img['h'] * $thumb['w'] / $img['w']) / 2, $thumb['w'], ($img['h'] * $thumb['w'] / $img['w']));
				}
			}
			else {
				if ($img['w'] > $img['h']) {
					$scale = floor($img['w'] / $thumb['w']);
					$thumb['h'] = floor($img['h'] / $scale);
					$tmp = array(0, 0, $thumb['w'], $thumb['h']);
				}
				else {
					$scale = floor($img['h'] / $thumb['h']);
					$thumb['w'] = floor($img['w'] / $scale);
					$tmp = array(0, 0, $thumb['w'], $thumb['h']);
				}
			}
			
			$thumb['im'] = imagecreatetruecolor($thumb['w'], $thumb['h']);
			$white = imagecolorallocate($thumb['im'], 255, 255, 255);
			imagefill($thumb['im'], 0, 0, $white);
			
			if ($thumb['im'] !== false) {
				if ( imagecopyresampled($thumb['im'], $img['im'], $tmp[0], $tmp[1], 0, 0, $tmp[2], $tmp[3], $img['w'], $img['h']) !==false ) {
					if ( imagejpeg($thumb['im'], $settings_img['thumb_folder'].$thumb['name'].'.jpg', 100) !== false ) {
						imagedestroy($thumb['im']);
						unset($thumb['im']);
					}
					else { $imgResult = array(false, 'cant imagejpeg THUMB'); }
				}
				else { $imgResult = array(false, 'cant imagecopyresampled THUMB'); }
			}
			else { $imgResult = array(false, 'cant imagecreatetruecolor THUMB'); }
			
			// Esli hotyabi 1 thumba ne smogla sohranitsya - ydalyaem vse
			if (!$imgResult[0]) {
				foreach ($settings_img['thumbs'] as $thumb) {
					$thumbFile = $settings_img['thumb_folder'].$thumb['name'].'.jpg';
					//if (file_exists($thumbFile)) { unlink($thumbFile); }
				}
				break;
			}
		}
	}
	else
	{
		$imgResult = 'Cant create THUMB img';
	}
	
	if ($imgResult[0] && isset($settings_img['newimg']) && is_array($settings_img['newimg']) && count($settings_img['newimg']) > 0) {
		
		foreach ($settings_img['newimg'] as $newimg) {
			$tmp = 1;
			if ($img['w'] > $newimg['max_w'] && $img['h'] <= $newimg['max_h']) {
				$tmp = $newimg['max_w'] / $img['w'];
			}
			elseif ($img['w'] <= $newimg['max_w'] && $img['h'] > $newimg['max_h']) {
				$tmp = $newimg['max_h'] / $img['h'];
			}
			elseif ($img['w'] > $newimg['max_w'] && $img['h'] > $newimg['max_h']) {
				$tmp1 = $newimg['max_w'] / $img['w'];
				$tmp2 = $newimg['max_h'] / $img['h'];
				if ($tmp1 > $tmp2) {
					$tmp = $tmp2;
				}
				else {
					$tmp = $tmp1;
				}
			}
			$newimg['w'] = $img['w'] * $tmp;
			$newimg['h'] = $img['h'] * $tmp;
			
			$newimg['im'] = imagecreatetruecolor($newimg['w'], $newimg['h']);
			if ($newimg['im'] !== false) {
				if ( imagecopyresampled($newimg['im'], $img['im'], 0, 0, 0, 0, $newimg['w'], $newimg['h'], $img['w'], $img['h']) !==false ) {
					if ( imagejpeg($newimg['im'], $settings_img['newimg_folder'].$newimg['name'].'.jpg', 100) !== false ) {
						imagedestroy($newimg['im']);
						unset($newimg['im']);
					}
					else { $imgResult = array(false, 'cant imagejpeg IMG'); }
				}
				else { $imgResult = array(false, 'cant imagecopyresampled IMG'); }
			}
			else { $imgResult = array(false, 'cant imagecreatetruecolor IMG'); }
			
			
			// Esli hotyabi 1 img ne smog sohranitsya - ydalyaem vse
			if (!$imgResult[0]) {
				foreach ($settings_img['newimg'] as $newimg) {
					$imgFile = $settings_img['newimg_folder'].$newimg['name'].'.jpg';
					if (file_exists($imgFile)) { unlink($imgFile); }
				}
				break;
			}
		}
	}
	if ($file !== false && file_exists($file)) {
		if (!$imgResult[0]) { unlink($file); }
		else {
			if (!empty($settings_img['deleteFile'])) { unlink($file); }
		}
	}
	
	return $imgResult;

}