<?php

if (!function_exists('mb_strlen')):

    function mb_strlen($string, $encoding = "UTF-8") {

        return custom_mb_strlen($string, $encoding);
    
    }

    function custom_mb_strlen($string, $encode = "UTF-8") {
    
        $length = 0;

        $regex = '/([\x00-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF]{2}|[\xF0-\xF7][\x80-\xBF]{3})/x';
        preg_match_all($regex, $string, $matches);

        foreach ($matches[0] as $match): $length += strlen($match) > 1 ? 1 : 0.5; unset($match); endforeach;

        return $length;

    }

endif;

if (!function_exists('mb_convert_encoding')):

    function mb_convert_encoding($string, $toEncoding, $fromEncoding) {
    
        if ($fromEncoding == 'UTF-8' && $toEncoding == "ISO-8859-1"): return utf8_decode($string);
        elseif ($fromEncoding == 'ISO-8859-1' && $toEncoding == "UTF-8"): return utf8_encode($string);
        else: return $string; // Return the string as is if conversion is not supported
        endif;
    
    }

endif;

// 

function markdown($content) {

    // if (!defined("ROOT")): 
    if (!class_exists("Parsedown")): include ROOT . "common/packages/markdown/parsedown.php"; endif;

    if (class_exists("Parsedown")):
    
        $parsedown = new Parsedown;
        $content = $parsedown->text($content);
    
    endif;

    return $content;

}

function markdown_decode($markdown) {

    $doc = new DOMDocument();
    $doc->loadHTML(mb_convert_encoding($markdown, "HTML-ENTITIES", "UTF-8"));

    $chaptersNode = $doc->getElementsByTagName("ul")->item(0);

    $chapters = [];
    if ($chaptersNode): $chapters = extractMarkdownList($chaptersNode); endif;

    return $chapters;

}

function markdown_encode($data) {

    $markdown = '';

    foreach ($data as $item):
    
        $tabs = str_repeat("\t", substr_count($item->id, '.'));
        $markdown .= $tabs . '- ' . $item->title . "\n";
    
    unset($item); endforeach;

    return $markdown;

}

function extractMarkdownList($node, $chapterID = "") {
    $chaptersNodeItems = [];

    $i = 0;
    foreach ($node->childNodes as $chaptersNodeItem) {

        if ($chaptersNodeItem->nodeName === 'li' && $chaptersNodeItem->nodeValue != "\n") {
        
            $i++;
            $chapterTitle = current(explode("\n", rtrim($chaptersNodeItem->nodeValue, PHP_EOL)));
            
            $chapter = (object) array();
                $chapter->id = ltrim($chapterID . "." . $i, ".");
                $chapter->title = $chapterTitle;
                $chapter->file = "";

            // var_dump(current(explode("\n", $chaptersNodeItem->nodeValue)));
            array_push($chaptersNodeItems, $chapter);

            // Check if the node item contains a nested <ul> element
            $nestedUl = $chaptersNodeItem->getElementsByTagName('ul')->item(0);
            if ($nestedUl) {
                $chaptersNodeItems = array_merge($chaptersNodeItems, extractMarkdownList($nestedUl, $chapter->id));
            }
        }
    }

    return $chaptersNodeItems;
}

function start_global($series, $key, $value) {

	global $GLOBALS;
	
    if ($key == "crumb"): $key = crumb_key($GLOBALS[$series], $key); endif;

	if (!isset($GLOBALS[$series][$key])):
    
        if (str_contains($key, "crumb")): $value = encode_pairs($value, "/", ":"); endif;
        $GLOBALS[$series][$key] = $value;
    
	else:
	    
		$surface = decode_pairs($GLOBALS[$series][$key], "/", ":");

		if (str_contains($key, "crumb")):
		
			$structures = encode_pairs($surface, "/", ":");
		
		elseif ($key == "structures" OR $key == "order"):
		
			$structures = decode_property($value);
			$structures = array_merge($structures, decode_property($GLOBALS[$series][$key]));
			
			$structures = encode_property($structures);
		
		elseif ($key == "horizon" OR $key == "page"):
		
			$structures = decode_pairs($value, "/", ":");
			$structures = encode_pairs(array_merge($structures, $surface), "/", ":");
		
		else:
		
			if ($series == "_SESSION"): $structures = $GLOBALS[$series][$key];
			else: $structures = $surface; endif;
		
		endif;
		
		$GLOBALS[$series][$key] = $structures;
	
	endif;
	
	return $GLOBALS[$series];

}

