<?php // path: bootstrap/docs/index.php

if (!class_exists("Documentation")): $files = [
    "framework/bootstrap/docs/framework/classes/documentation.php"
]; include INDEX; endif;

$docs = new Documentation("1.0", "common/database/cms/docs/home/database/");

set_page(3, $docs->pages, "home/docs/cover");
$docs->page = $_PAGE['homeDocs'];

$docs->author = array_query($docs->authors, $fw->user['visitor']->id, "visitor_id");

$_LAYOUT['docs'] = cursor($docs->subFolder . "layout/index.php");

if ($_LAYOUT['docs']): $file = ltrim($_LAYOUT['docs']->local, "/"); include INDEX; endif;

?>