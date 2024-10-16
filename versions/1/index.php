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

$file = "versions/1/layout/index.php"; include INDEX;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $website->title; ?></title>

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