<?php
if (!isset($_CMS)):

    define("CMS", "cms/index.php");

    table_system("cms_startup", cursor("common/database/cms/startup.json"), $_TABLE['cms_startup']);

    $_CMS = &$_TABLE['cms_startup']->rows;

    if (is_null($_CMS)):

        $_CMS = (object) array(
            "configured" => false,
            "versions" => "common/database/cms/versions.json",
            "pages" => "common/database/cms/pages.json"
        );

        $_TABLE['cms_startup']->save();

    endif;

    $cms = clone $_CMS;

        table_system("cms_versions", cursor($cms->versions), $_TABLE['cms_versions']);
        $cms->versions = &$_TABLE['cms_versions']->rows;

        table_system("cms_pages", cursor($cms->pages), $_TABLE['cms_pages']);
        $cms->pages = &$_TABLE['cms_pages']->rows;

    $cms->version = array_query($cms->versions, 1, "id");
    if (!$cms->version): $cms->version = current($cms->versions); endif;

    table_system("cms_structures", cursor($cms->version->structures), $_TABLE['cms_structures']);
    // $cms->version->structures = $_TABLE['cms_structures']->rows;

    $cms->page = array_query($cms->pages, crumb_id(1), "crumb");
    if (!$cms->page): $cms->page = current($cms->pages); endif;

    $file = $current_file; include INDEX;

else:

	$file = ($_SPACES['rotation'] == 180) ? CMS : $cms->version->folder . "index.php";
	include INDEX;

endif;

?>