function crumb_key($data = [], $key = "crumb") { return current(key_contains($data, $key)); }

function crumb_id($length, $short = true) {

    global $_SPACES;
    
    // $key = current(key_contains($_GET, "crumb"));
    $key = "crumb";

    $crumbs = $_SPACES['surface'][$key]; unset($key);
    if ($length > count($crumbs)): return false; endif;

    $result = "";

    for ($i = 1; $i <= count($crumbs); $i++):
    
        $key = key($crumbs);
        next($crumbs);

        if ($short):
        
            if ($i == $length): return $key; endif;
        
        else: $result .= "/" . $key; unset($key); endif;
    
    endfor; unset($i);

    return ltrim($result, "/");

}

function crumb_value($length, $short = true) {

    global $_SPACES;

    $crumbs = $_SPACES['surface']['crumb'];
    if ($length > count($crumbs)): return false; endif;

    $results = [];

    for ($i = 1; $i <= count($crumbs); $i++):
    
        if ($short AND $i == $length): array_push($results, current($crumbs));
        elseif (!$short): array_push($results, current($crumbs)); endif;

        next($crumbs);
    
    endfor; unset($i);

    if ($short): $results = current($results); endif;

    return $results;

}

function set_page($crumb_id, $pages, $default_page) {

    global $_PAGE;

    $breadcrumb = "";
    $crumbs = [];
    for ($i = 1; $i < $crumb_id; $i++):
    
        $breadcrumb .= crumb_id($i) . "/";
        array_push($crumbs, ucfirst(crumb_id($i)));
    
    endfor; unset($i);

    $breadcrumb .= crumb_id($crumb_id);

    $pageKey = lcfirst(implode("", $crumbs));
    $page = array_query($pages, $breadcrumb, "crumb");

    if (!$page): $page = array_query($pages, $default_page, "crumb"); endif;
    
    $_PAGE[$pageKey] = $page;

}

function surface($target) {

    global $_SPACES;
    
    $result = 0;
    if (isset($_SPACES['structures'][$target])): $result = $_SPACES['structures'][$target]; endif;

    return $result;

}

function create_hyperlink($text, $crumb = "", $keys = [], $append = false) {

    $link = new NavLink(hyperlink($crumb, $keys, $append), $text);
    return $link;

}

function hyperlink($crumb = "", $keys = [], $append = false) {

	global $GLOBALS;
	
	if (!is_array($keys)): $keys = [$keys]; endif;
	
	$results = [];
	$result = "";
	
	$rows = decode_path($GLOBALS['_SPACES']['query'], ["&", "/"], ["=", ":"]);
	$breadcrumb = encode_pairs($GLOBALS['_SPACES']['surface'][crumb_key($GLOBALS['_SPACES']['surface'], "crumb")], "/", ":");
	
	$data = array_keys($keys);
	if (!isset($data['crumb'])): array_unshift($data, "crumb"); endif;
	
	$data = array_flip($data);
	
	foreach ($data as $key => $value):
	
		if (isset($keys[$key])): $data[$key] = $keys[$key]; endif;
	
	unset($key, $value); endforeach;
	
	$result = array_merge($data, $keys);
	
	if ($append): $crumb = $breadcrumb . "/" . $crumb; endif;
	$result['crumb'] = rtrim($crumb, "/");
	
    $key = crumb_key($_GET, "crumb");

    if ($result['crumb']): $result = "?" . encode_pairs($result, "&", "=");
	else: $result = ""; endif;

    if ($key !== "crumb"): $result = str_replace("?crumb", "?{$key}", $result); endif;
	
	return $result;

}

