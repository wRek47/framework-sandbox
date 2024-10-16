<?php

// $_FORMS['create_category'] = $form; unset($form);

$form = new Form(new FormButton("create_document", "Create Document"), [
    // new FormField("text", "title", "Title"),
    new FormField("textarea", "json", "JSON")
]);

$_FORMS['create_document'] = $form; unset($form);

$form = new Form(new FormButton("edit_document", "Save Document"), [
    new FormField("textarea", "json", "JSON")
]);
$_FORMS['edit_document'] = $form; unset($form);

$form = new Form(new FormButton("create_page", "Create Content"), [
    new FormField("text", "title", "Title"),
    new FormField("textarea", "body", "Body")
]);
$_FORMS['create_page'] = $form; unset($form);

$form = new Form(new FormButton("edit_page", "Save Content"), [
    new FormField("text", "title", "Title"),
    new FormField("textarea", "body", "Body")
]);
$_FORMS['edit_page'] = $form; unset($form);

$form = new Form(new FormButton("create_author", "Create Author"), [
    new FormField("text", "name", "Name")
]);
$_FORMS['create_author'] = $form; unset($form);

$form = new Form(new FormButton("edit_author", "Edit Author"), [
    new FormField("text", "name", "Name")
]);
$_FORMS['edit_author'] = $form; unset($form);

$form = new Form(new FormButton("confirm_uploads", "Confirm Upload"), [
    new FormField("upload", "files", "Files")
]);
$_FORMS['upload_items'] = $form; unset($form);

?>