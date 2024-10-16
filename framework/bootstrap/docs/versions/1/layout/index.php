<?php

// $var = $docs->pages; include INDEX;

$docsPageSidebarLinks = [];
foreach ($docs->pages as $page):

    $link = new BootstrapNavLink("nav-item nav-link text-dark", hyperlink($page->crumb), $page->crumbText);
    array_push($docsPageSidebarLinks, $link); unset($link);

unset($page); endforeach;

$docsPageSidebar = new BootstrapCard("", "card rounded-0",
    new BootstrapCardHeader("", "card-header", ""),
    new BootstrapCardBody("", "card-body p-0",
        new BootstrapNavigation("nav flex-column", $docsPageSidebarLinks)
    ),
    false
);

$docsPageContent = new BootstrapGrid("", "", [
    new BootstrapGridRow("", "row g-3", [
        new BootstrapGridRowColumn("", "col-lg-3 col-md-4", $docsPageSidebar),
        new BootstrapGridRowColumn("", "col", $docs->page->folder . "index.php")
    ])
]);

$toggle_coin_surface_id = surface("docs") ? 0 : 180;

$docsPageIndex = new BootstrapInterface([
    new BootstrapCard("top", "card rounded-0 border-0",
        new BootstrapCardHeader("", "card-header", new BootstrapGridRow("", "d-flex justify-content-between", [
            new BootstrapGridRowColumn("", "", "Documentation"),
            new BootstrapGridRowColumn("", "", new BootstrapNavLink("text-dark", hyperlink("home/docs", ["surfaces" => "docs:" . $toggle_coin_surface_id]), new BootstrapIcon("", "bi bi-person", "")))
        ])),
        new BootstrapCardBody("", "card-body", $docsPageContent),
        new BootstrapCardFooter("", "card-footer", "#Top")
    )
]);

$_FORM['docsUserLogin'] = new Form(new FormButton("docs_login_user", "Login"), [
    new FormField("text", "docs_user_id", "User ID", 0),
    new FormField("text", "docs_user_password", "Password", "")
]);

$docsPageManagerUserLogin = new BootstrapForm("", "POST", [
    new BootstrapFormGroup("", "input-group",
        new BootstrapFormGroupLabel("input-group-text rounded-0", "User ID"),
        new BootstrapFormGroupField("form-control rounded-0", $_FORM['docsUserLogin']->field("docs_user_id"))
    ),
    new BootstrapFormGroup("", "input-group mt-1",
        new BootstrapFormGroupLabel("input-group-text rounded-0", "Password"),
        new BootstrapFormGroupField("form-control rounded-0", $_FORM['docsUserLogin']->field("docs_user_password"))
    ) ],

    new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsUserLogin']->button)
);

$_FORM['docsUserRegister'] = new Form(new FormButton("docs_register_user", "Register"), [
    new FormField("text", "docs_user_name", "Username", ""),
    new FormField("text", "docs_user_password", "Password", "")
]);

$docsPageManagerUserRegister = new BootstrapForm("", "POST", [
    new BootstrapFormGroup("", "input-group",
        new BootstrapFormGroupLabel("input-group-text rounded-0", "Username"),
        new BootstrapFormGroupField("form-control rounded-0", $_FORM['docsUserRegister']->field("docs_user_name"))
    ),
    new BootstrapFormGroup("", "input-group mt-1",
        new BootstrapFormGroupLabel("input-group-text rounded-0", "Password"),
        new BootstrapFormGroupField("form-control rounded-0", $_FORM['docsUserRegister']->field("docs_user_password"))
    ) ],

    new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsUserRegister']->button)
);

$docsPageManagerUserRegisterReply = "";
if ($_FORM['docsUserRegister']->respond):

    $docsPageManagerUserRegisterReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");

endif;

$docsPageManagerUserLoginReply = "";
if ($_FORM['docsUserLogin']->respond):

    $docsPageManagerUserLoginReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");

endif;