function encode_global($data) {

	$result = "?";
	
	$pairs = [];
	
	foreach ($data as $key => $value): $pair = sprintf("%s=%s", $key, $value); array_push($pairs, $pair); unset($key, $value); endforeach;
	$result .= implode("&", $pairs);
	
	return $result;

}

//

function format_date($string, $stamp) {

    if (is_string($stamp)): $stamp = new DateTime($stamp); endif;
    return $stamp->format($string);

}

//

function key_contains($array, $substring) {

    return array_filter(array_keys($array), fn($key) => str_contains($key, $substring));

}

function array_query_id($array, $value, $property) {

    $column = array_column($array, $property);
    $id = array_search($value, $column); unset($column);

    return ($id !== false) ? $id : false;

}

function array_query($array, $value, $property, $both = false) {

    $id = array_query_id($array, $value, $property);
    if ($id === false): return !$both ? false : [0, false]; endif;

    return !$both ? $array[$id] : [$id, $array[$id]];

}

function array_query_both($array, $value, $property) { return array_query($array, $value, $property, true); }

function array_query_all($array, $value, $property, $both = false) {

    $result = [];

    foreach ($array as $key => $data):
    
        if ($property == $key AND $value != $data): continue; endif;
        if ($both): $result[$key] = $data;
        else: array_push($result, $data); endif;
    
    unset($key, $value); endforeach;

    return $result;

}

/* function array_query_all($array, $value, $property, $matrix = [], $reduction = []) {

    $matrix = $array;
    list($row_id, $row) = array_query_both($matrix, $value, $property);

    if ($row):
    
        array_push($reduction, $result);
        unset($matrix[$row_id]);

        return array_query_all($array, $value, $property, $matrix, $reduction);
    
    else: $reduction = $row; return $reduction;
    endif;

} */

function decode_row($str, $x = "&") { if (is_string($str)): return explode($x, $str); else: return []; endif; }
function encode_row($array, $x = "&") { if (is_array($array)): return implode($x, $array); else: return $array; endif; }

function decode_pairs($str, $x = "&", $y = "=") {

	$rows = decode_row($str, $x);
	
	foreach ($rows as $id => $row):
	
		$matrix = decode_row($row, $y);
		
		$key = current($matrix); next($matrix);
		$value = current($matrix);
		
		$rows[$key] = $value;
		unset($rows[$id]);
	
	unset($id, $row); endforeach;
	
	return $rows;

}

function encode_pairs($array, $x = "&", $y = "=") {

	foreach ($array as $key => $value):
	
		if ($value !== false): $value = $key . $y . $value;
		else: $value = $key; endif;
		
		$array[$key] = $value;
	
	endforeach;
	
	$array = encode_row($array, $x);
	
	return $array;

}

function encode_attributes($array, $x = " ", $y = "=") {

    foreach ($array as $key => $value):
    
        $value = $key . $y .'"' . $value . '"';
        $array[$key] = $value;
    
    unset($key, $value); endforeach;

    $array = encode_row($array, $x);
    return $array;

}

function decode_path($path, $rows = ["&", "/"], $columns = ["=", ":"]) {

	$masterArray = decode_pairs($path, $rows[0], $columns[0]);
	
	foreach ($masterArray as $key => $value):
	
		$valueArray = decode_pairs($value, $rows[1], $columns[1]);
		$masterArray[$key] = $valueArray;
	
	unset($key, $value); endforeach;
	
	return $masterArray;

}

function decode_property($uri) {

	if (str_contains("&", $uri)):
	
		$uri = decode_pairs($uri, "&", "=");
		
		foreach ($uri as $key => $value):
		
			$value = decode_pairs($value, "/", "::");
			
			foreach ($value as $index => $row):
			
				$row = decode_pairs($row, ",", ":");
				$value[$index] = $row;
			
			unset($index, $row); endforeach;
			
			$uri[$key] = $value;
		
		unset($key, $value); endforeach;
	
	else:
	
		$uri = decode_pairs($uri, "/", "::");
		
		foreach ($uri as $key => $value):
		
			$value = decode_pairs($value, ",", ":");
			$uri[$key] = $value;
		
		unset($key, $value); endforeach;
	
	endif;
	
	return $uri;

}

