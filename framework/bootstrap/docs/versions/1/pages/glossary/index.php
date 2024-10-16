<?php

if (!empty($docs->glossary)):

    $docsGlossaryInner = markdown($docs->glossary);

else:

    $docsGlossaryInner = markdown("No terms defined.");

endif;

$docsGlossary = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", "Glossary"),
    new BootstrapCardBody("", "card-body pb-0", $docsGlossaryInner),
    false
);

$interface = $docsGlossary; include BOOTSTRAP;

?>