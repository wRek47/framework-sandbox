<?php

$homeIntro = "Hello World";

$homePageIntro = new BootstrapGridRow("", "d-flex overflow-x justify-content-between", [
    new BootstrapGridRowColumn("", "flex-fill me-3", [
        new BootstrapCard("", "card rounded-0",
            new BootstrapCardHeader("", "card-header", $cms->page->title),
            new BootstrapCardBody("", "card-body", $homeIntro)
        )
    ]),
    new BootstrapGridRowColumn("", "flex-fill me-3", [
        new BootstrapCard("", "card rounded-0",
            new BootstrapCardHeader("", "card-header", $cms->page->title),
            new BootstrapCardBody("", "card-body", $homeIntro)
        )
    ]),
    new BootstrapGridRowColumn("", "flex-fill", [
        new BootstrapCard("", "card rounded-0",
            new BootstrapCardHeader("", "card-header", $cms->page->title),
            new BootstrapCardBody("", "card-body", $homeIntro)
        )
    ])
]);

$homePageFeatured = new BootstrapGridRow("", "row row-cols-2 g-3 pt-3", [
    new BootstrapGridRowColumn("", "col",
        new BootstrapCardBody("", "border p-3",
            new BootstrapGridRow("", "d-flex overflow-x pb-3", [
                new BootstrapGridRowColumn("", "me-3", [
                    new BootstrapCard("", "w-300 card rounded-0",
                        new BootstrapCardHeader("", "card-header", $cms->page->title),
                        new BootstrapCardBody("", "card-body", $homeIntro)
                    )
                ]),
                new BootstrapGridRowColumn("", "me-3", [
                    new BootstrapCard("", "w-300 card rounded-0",
                        new BootstrapCardHeader("", "card-header", $cms->page->title),
                        new BootstrapCardBody("", "card-body", $homeIntro)
                    )
                ]),
                new BootstrapGridRowColumn("", "me-3", [
                    new BootstrapCard("", "w-300 card rounded-0",
                        new BootstrapCardHeader("", "card-header", $cms->page->title),
                        new BootstrapCardBody("", "card-body", $homeIntro)
                    )
                ]),

                new BootstrapGridRowColumn("", "me-3", [
                    new BootstrapCard("", "w-300 card rounded-0",
                        new BootstrapCardHeader("", "card-header", $cms->page->title),
                        new BootstrapCardBody("", "card-body", $homeIntro)
                    )
                ]),
                new BootstrapGridRowColumn("", "me-3", [
                    new BootstrapCard("", "w-300 card rounded-0",
                        new BootstrapCardHeader("", "card-header", $cms->page->title),
                        new BootstrapCardBody("", "card-body", $homeIntro)
                    )
                ]),
                new BootstrapGridRowColumn("", "", [
                    new BootstrapCard("", "w-300 card rounded-0",
                        new BootstrapCardHeader("", "card-header", $cms->page->title),
                        new BootstrapCardBody("", "card-body", $homeIntro)
                    )
                ])
            ])
        )
    ),
    new BootstrapGridRowColumn("", "col",
        new BootstrapCard("", "card rounded-0",
            new BootstrapCardHeader("", "card-header", $cms->page->title),
            new BootstrapCardBody("", "card-body", $homeIntro)
        )
    )
]);

$breadcrumb = $_SPACES['surface']['crumb']; include BOOTSTRAP;
$homePageBreadcrumbLinks = $breadcrumbLinks; unset($breadcrumbLinks);

$homePageBreadcrumb = new BootstrapNavigation("nav breadcrumb mb-0", $homePageBreadcrumbLinks);

$homePage = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", $homePageBreadcrumb),
    new BootstrapCardBody("", "card-body",
        new BootstrapGrid("", "", [
            $homePageIntro,
            $homePageFeatured,
            
            new BootstrapCard("", "card rounded-0 mt-3",
                new BootstrapCardHeader("", "card-header", $cms->page->title),
                new BootstrapCardBody("", "card-body", $homeIntro)
            )
        ])
    )
); unset($homeIntro);

set_page(2, $cms->pages, "home");

$file = false;

if (isset($_PAGE['home'])): $file = $_PAGE['home']->file;
else: $file = $_PAGE[$cms->page->crumb]->file; # var_dump($file); exit;
endif;

?><main>
<? if (isset($_PAGE['home']) AND $_PAGE['home']->file != $cms->page->file): $file = $_PAGE['home']->file; include INDEX; ?>
<? else: if ($file AND $file != $cms->page->file): include INDEX; else: $interface = $homePage; include BOOTSTRAP; endif; endif; ?>
</main>