function encode_property($data) {

	foreach ($data as $key => $value):
	
		$data[$key] = encode_pairs($value, ",", ":");
	
	unset($key, $value); endforeach;
	
	$data = encode_pairs($data, "/", "::");
	
	return $data;

}

//

function generate_code($min = 5, $max = 10, $pad = true, $length = 7) {

    $code = rand(0, pow($max, $min) - 1);
    if ($pad): $code = str_pad($code, $length, "0", STR_PAD_LEFT); endif;

    return $code;

}

function encode_token($code) { return convert_uuencode($code); }
function decode_token($string) { if ($string !== false): return convert_uudecode($string); endif; }

//

function define_root($path) {

    $base = $path;
    $cwd = str_replace(DIRECTORY_SEPARATOR, "/", getcwd());

    define("ROOT", $cwd. $base);

}

function file_system($path = "") {

    if (!defined("ROOT")): define_root("/"); endif;
    # $system = new FileSystem;
	// $object = (object) array("local" => "", "name" => "", "ext" => "", "type" => "unknown", "tree" => [], "data" => null, "contents" => null);
	$object = new FileSystem;
	
	$system = clone $object;

    $path = rtrim($path, "//");
    $path = rtrim($path, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR);
        $system->local = $path . "/";

    if (!is_dir(ROOT . $path)): return $system; endif;
    
    $scan = scandir(ROOT . $path); array_shift($scan); array_shift($scan);

    foreach ($scan as $name):
    
        $local = $system->local . $name . "/";
        $local = rtrim($local, "//");
        $local = rtrim($local, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR);
        
        # $item = new FileSystem;
		$item = clone $object;
        
            $item->local = $local;
            $item->name = $name;
            
            $item->type = "unknown";
        
        if (is_dir(ROOT . $local)):
        
            $children = file_system($local);
            
            $item->type = "folder";
            $item->tree = $children->tree; unset($children);
            array_push($system->folders, $item->local);

            foreach ($item->tree as $child):
            
                if ($child->type == "folder"): array_push($item->folders, $child->local);
                elseif ($child->type == "file"): array_push($item->files, $child->local);
                endif;
            
            unset($child_name); endforeach;
            
            array_push($system->tree, $item);
        
        elseif (is_file(ROOT . $local)):
        
            $item->type = "file";
            $item->ext = pathinfo(ROOT . $local, PATHINFO_EXTENSION);
            array_push($system->files, $item->local);
            
            array_push($system->tree, $item);
        
        endif; unset($local);

        if ($item->type == "file"):
        
            $extensions = ["doc", "csv", "json", "md", "mdown", "tpl"];
            $autoloaded = ["json", "md", "mdown", "tpl"]; unset($extensions);

            if (in_array($item->ext, $autoloaded)):
            
                if ($item->ext == "json"): $item->data = import_json($item->local);

                    // (optional) to-do: detect path continuances

                elseif ($item->ext == "md" OR $item->ext == "mdown"): $item->contents = file_get_contents(ROOT . $item->local);
                elseif ($item->ext == "tpl"): $item->contents = file_get_contents(ROOT . $item->local);
                endif;
            
            endif; unset($autoloaded);
        
        endif;
    
    unset($name); endforeach;

    return $system;

}

