<?php

if (!defined("INDEX")): define("INDEX", "framework/relays/index.php"); endif;

if (isset($var)): printf("<pre>%s</pre>", var_export($var, true)); unset($var);
elseif (isset($tpl)): print $tpl . PHP_EOL; unset($tpl);
elseif (isset($file)):

	$previous_false = false;
	if (isset($current_file)): $previous_file = $current_file; endif;
	
	$current_file = $file; unset($file);
	$file_found = false;
	
	if (is_string($current_file)):
	
		if (file_exists($current_file) AND is_file($current_file)):
		
			include $current_file;
			$file_found = true;
		
		endif;
	
	elseif (is_object($current_file)):
	
		if ($current_file->found):
		
			include $current_file->local;
			$file_found = true;
		
		endif;
	
	endif;
	
	if ($file_found === false):
	
		$file_found = null;
		$var = sprintf("File not found: &quot;%s&quot;", $current_file); include INDEX;
	
	endif;

elseif (isset($files)):

	if (is_array($files) AND count($files)):
	
		foreach ($files as $file): include INDEX; unset($file); endforeach;
	
	else: $var = $files; include INDEX;
	endif;

else:
endif;

?>