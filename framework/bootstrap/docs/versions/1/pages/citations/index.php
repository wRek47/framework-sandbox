<?php

if (!empty($docs->citations)):

    $docsCitationsInner = markdown($docs->citations);

else:

    $docsCitationsInner = markdown("No citations included.");

endif;

$docsCitations = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", "Citations"),
    new BootstrapCardBody("", "card-body pb-0", $docsCitationsInner)
);

$interface = $docsCitations; include BOOTSTRAP;

?>