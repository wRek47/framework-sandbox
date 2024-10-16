<?php

$cms->website = json_decode('{
    "title": "Sandbox.180"
}');

$cms->users = json_decode('[ {
    "id": 1,
    "visitor_id": 1,
    "name": "root",
    "lockdown": ""
} ]');

$cms->_pages = json_decode('[ {
    "id": 1,
    "crumb": "home",
    "file": "cms/pages/home/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 2,
    "crumb": "versions",
    "file": "cms/pages/versions/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 3,
    "crumb": "structures",
    "file": "cms/pages/structures/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 4,
    "crumb": "systems",
    "file": "cms/pages/systems/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 5,
    "crumb": "relativity",
    "file": "cms/pages/relativity/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 6,
    "crumb": "home/examples",
    "file": "cms/pages/home/examples/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 7,
    "crumb": "home/docs",
    "file": "cms/pages/home/docs/index.php",

    "title": "Untitled Page",
    "description": ""
}, {
    "id": 8,
    "crumb": "home/helpdesk",
    "file": "cms/pages/helpdesk/index.php",

    "title": "Untitled Page",
    "description": ""
} ]');

$cms->page = array_query($cms->_pages, crumb_id(1), "crumb");
if (!$cms->page): $cms->page = current($cms->_pages); endif;

$fw->user['cms'] = array_query($cms->users, $fw->user['visitor']->id, "visitor_id");
$cms->user = &$fw->user['cms'];

$_SPACES['is_logged_in'] = $cms->user ? true : false;

$siteNav = new BootstrapNavigation("nav flex-column", [
    new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home"), "Home"),
    new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs"), "Documentation"),
    new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/helpdesk"), "Helpdesk")
]);

    if ($_SPACES['is_logged_in']):
    
        $userNav = new BootstrapNavigation("nav flex-column border-top", [
            new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("versions"), "Versions"),
            new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("systems"), "Systems"),
            new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("structures"), "Structures"),
            new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("relativity"), "Relativity")
        ]);
    
    endif;

$layoutHeader = new BootstrapCardHeader("", "bg-success text-light fs-3 p-3", $cms->website->title);
$layoutFooter = new BootstrapCardFooter("", "bg-dark text-light p-3", "");

$layoutSidebar = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", "Main Menu"),
    [
        new BootstrapCardBody("", "card-body p-0", $siteNav),
        new BootstrapCardBody("", "card-body p-0", $userNav)
    ]
);

$layoutMainSidebar = new BootstrapGridRowColumn("", "col-12 col-lg-3 col-md-4 bg-light py-3 border-end", $layoutSidebar);
$layoutMainContent = new BootstrapGridRowColumn("", "col-12 col-lg-9 col-md-8 py-3", $cms->page->file);

$layoutMain = new BootstrapGrid("", "container-fluid", [
    new BootstrapGridRow("", "row", [$layoutMainSidebar, $layoutMainContent])
]);

$layout = new BootstrapInterface([$layoutHeader, $layoutMain, $layoutFooter]);

/* if (is_array($cms->page)): $file = current($cms->page)->file;
elseif (is_object($cms->page)): $file = $cms->page->file;
elseif (is_string($cms->page)): $file = $cms->page;
endif; include INDEX; unset($cms->page); */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link type="text/css" rel="stylesheet" href="/common/packages/bootstrap/5.3.3/bootstrap.min.css" />    
    <link type="text/css" rel="stylesheet" href="/common/packages/bootstrap/5.3.3/bootstrap-icons.min.css">

    <link type="text/css" rel="stylesheet" href="/common/packages/reset/full.css" />

    <!-- script type="text/javascript" src="/common/packages/jquery/3.5.1/jquery.slim.min.js"></script -->
    <script type="text/javascript" src="/common/packages/bootstrap/5.3.3/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="/common/packages/three/three.min.js"></script>
    <script type="text/javascript" src="/common/packages/canvasMS/player.movement.js"></script>

    <script type="text/javascript" src="/common/packages/reset/structure-rotation.js"></script>
</head>
<body>

<? $interface = $layout->inner; include BOOTSTRAP; ?>

<script type="text/javascript" src="/common/packages/reset/structure-rotation-listener.js"></script>
</body>
</html>