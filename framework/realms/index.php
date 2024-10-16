<?php

if (!isset($_FW)):

	define("FW", "framework/");
	define("FW_INDEX", $current_file);
	
	require_once FW . "functions/index.php";
	require_once FW . "classes/index.php";
	
	$_FW = [
		"longitude" => 47.6,
		"latitude" => -122.86,
		"region" => "America/Los_Angeles",
		"dst" => date("I") ? true : false
	];
	
	date_default_timezone_set($_FW['region']);
	$sun_info = date_sun_info(time(), $_FW['longitude'], $_FW['latitude']);
	
	$_FW['sunrise'] = $sun_info['sunrise'];
	$_FW['sunset'] = $sun_info['sunset'];
	
	$now = new DateTime;
	
	$_TABLE = [];
	
	$_TIME = [
		"region" => date("e"),
		"timezone" => date("O"),
		"tz" => date("T"),
		"dst" => $_FW['dst'],
		"time" => time(),
		"microtime" => microtime(),
		"today" => date("l"),
		"month" => date("F"),
		"day" => date("j"),
		"dayeth" => date("jS"),
		"days" => date("t"),
		"year" => date("Y"),
		"week" => date("W"),
		"weekend" => in_array(date("l"), ["Sunday", "Monday"]) ? true : false,
		"yesterday" => "",
		"tomorrow" => "",
		"longitude" => $_FW['longitude'],
		"latitude" => $_FW['latitude'],
		"sunrise" => $_FW['sunrise'],
		"sunset" => $_FW['sunset'],
		"last_season" => "",
		"season" => "",
		"next_season" => ""
	];
	
	$_TIME['yesterday'] = "";
	$_TIME['tomorrow'] = "";

	$y = $_TIME['year'];

	$seasons = [
		[ "date" => "/12/21", "text" => "Winter", "remaining" => 0 ],
		[ "date" => "/09/21", "text" => "Fall", "remaining" => 0 ],
		[ "date" => "/06/21", "text" => "Summer", "remaining" => 0 ],
		[ "date" => "/03/21", "text" => "Spring", "remaining" => 0 ]
	];
	
	$first_season_time = strtotime($y + 1 . "/03/21");
	foreach ($seasons as $date => $season):
	
		$next_season_time = isset($last_season_time) ? $last_season_time : $first_season_time;
		
		$date = $y . $season['date'];
		$season_start_time = strtotime($date);
		$now = strtotime("now");
		
		$season['date'] = $date;
		$season['remaining'] = $next_season_time - $now;
		
		if ($now >= $season_start_time): break; endif;
		
		$last_season_time = $season_start_time;
	
	unset($date, $season); endforeach; unset($y, $first_season_time, $last_season_time, $next_season_time, $season_start_time, $now);
	
	$seasons = array_reverse($seasons);
	$season_id = array_query_id($seasons, $season['text'], "text");

	$next_season_id = $season_id + 1;
	$last_season_id = $season_id - 1;
	
	if ($next_season_id > count($seasons)): $next_season_id = 0; endif;
	if ($last_season_id < 0): $last_season_id = count($seasons); endif;

	$_TIME['season'] = $season['text'];
	$_TIME['last_season'] = $seasons[$last_season_id]['text'];
	$_TIME['next_season'] = $seasons[$next_season_id]['text'];
	$_TIME['season_countdown'] = $season['remaining'];

	unset($season_id, $next_season_id, $last_season_id, $season);
	
	unset($datetime, $sun_info);
	
	$_SPACES = [];
	
	include FW_INDEX;

elseif (empty($_SPACES)):

	session_start();
	
	$_SPACES['query'] = urldecode(http_build_query($_GET));
	
	start_global("_GET", "crumb", "home");

	$_SPACES['rotation'] = 0;
	$key = crumb_key($_GET, "crumb");
	if (str_contains($key, ":")): list($key, $_SPACES['rotation']) = explode(":", $key); endif; unset($key);

	// start_global("_GET", "structures", "leftSidebar::rotation:0/mainContent::rotation:0");
	start_global("_GET", "order", "globe::latitude:-123,longitude:47,date:" . date("Y-m-d") . ",time:" . time() . ",microtime:" . microtime() . ",duration:PTH0");
	
	$_SPACES['globe'] = urldecode(http_build_query($_GET));
	$_SPACES['surface'] = false;
	
	$_SPACES['surface'] = [
		"crumb" => decode_pairs($_GET[crumb_key($_GET, "crumb")], "/", ":"),
		"order" => decode_property($_GET['order'], "/", ":")
	];

	if (isset($_GET['surfaces'])): $_SPACES['structures'] = decode_pairs($_GET['surfaces'], "/", ":");
	else: $_SPACES['structures'] = []; endif;
	
	// unset($_SESSION['visitor']);
	start_global("_SESSION", "token", encode_token(generate_code()));
	// start_global("_SESSION", "user");
	
	/* $link = new NavLink;
	$link->href = hyperlink("home");
	$link->text = "Home"; */
	
	if (!defined("BASE")): define("BASE", "/"); endif;
	// $var = sprintf('<a href="%s">%s</a>', BASE . $link->href, $link->text); include INDEX;
	
	$_INNER = [];

	$_FORMS = [];

	$_LAYOUT = [];
	$_PAGE = [];
	
	include FW_INDEX;

else:

	$fw = new FrameWork;
	
	table_system("visits", cursor("common/database/cms/traffic/visits.json"), $_TABLE['visits']);
	table_system("visits", cursor("common/database/cms/traffic/visitors.json"), $_TABLE['visitors']);
	
	$fw->visits = &$_TABLE['visits']->rows;
	$fw->visitors = &$_TABLE['visitors']->rows;
	
	$fw->init_user();

	table_system("", cursor("common/database/cms/users.json"), $_TABLE['users']);
	$fw->users = &$_TABLE['users']->rows;

	$fw->user['token'] = array_query($fw->users, $fw->user['visitor']->id, "visitor_id");

	if ($fw->user['token']):
	
		table_system("userProfile", cursor("common/database/cms/users/{$fw->user['token']->id}/profile.json"), $_TABLE['user_profile']);
		$fw->user['profile'] =& $_TABLE['user_profile']->rows;
	
	else:
	
		$fw->user['profile'] = json_decode('{ "name": "Guest" }');
	
	endif;
	
	// $var = $_SESSION; include INDEX;
	// $var = $_SPACES; include INDEX;
	// $var = $fw->user; include INDEX;
	
	foreach ($_TABLE as $key => $table): if ($table): $table->save(); endif; unset($key, $table); endforeach;

endif;

?>