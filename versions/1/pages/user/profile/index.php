<?php

$cardInner = new BootstrapInterface("versions/1/pages/user/profile/intro.tpl.php", "file");

$card = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", "Your Profile"),
    new BootstrapCardBody("", "card-body", $cardInner)
);

include BOOTSTRAP;

?>