function parse($segment) {

    $data = [];

    if (strpos($segment, "(") !== false AND strpos($segment, ")") !== false):
    
        $function = rtrim(substr($segment, 0, strpos($segment, "(")), " ");
        $arguments = explode(", ", rtrim(substr($segment,
            strpos($segment, "(") + 1,
            strpos($segment, ")") - strpos($segment, "(") - 1), " "));

        $data = [
            "type" => "function",
            "function" => $function,
            "arguments" => $arguments
        ];
    
    elseif (strpos($segment, "{") !== false AND strpos($segment, "}") !== false):
    
        $function = rtrim(substr($segment, 0, strpos($segment, "{")), " ");
        $arguments = explode(", ", rtrim(substr($segment,
            strpos($segment, "}") + 1,
            strpos($segment, "}") - strpos($segment, "{") - 1), " "));

        $data = [
            "type" => "function",
            "function" => $function,
            "arguments" => $arguments
        ];
    
    else:
    
        $data = [
            "type" => "property",
            "property" => $segment,
            "index" => null
        ];
    
    endif;

    return (object) $data;

}

function cursor($path, $data = null, $make = false) {

    global $_FILESYS;

    if (is_null($_FILESYS)): $_FILESYS = file_system(BASE); endif;
    if (!is_string($path)): return false; endif;
	
    if (is_null($data)): $data = $_FILESYS; endif;
    if (!is_object($data) AND !is_array($data)):
    
        $data = json_class($data);
        if (!$data): return null; endif;
    
    endif;

    $parse = parse($path);
    if ($parse->type == "function"):
    
        $result = false;

        $function = $parse->function;
        $arguments = $parse->arguments;
        $args = implode(", ", $arguments);

        if (count($arguments) === 1): $index = $arguments[0]; endif;
        
        if (is_callable([$data, $function])):
        
            $reflection = new ReflectionMethod($data, $function);

            if ($reflection->getNumberofParameters() === count($arguments)):
            
                $result = $reflection->invokeArgs($cursor, $arguments);
            
            else: # return null; // invalid number of arguments
            endif;

        elseif (function_exists($function)):
        
            $reflection = new ReflectionFunction($function);
            if ($reflection->getNumberofParameters() === count($arguments)):
            
                $result = $reflection->invokeArges($arguments);
            
            else: # return null; // invalid number of arguments
            endif;
        
        else: # return null; // function not found
        
        endif;
        $result = parse_function($parse, $data->seed);
    
    endif;

    $cursor = $data;
    $segments = is_array($path) ? $path : explode("/", $path);

    foreach ($segments as $segment_id => $segment):
    
        if ($segment != ""):
        
            if (is_array($cursor) AND array_key_exists($segment, $cursor)):
            
                $cursor = $cursor[$segment];
            
            elseif (is_object($cursor) AND isset($cursor->tree)): // is dir
            
                # var_dump($segment); exit;
                $query = array_query($cursor->tree, $segment, "name");

                if (isset($query->ext) AND $query->ext == "json"):
                
                    $query->data = import_json(ROOT . $query->local);
                
                elseif (isset($query->ext) AND $query->ext == "php"):
                
                    $query->contents = file_get_contents(ROOT . $query->local);
                
                endif;

                $cursor = $query;
            
            elseif (is_object($cursor) AND property_exists($cursor, $segment)):
            
                $cursor = $cursor->$segment;
            
            else: # var_dump($segment);
            endif;
        
        else: endif;
    
    unset($segment_id, $segment); endforeach;

    if ($make AND !$cursor):
    
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        if (is_file($path) OR $ext): touch(ROOT . $data->local . "/" . $path);
        else: mkdir(ROOT . $data->local . "/" . $path); endif;
    
    endif;

    return $cursor;

}

function plant($path, &$seed, $class = null) {

    $interval = cursor($path);

    if (is_null($seed) or !$seed):
    
        $seed = $interval->data;
    
    endif;
    
    if (!is_null($class) AND is_object($seed)): $seed = json_class($seed, $class); endif;

    $folder = dirname($path);
    $crud = new CRUD($path, $seed);

    return $crud;

}

