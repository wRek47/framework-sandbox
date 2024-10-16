<?php

include "cms/pages/home/docs/bootup.classes.php";

$docs = new Documentation;

table_system("documents", cursor("common/database/cms/docs/home/database/contents.json"), $_TABLE['documents']);
$docs->documents = &$_TABLE['documents']->rows;

$docs->filesys = cursor("cms/pages/home/docs")->tree;

include "cms/pages/home/docs/bootup.forms.php";

$_TABLE['documents']->save();

?>