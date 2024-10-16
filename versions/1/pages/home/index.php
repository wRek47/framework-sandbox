<?php

$homeIntro = "Hello World";
$homePageContent = new BootstrapCardBody("", "border p-3", $homeIntro);

$breadcrumb = $_SPACES['surface']['crumb']; include BOOTSTRAP;
$homePageBreadcrumbLinks = $breadcrumbLinks; unset($breadcrumbLinks);

$homePageBreadcrumb = new BootstrapNavigation("nav breadcrumb mb-0", $homePageBreadcrumbLinks);

$homePage = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", $homePageBreadcrumb),
    new BootstrapCardBody("", "card-body", [
            $homePageContent,
    ])
); unset($homeIntro);

set_page(2, $cms->pages, "home");

$file = false;

if (isset($_PAGE['home'])): $file = $_PAGE['home']->file;
else: $file = $_PAGE[$cms->page->crumb]->file;
endif;

?><main>
<? if (isset($_PAGE['home']) AND $_PAGE['home']->file != $cms->page->file): $file = $_PAGE['home']->file; include INDEX; ?>
<? else: if ($file AND $file != $cms->page->file): include INDEX; else: $interface = $homePage; include BOOTSTRAP; endif; endif; ?>
</main>