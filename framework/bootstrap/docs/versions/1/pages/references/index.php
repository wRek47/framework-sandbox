<?php

if (!empty($docs->references)):

    $docsReferencesInner = markdown($docs->references);

else:

    $docsReferencesInner = markdown("No references added.");

endif;

$docsReferences = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", "References"),
    new BootstrapCardBody("", "card-body pb-0", $docsReferencesInner)
);

$interface = $docsReferences; include BOOTSTRAP;

?>