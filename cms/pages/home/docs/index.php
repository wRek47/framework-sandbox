<? if (!isset($docs)): include "cms/pages/home/docs/bootup.php"; endif; ?>
<?php

$form = $_FORMS['create_document'];

$recentDocumentsFormPassed = new BootstrapCard("", "alert alert-success rounded-0 mb-3", false, "Changes saved.");
$recentDocumentsFormFailed = new BootstrapCard("", "alert alert-danger rounded-0 mb-3", false, "No changes made.");

$recentDocumentsForm = new BootstrapForm("", "POST", [
    new BootstrapFormGroup("", "input-group d-flex flex-column",
        new BootstrapFormGroupLabel("input-group-text rounded-0", "JSON"),
        new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $form->field("json"))
    )
], new BootstrapFormButton("btn btn-dark rounded-0 w-100", $form->button));

$recentDocumentsFormSet = [$recentDocumentsForm];
if ($form->respond):

    # save via $docs->documents

    if ($form->resolved): array_unshift($recentDocumentsFormSet, $recentDocumentsFormPassed);
    else: array_unshift($recentDocumentsFormSet, $recentDocumentsFormFailed);
    endif;

endif; unset($form);

$recentDocumentsFormCard = new BootstrapCard("", "card rounded-0 border-0",
    new BootstrapCardHeader("", "card-header",
        new BootstrapNavLink("text-dark", hyperlink("home/docs", ["surfaces" => "recentDocuments:0"]), "Recent Documents")
    ),

    new BootstrapCardBody("", "card-body", $recentDocumentsFormSet)
);

$recentDocumentsCardEmpty = "No documents added.";
$recentDocumentsCardInner = [];

foreach ($docs->filesys as $i => $item):

    $class = ($i == 0) ? "" : " mt-3";
    $tpl = new BootstrapCard("", "card" . $class,
        false,
        new BootstrapCardBody("", "card-body", $item->files)
    ); unset($class);

    if ($item->type == "folder"): array_push($recentDocumentsCardInner, $tpl); endif;
    unset($tpl);

unset($item); endforeach;

$recentDocumentsCardBody = !empty($docs->filesys) ? $recentDocumentsCardInner : $recentDocumentsCardEmpty;

$recentDocumentsCard = new BootstrapCard("", "card rounded-0 border-0",
    new BootstrapCardHeader("", "card-header",
        new BootstrapNavLink("text-dark", hyperlink("home/docs", ["surfaces" => "recentDocuments:180"]), "Recent Documents")
    ),
    new BootstrapCardBody("", "card-body", $recentDocumentsCardBody)
);

$recentDocumentsCoin = new BootstrapCoin("recentDocuments", "coin portrait no-shadow", [
    new BootstrapCoinSurface("", "face front", $recentDocumentsCard),
    new BootstrapCoinSurface("", "face back", $recentDocumentsFormCard)
], new BootstrapCoinSlider("recentDocumentSlider", "slider mb-3 d-none", surface("recentDocuments")));

$docs->ui = new BootstrapCard("docs", "card rounded-0 mb-3",
    new BootstrapCardHeader("", "card-header", "Documentation"),
    new BootstrapCardBody("", "card-body px-0", $recentDocumentsCoin),
    new BootstrapCardFooter("", "card-footer", "1.0")
);

$interface = $docs->ui; include BOOTSTRAP;

?>