function parse_function($parse, &$cursor) {

    $function = $parse->function;
    $arguments = $parse->arguments;
    $args = implode(", ", $arguments);

    if (count($arguments) === 1): $index = $arguments[0]; endif;

    if (is_callable([$cursor, $function])):
    
        $reflection = new ReflectionMethod($cursor, $function);

        if ($reflection->getNumberofParameters() === count($arguments)):
        
            # var_dump($cursor);
            $cursor = $reflection->invokeArgs($cursor, $arguments);
            # return $cursor; # var_dump($cursor);
        
        else: # return null; // invalid number of arguments
        endif;

    elseif (function_exists($function)):
    
        $reflection = new ReflectionFunction($function);
        if ($reflection->getNumberofParameters() === count($arguments)):
        
            $cursor = $reflection->invokeArges($arguments);
        
        else: # return null; // invalid number of arguments
        endif;
    
    else: # return null; // function not found
    
    endif;

    return $cursor;

}

function save($cursor, $data) {

    # var_dump($cursor);
    if (isset($cursor->ext)):
    
        if ($cursor->ext == "json"): $contents = !is_string($data) ? json_encode($data) : $data;
        elseif ($cursor->ext == "php"): $contents = $data;
        # elseif ($file->ext == "md" OR $file->ext == "mdown"): $contents = markdown_encode($file->data);
        else: $contents = $data;
        endif;
    
    endif;

    $length = strlen($contents);
    $original_length = strlen(file_get_contents(ROOT . $cursor->local));

    # if ($length !== $original_length): export_json(ROOT . $file->local, $data); endif;
    // if ($contents != file_get_contents(ROOT . $cursor->local)): export_json(ROOT . $cursor->local, $data); endif;
    
    if ($contents != file_get_contents(ROOT . $cursor->local)): file_put_contents(ROOT . $cursor->local, $contents); endif;

}

//
function table_system($name, $cursor, &$data, $automake = false) {

	if (!is_object($cursor)): return false; endif;
	
    $data = new Table($name);
	
        $data->local = $cursor->local;
        
        if ($cursor->ext == "json"): $data->rows = $cursor->data;
        elseif ($cursor->ext == "md" OR $cursor->ext == "mdown"): $data->rows = $cursor->contents;
        elseif ($cursor->ext == "csv"): $data->rows = explode(",", $cursor->contents);
        endif;

}

function json_class($json, $class = null) {

    if ($json == ''): $json = '{}'; endif;
    if (is_null($json)): return false; endif;
    if (is_array($json) AND !is_numeric(key($json))): $json = (object) $json; endif;
    if (is_array($json)): return json_classes($json, $class); endif;

    # var_dump($class);
    $data = is_object($json) ? $json : json_decode($json);
    if (!$data AND file_exists($json) AND is_file($json)): $data = json_class(json_decode(file_get_contents($json)), $class); endif;

    if (is_null($class)): return $data; endif;

    $serial = serialize($data); unset($data);

    $replace = sprintf('O:%d:"%s"', strlen($class), $class);
    $serial = preg_replace('/^O:\d+:"stdClass"/', $replace, $serial); unset($replace);

    $class = unserialize($serial); unset($serial);
    return $class;

}

function json_classes($array, $class) {

    if (is_string($array)): $array = json_decode($array); endif;
    if (!is_array($array)): return false; endif;

    foreach ($array as $id => $data):
    
        $array[$id] = json_class($data, $class);
    
    unset($id, $data); endforeach;

    return $array;

}

function import_json($file, $class = null) {

    if (is_file($file) AND file_exists($file)): $data = json_decode(file_get_contents($file));
    elseif (is_string($file)): $data = json_decode($file);
    else: endif;

    if (!is_null($class) AND class_exists($class)): $data = json_class($data, $class); endif;

    return $data;

}

function export_json($file, $data) {

    # var_dump($data);

    $ext = pathinfo($file, PATHINFO_EXTENSION);

    if ($ext == "json"):
    
        $data = json_encode($data, JSON_PRETTY_PRINT);
        $data = str_replace(DIRECTORY_SEPARATOR . "/", "/", $data);
    
    elseif ($ext == "md"): # var_dump($data);
    endif;

    # $file = ROOT . $file;
    if (is_file($file) AND file_exists($file)): file_put_contents($file, $data); endif;

    return $data;

}

?>