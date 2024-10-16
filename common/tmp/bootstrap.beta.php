<?php

// attempt #2 at a proper $inner detection

if (isset($inner)):

	if (is_object($inner)):
	
		if ($inner instanceOf BootstrapGrid): $grid = $inner; $inner = true;
		endif;
		
		if ($inner === true): unset($inner); include BOOTSTRAP;
		else: $var = $inner; unset($inner); include INDEX;
		endif;
	
	elseif (is_array($inner)):
	
		$currentInner = $inner; unset($inner);
		foreach ($currentInner as $inner): include SELF; endforeach;
	
	elseif (is_string($inner)):
	
		$file_ext = path_info($inner, PATH_INFO_EXTENSION);
		
		if ($file_ext):
		
			if ($file_ext == "php"): unset($file_ext); $file = $inner; include INDEX;
			elseif ($file_ext == "json"): unset($file_ext); $json = $inner; include INDEX;
			elseif ($file_ext == "yml" OR $file_ext == "yaml"): unset($file_ext); $yaml = $inner; include INDEX;
			elseif ($file_ext == "md" OR $file_ext == "mdown"): unset($file_ext); $mdown = $inner; include INDEX;
			elseif ($file_ext == "csv"): $csv = $inner; include INDEX;
			else: $var = $file_ext; unset($file_ext); include INDEX;
			endif;
		
		else: $tpl = $inner; include INDEX;
		endif;
	
	elseif (is_bool($inner)): unset($inner); include BOOTSTRAP;
	else: $var = $inner; unset($inner); include INDEX;
	endif;

endif;

?>