$docsPageManagerUserRegisterForm = [$docsPageManagerUserRegisterReply, $docsPageManagerUserRegister];
$docsPageManagerUserLoginForm = [$docsPageManagerUserLoginReply, $docsPageManagerUserLogin];

if (!$docs->author):

    $docsPageManagerUser = new BootstrapInterface([
        new BootstrapCard("", "card rounded-0",
            new BootstrapCardHeader("", "card-header", ""),
            new BootstrapCardBody("", "card-body", [
                new BootstrapGridRow("", "row", [
                    new BootstrapGridRowColumn("", "col", new BootstrapCard("", "card rounded-0",
                        new BootstrapCardHeader("", "card-header", "Register"),
                        new BootstrapCardBody("", "card-body", $docsPageManagerUserRegisterForm)
                    )),
                    new BootstrapGridRowColumn("", "col", new BootstrapCard("", "card rounded-0",
                        new BootstrapCardHeader("", "card-header", "Login"),
                        new BootstrapCardBody("", "card-body", $docsPageManagerUserLoginForm)
                    ))
                ])
            ])
        )
    ]);

else:

    $docsPageManagerUserMenu = new BootstrapNavigation("nav flex-column", [
        new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs", ["surfaces" => "docs:180"]), "Cover Page"),
        new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs/authors", ["surfaces" => "docs:180"]), "Authors"),
        new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs/chapters", ["surfaces" => "docs:180"]), "Chapters"),
        new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs/glossary", ["surfaces" => "docs:180"]), "Glossary"),
        new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs/citations", ["surfaces" => "docs:180"]), "Citations"),
        new BootstrapNavLink("nav-item nav-link text-dark", hyperlink("home/docs/references", ["surfaces" => "docs:180"]), "References")
    ]);

    if (crumb_id(3) == "authors"):
    
        $docsPageManagerUserIndex = "Interface pending.";
    
    elseif (crumb_id(3) == "chapters"):
            
        $chapter_id = crumb_value(3);
        list($content_id, $chapter_content) = array_query_both($docs->contents, $chapter_id, "id");
        # var_dump($chapter_content); exit;

        if ($chapter_content):
        
            $chapter_content_cursor = cursor($chapter_content->file);
            if (!$chapter_content_cursor): $chapter_content_cursor = (object) array("contents" => ""); endif;

            $_FORM['docsChapter'] = new Form(new FormButton("edit_chapter", "Save Chapter"), [
                new FormField("textarea", "markdown", "Markdown", "An empty chapter.", $chapter_content_cursor->contents)
            ]);

            list($form_field_id, $form_field) = array_query_both($_FORM['docsChapter']->fields, "markdown", "name");

            // $form_field->value = cursor($chapter_content->file)->contents;
            // $_FORM['docsChapter']->fields[$form_field_id] = $form_field; unset($form_field_id, $form_field);

            $docsManagerChapterFormReply = "";
            if ($_FORM['docsChapter']->respond):
            
                $data = $_FORM['docsChapter']->field("markdown")->value;

                $saved = false;
                if ($chapter_content_cursor->contents != $data):
                
                    $chapter_content_cursor->contents = $data;
                    save($chapter_content_cursor, $data);

                    $saved = true;
                
                endif;

                $currentMarkdown = cursor($chapter_content_cursor->local);
                if ($saved AND $currentMarkdown->contents == $data): $_FORM['docsChapter']->resolved = true; endif;

                if ($_FORM['docsChapter']->resolved):
                
                    $docsManagerChapterFormReply = new BootstrapCard("", "alert alert-success rounded-0",
                        false,
                        "Changes saved successfully."
                    );
                
                else:
                
                    $docsManagerChapterFormReply = new BootstrapCard("", "alert alert-danger rounded-0",
                        false,
                        "No changes made."
                    );
                
                endif;
            
            endif;

            $docsManagerChaptersFormReply = $docsManagerChapterFormReply;
        
            $docsManagerChapterForm = new BootstrapForm("", "POST", [
                new BootstrapFormGroup("", "input-group d-flex",
                    new BootstrapFormGroupLabel("input-group-text rounded-0 w-100", "Markdown"),
                    new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $_FORM['docsChapter']->field("markdown"))
                )
            ], new BootstrapFormButton("btn btn-success rounded-0 w-100", $_FORM['docsChapter']->button));

            $docsManagerChaptersForm = $docsManagerChapterForm;
        
        else:
        
            $_FORM['docsChapters'] = new Form(new FormButton("edit_chapters", "Save Chapters"), [
                new FormField("textarea", "markdown", "Markdown", "No table of contents found.", $docs->chapters)
            ]);
    
            $docsManagerChaptersFormReply = "";
            if ($_FORM['docsChapters']->respond):
            
                $data = $_FORM['docsChapters']->field("markdown")->value;
                if ($docs->chapters != $data):
                
                    $docs->chapters = $data; unset($data);
                    $table_name = $docs->tables['docsChapters'];
                    $_TABLE[$table_name]->rows = $docs->chapters ? $docs->chapters : "";
                    $_TABLE[$table_name]->save();
                    
                    $_FORM['docsChapters']->resolved = true;
                
                endif;
    
                if ($_FORM['docsChapters']->resolved): $docsManagerChaptersFormReply = new BootstrapCard("", "alert alert-success rounded-0", false, "Changes saved successfully.");
                else: $docsManagerChaptersFormReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");
                endif;
            
            endif;

            $docsManagerChaptersForm = new BootstrapForm("", "POST", [
                new BootstrapFormGroup("", "input-group d-flex",
                    new BootstrapFormGroupLabel("input-group-text rounded-0 w-100", "Markdown"),
                    new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $_FORM['docsChapters']->field("markdown"))
                )
            ], new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsChapters']->button));
        
        endif;

        $docsManagerChaptersTableRows = [];
        if (!empty($docs->chapters)):
        
            $chapters = markdown_decode(markdown($docs->chapters));

            foreach ($chapters as $chapter_id => $row):
            
                $chapterContent = array_query($docs->contents, $row->id, "chapter_id");
                # $chapter->id = $chapter_id + 1;
                # $chapter->folder = $docs->dataFolder . "chapters/";
                # $chapter->title = $row;
                # $chapter->file = $chapter->title . ".md";

                if ($chapterContent):
                
                    $chapterContentLink = new BootstrapNavLink("text-dark", hyperlink("home/docs/chapters:" . $chapterContent->id, ["surfaces" => "docs:180"]), $chapterContent->file);
                
                endif;

                $docsManagerChaptersTableRow = new BootstrapTableBodyRow("", "", [
                    new BootstrapTableBodyRowCell("", 0, (string) $row->id),
                    new BootstrapTableBodyRowCell("", 0, $row->title),
                    new BootstrapTableBodyRowCell("", 0, isset($chapterContentLink) ? $chapterContentLink : "No markdown attached.")
                ]); if (isset($chapterContentLink)): unset($chapterContentLink); endif;

                array_push($docsManagerChaptersTableRows, $docsManagerChaptersTableRow);
            
            unset($row); endforeach; unset($chapters, $chapter_file);
        
        endif;

        $docsManagerChaptersTable = new BootstrapTable("", "table table-bordered mt-3 mb-0", [
            new BootstrapTableHead("", [
                new BootstrapTableHeadCell("bg-light", 0, "Chapter"),
                new BootstrapTableHeadCell("bg-light w-50", 0, "Subject"),
                new BootstrapTableHeadCell("bg-light w-50", 0, "Markdown"),
            ]),
            new BootstrapTableBody("", $docsManagerChaptersTableRows)
        ]);

        $docsPageManagerUserIndex = [$docsManagerChaptersFormReply, $docsManagerChaptersForm, $docsManagerChaptersTable];
    
    elseif (crumb_id(3) == "glossary"):
    
        $_FORM['docsGlossary'] = new Form(new FormButton("edit_glossary", "Save Glossary"), [
            new FormField("textarea", "markdown", "Markdown", "No terms defined.", $docs->glossary)
        ]);

        $docsManagerGlossaryFormReply = "";
        if ($_FORM['docsGlossary']->respond):
        
            $data = $_FORM['docsGlossary']->field("markdown")->value;
            if ($docs->glossary != $data):
            
                $docs->glossary = $data; unset($data);
                $table_name = $docs->tables['docsGlossary'];
                $_TABLE[$table_name]->rows = $docs->glossary ? $docs->glossary : "";
                $_TABLE[$table_name]->save();
                
                $_FORM['docsGlossary']->resolved = true;
            
            endif;

            if ($_FORM['docsGlossary']->resolved): $docsManagerGlossaryFormReply = new BootstrapCard("", "alert alert-success rounded-0", false, "Changes saved successfully.");
            else: $docsManagerGlossaryFormReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");
            endif;
        
        endif;

        $docsManagerGlossaryForm = new BootstrapForm("", "POST", [
            new BootstrapFormGroup("", "input-group d-flex",
                new BootstrapFormGroupLabel("input-group-text rounded-0 w-100", "Markdown"),
                new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $_FORM['docsGlossary']->field("markdown"))
            )
        ], new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsGlossary']->button));
        
        $docsPageManagerUserIndex = [$docsManagerGlossaryFormReply, $docsManagerGlossaryForm];
    
    elseif (crumb_id(3) == "citations"):
    
        $_FORM['docsCitations'] = new Form(new FormButton("edit_citations", "Save Citations"), [
            new FormField("textarea", "markdown", "Markdown", "No citations included.", $docs->citations)
        ]);

        $docsManagerCitationsFormReply = "";
        if ($_FORM['docsCitations']->respond):
        
            $data = $_FORM['docsCitations']->field("markdown")->value;
            if ($docs->citations != $data):
            
                $docs->citations = $data; unset($data);
                $table_name = $docs->tables['docsCitations'];
                $_TABLE[$table_name]->rows = $docs->citations ? $docs->citations : "";
                $_TABLE[$table_name]->save();
                
                $_FORM['docsCitations']->resolved = true;
            
            endif;

            if ($_FORM['docsCitations']->resolved): $docsManagerCitationsFormReply = new BootstrapCard("", "alert alert-success rounded-0", false, "Changes saved successfully.");
            else: $docsManagerCitationsFormReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");
            endif;
        
        endif;

        $docsManagerCitationsForm = new BootstrapForm("", "POST", [
            new BootstrapFormGroup("", "input-group d-flex",
                new BootstrapFormGroupLabel("input-group-text rounded-0 w-100", "Markdown"),
                new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $_FORM['docsCitations']->field("markdown"))
            )
        ], new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsCitations']->button));
        
        $docsPageManagerUserIndex = [$docsManagerCitationsFormReply, $docsManagerCitationsForm];
    
    elseif (crumb_id(3) == "references"):
    
        $_FORM['docsReferences'] = new Form(new FormButton("edit_references", "Save References"), [
            new FormField("textarea", "markdown", "Markdown", "No references added.", $docs->references)
        ]);

        $docsManagerReferencesFormReply = "";
        if ($_FORM['docsReferences']->respond):
        
            $data = $_FORM['docsReferences']->field("markdown")->value;
            if ($docs->references != $data):
            
                $docs->references = $data; unset($data);
                $table_name = $docs->tables['docsReferences'];
                $_TABLE[$table_name]->rows = $docs->references ? $docs->references : "";
                $_TABLE[$table_name]->save();
                
                $_FORM['docsReferences']->resolved = true;
            
            endif;

            if ($_FORM['docsReferences']->resolved): $docsManagerReferencesFormReply = new BootstrapCard("", "alert alert-success rounded-0", false, "Changes saved successfully.");
            else: $docsManagerReferencesFormReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");
            endif;
        
        endif;

        $docsManagerReferencesForm = new BootstrapForm("", "POST", [
            new BootstrapFormGroup("", "input-group d-flex",
                new BootstrapFormGroupLabel("input-group-text rounded-0 w-100", "Markdown"),
                new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $_FORM['docsReferences']->field("markdown"))
            )
        ], new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsReferences']->button));
        
        $docsPageManagerUserIndex = [$docsManagerReferencesFormReply, $docsManagerReferencesForm];
    
    else:
    
        $coverData = cursor($docs->subFolder . "pages/cover/index.php");

        $_FORM['docsCoverPage'] = new Form(new FormButton("edit_cover_page", "Save Cover Page"), [
            new FormField("textarea", "php", "PHP", "", $coverData->contents)
        ]);

        $docsPageManagerCoverFormReply = "";
        if ($_FORM['docsCoverPage']->respond):
        
            $data = $_FORM['docsCoverPage']->field("php")->value;

            $saved = false;
            if ($data != $coverData->contents): save($coverData, $data); $saved = true; endif;

            $coverData = cursor($docs->subFolder . "pages/cover/index.php");
            if ($saved AND $data == $coverData->contents): $_FORM['docsCoverPage']->resolved = true; endif;

            $docsPageManagerCoverFormReply = new BootstrapCard("", "alert alert-danger rounded-0", false, "No changes made.");
            if ($_FORM['docsCoverPage']->resolved): $docsPageManagerCoverFormReply = new BootstrapCard("", "alert alert-success rounded-0", false, "Changes saved successfully."); endif;
        
        endif;

        $docsPageManagerCoverForm = new BootstrapForm("", "POST", [
            new BootstrapFormGroup("", "input-group d-flex",
                new BootstrapFormGroupLabel("input-group-text rounded-0 w-100", "PHP Code"),
                new BootstrapFormGroupField("form-control rounded-0 w-100 mt-1", $_FORM['docsCoverPage']->field("php"))
            )
        ], new BootstrapFormButton("btn btn-dark rounded-0 w-100", $_FORM['docsCoverPage']->button));

        $docsPageManagerUserIndex = [$docsPageManagerCoverFormReply, $docsPageManagerCoverForm];

    endif;

    $docsPageManagerUser = new BootstrapInterface([
        new BootstrapGridRow("", "row", [
            new BootstrapGridRowColumn("", "col-lg-3 col-md-4", new BootstrapCard("", "card rounded-0",
                new BootstrapCardHeader("", "card-header", "User Menu"),
                new BootstrapCardBody("", "card-body p-0", $docsPageManagerUserMenu)
            )),

            new BootstrapGridRowColumn("", "col", new BootstrapCard("", "card rounded-0",
                new BootstrapCardHeader("", "card-header", "Documentation Manager"),
                new BootstrapCardBody("", "card-body", $docsPageManagerUserIndex)
            ))
        ])
    ]);

