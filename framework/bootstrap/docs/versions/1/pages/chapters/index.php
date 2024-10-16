<?php

if ($chapter_content):

    $chapters = markdown_decode(markdown($docs->chapters));
    $chapter = array_query($chapters, $chapter_content->chapter_id, "id");
    
    $docsChapterInterface = new BootstrapCard("", "card rounded-0",
        new BootstrapCardHeader("", "card-header", $chapter->id . " - " . $chapter->title),
        new BootstrapInterface(ltrim($chapter_content->file, "/"), "file")
    );

else:

    if (!empty($docs->chapters)):

        $chapters = markdown_decode(markdown($docs->chapters));

        foreach($docs->contents as $chapterContent):
        
            list($content_id, $content) = array_query_both($chapters, $chapterContent->chapter_id, "id");
            $chapters[$content_id]->file = $chapterContent->file;

            $chapters[$content_id]->title = "[" . $content->title . "](" . hyperlink("home/docs/chapters:" . $chapterContent->id) . ")";
        
        unset($chapterContent); endforeach;

        $docsTableOfContentsInner = markdown(markdown_encode($chapters));

    else:

        $docsTableOfContentsInner = markdown("No chapters registered.");

    endif;

    $docsTableOfContents = new BootstrapCard("", "card rounded-0",
        new BootstrapCardHeader("", "card-header", "Table of Contents"),
        new BootstrapCardBody("", "card-body pb-0", $docsTableOfContentsInner),
        false
    );

    $docsChapterInterface = $docsTableOfContents;

endif;

$interface = $docsChapterInterface; include BOOTSTRAP;

?>