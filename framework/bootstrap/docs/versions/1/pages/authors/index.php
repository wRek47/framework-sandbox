<?php

if (count($docs->authors)):

    $docsAuthorsTableRows = [];

    foreach ($docs->authors as $author):
    
        $docsAuthorsTableRow = new BootstrapTableBodyRow("", "", [
            new BootstrapTableBodyRowCell("", 0,
                new BootstrapNavLink("text-dark", hyperlink("home/docs/authors:" . $author->id), $author->name)),
            new BootstrapTableBodyRowCell("", 0, ucfirst($author->role)),
            new BootstrapTableBodyRowCell("", 0, format_date("m/d/Y", $author->created))
        ]);

        array_push($docsAuthorsTableRows, $docsAuthorsTableRow); unset($docsAuthorsTableRow);
    
    unset($author); endforeach;

    $docsAuthorsInner = new BootstrapTable("", "table table-bordered mb-0",
        new BootstrapTableHead("", [
            new BootstrapTableHeadCell("bg-light", 0, "Name"),
            new BootstrapTableHeadCell("bg-light", 0, "Role"),
            new BootstrapTableHeadCell("bg-light", 0, "Created")
        ]),

        new BootstrapTableBody("", $docsAuthorsTableRows)
    );

else:

    $docsAuthorsInner = "No authors registered.";

endif;

if (count($docs->contributors)): $docsContributorsInner = "Interface pending.";
else:

    $docsContributorsInner = "No contributions made.";

endif;

$docsContributors = new BootstrapCard("", "card rounded-0 mt-3",
    new BootstrapCardHeader("", "card-header", "Contributors"),
    new BootstrapCardBody("", "card-body", $docsContributorsInner)
);

$docsContributions = new BootstrapContainer("", "mt-3", [
    new BootstrapCardHeader("", "fs-5", markdown("Contribute to our docs using [GitHub](#)."))
]);

$docsAuthors = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", "Authors"),
    new BootstrapCardBody("", "card-body", new BootstrapInterface([$docsAuthorsInner, $docsContributions, $docsContributors]))
);

$interface = $docsAuthors; include BOOTSTRAP;

?>