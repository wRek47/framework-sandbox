<?php

$website = json_decode('{
    "title": "Sandbox.Local",
    "navigation": {
        "sidebar": {
            "links": [ {
                "href": "home",
                "text": "Home"
            }, {
                "href": "home/docs",
                "text": "Documentation"
            } ]
        },
        "userSidebar": {
            "guest": {
                "links": [ {
                    "href": "user/register",
                    "text": "Register"
                }, {
                    "href": "user/login",
                    "text": "Login"
                } ]
            },
            "member": {},
            "owner": {
                "links": [ {
                    "href": "user/profile",
                    "text": "Profile"
                }, {
                    "href": "user/logout",
                    "text": "Logout"
                } ]
            }
        },
        "pageSidebar": {
            "links": [ {
                "href": "calendar",
                "text": "Calendar"
            } ]
        }
    }
}');

$layoutHeader = new BootstrapCardHeader("", "bg-success p-3", new BootstrapNavLink("text-light fs-3", hyperlink("home"), $website->title));

$timeOfDay = (date("G") > 6) ? "Day" : "Night";

if ($timeOfDay == "Day"):

    $timeOfDay = date("A") == "AM" ? "Morning" : "Afternoon";
    $timeOfDayIcon = "bi bi-sun";

else:

    $timeOfDay = date("A") == "AM" ? "Twilight" : "Evening";
    $timeOfDayIcon = "bi bi-moon";

endif;

$layoutFooterSidebar = new BootstrapCard("", "border",
    false,
    new BootstrapCardBody("", "p-3", [
        sprintf('<i class="%s"></i> %s<br />' . PHP_EOL, $timeOfDayIcon, $timeOfDay),

        new BootstrapCardBody("", "mt-3", [
            sprintf('<span>Sunrise: %s</span><br />' . PHP_EOL, date("g.i a", $_TIME['sunrise'])),
            sprintf('<span>Sunset: %s</span><br />' . PHP_EOL, date("g.i a", $_TIME['sunset'])),
            sprintf('<span>Season: %s</span><br />' . PHP_EOL, $_TIME['season'])
        ])
    ])
);

$layoutFooterMain = new BootstrapCard("", "border",
    false,
    new BootstrapCardBody("", "p-3", var_export($_TIME, true))
);

$layoutFooterGrid = new BootstrapGridRow("", "row g-3", [
    new BootstrapGridRowColumn("", "col-12 col-lg-3 col-md-4", $layoutFooterSidebar),
    new BootstrapGridRowColumn("", "col-12 col-lg-9 col-md-8", $layoutFooterMain)
]);

$layoutFooter = new BootstrapCardFooter("", "bg-dark text-light p-3", $layoutFooterGrid);

$sidebarNavLinks = [];
foreach ($website->navigation->sidebar->links as $link):

    array_push($sidebarNavLinks, new BootstrapNavLink("nav-item nav-link text-dark", hyperlink($link->href), $link->text));

unset($link); endforeach;

$userSidebarNavLinks = [];

$userRole = $fw->user['visitor']->signature;
foreach ($website->navigation->userSidebar->$userRole->links as $link):

    array_push($userSidebarNavLinks, new BootstrapNavLink("nav-item nav-link text-dark", hyperlink($link->href), $link->text));

unset($link); endforeach;

$pageSidebarNavLinks = [];
foreach ($website->navigation->pageSidebar->links as $link):

    array_push($pageSidebarNavLinks, new BootstrapNavLink("nav-item nav-link text-dark", hyperlink($link->href), $link->text));

unset($link); endforeach;

$sidebarNavigation = new BootstrapNavigation("nav flex-column", $sidebarNavLinks);
$userSidebarNavigation = new BootstrapNavigation("nav flex-column", $userSidebarNavLinks);
$pageSidebarNavigation = new BootstrapNavigation("nav flex-column", $pageSidebarNavLinks);

$sidebarCoin = new BootstrapCoin("sidebar", "cube20 portrait mx-auto mb-2", [
    new BootstrapCoinSurface("", "face front",
        new BootstrapCard("", "card rounded-0 border-0",
            new BootstrapCardHeader("", "card-header", "Main Navigation"),
            new BootstrapCardBody("", "card-body p-0", $sidebarNavigation)
        )
    ),
    new BootstrapCoinSurface("", "face left",
        new BootstrapCard("", "card rounded-0 border-0",
            new BootstrapCardHeader("", "card-header", "Page Navigation"),
            new BootstrapCardBody("", "card-body p-0", $pageSidebarNavigation)
        )
    ),
    new BootstrapCoinSurface("", "face right",
        new BootstrapCard("", "card rounded-0 border-0",
            new BootstrapCardHeader("", "card-header", "User Navigation"),
            new BootstrapCardBody("", "card-body p-0", $userSidebarNavigation)
        )
    )
], new BootstrapNavigation("border-bottom pb-3 mb-4",
    new BootstrapCoinSlider("sidebarRotation", "slider", 0, -90, 90))
);

$layoutSidebar = new BootstrapCard("", "border bg-white p-3", false, $sidebarCoin);

$layoutMainSidebar = new BootstrapGridRowColumn("", "col-12 col-lg-3 col-md-4 py-3 bg-light border-end", $layoutSidebar);
$layoutMainContent = new BootstrapGridRowColumn("", "col-12 col-lg-9 col-md-8 py-3", $cms->page->file);

$layoutMain = new BootstrapGrid("", "container-fluid", [
    new BootstrapGridRow("", "row", [$layoutMainSidebar, $layoutMainContent])
]);

$layout = new BootstrapInterface([$layoutHeader, $layoutMain, $layoutFooter]);

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

    <script type="text/javascript" src="/common/packages/reset/structure-rotation.js"></script>
</head>
<body>

<? $interface = $layout->inner; include BOOTSTRAP; ?>

<script type="text/javascript" src="/common/packages/reset/structure-rotation-listener.js"></script>
</body>
</html>