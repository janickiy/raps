<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function search($path, $query, $regexp = false, $extensions = []){
	$matches = [];
	if(is_readable($path)){
		$dir = opendir($path);
		while(false !== ($file = readdir($dir))){
			if($file == '.' || $file == '..' || $file == '...') continue;
			if(is_file($path.'/'.$file)){
				if(count($extensions) && !in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions)) continue;
				$content = file_get_contents($path.'/'.$file);
				$found = false;
				if($regexp){
					preg_match($query, $content, $match);
					if(count($match)){
						$found = $match;
					}
				} elseif(strpos($content, $query) !== false){
					$found = true;
				}
				if($found){
					$matches[$path.'/'.$file] = $found;
				}
			} elseif(is_dir($path.'/'.$file)) $matches += search($path.'/'.$file, $query, $regexp, $extensions);
		}
	}
	return $matches;
}

$matches = search(__DIR__, '/table-layout: fixed.*\n/iu', true, ['php']);
//$matches = search(__DIR__, 'display_errors', false, ['php']);
var_dump($matches);