endif;

$docsPageManagerIndex = $docsPageManagerUser;
$docsPageManager = [$docsPageManagerIndex];

$docsPageAdmin = new BootstrapInterface([
    new BootstrapCard("", "card rounded-0 border-0",
        new BootstrapCardHeader("", "card-header", new BootstrapGridRow("", "d-flex justify-content-between", [
            new BootstrapGridRowColumn("", "", "Manager"),
            new BootstrapGridRowColumn("", "", new BootstrapNavLink("text-dark", hyperlink("home/docs", ["surfaces" => "docs:" . $toggle_coin_surface_id]), new BootstrapIcon("", "bi bi-grid", "")))
        ])),

        new BootstrapCardBody("", "card-body", $docsPageManager)
    )
]);

$docsPageCoinFront = new BootstrapCoinSurface("", "face front", $docsPageIndex);
$docsPageCoinBack = new BootstrapCoinSurface("", "face back", $docsPageAdmin);

$docsPageCoin = new BootstrapCoin("docs", "coin", [$docsPageCoinFront, $docsPageCoinBack],
new BootstrapCoinSlider("docsRotation", "slider mb-3", surface("docs"), 0, 180));

$docsPage = new BootstrapInterface($docsPageCoin);
$interface = $docsPage; include BOOTSTRAP;

?>