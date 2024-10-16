<?php

list($version_id, $version) = array_query_both($cms->versions, crumb_value(1), "id"); 

if (!isset($_SPACES['structures']['versionSlider'])): $_SPACES['structures']['versionSlider'] = 0; endif;

?>
<? if ($version): ?>
<nav class="nav mb-3">
    <a class="text-dark" href="<?= hyperlink("versions"); ?>">Back to Version List</a>
</nav>
<? endif; ?>

<div>
    <nav class="nav">
        <input id="versionSlider" name="versionSlider" type="range" class="slider" min="0" max="180" step="1" value="<?= $_SPACES['structures']['versionSlider']; ?>" />
    </nav>

    <section id="version" class="coin portrait mt-3 mx-3">
<aside class="face front p-3">
<table class="table table-bordered">
    <thead>
        <th class="bg-light">ID</th>
        <th class="bg-light">Title</th>
        <th class="bg-light">Folder</th>
        <th class="bg-light">Created</th>
        <th class="bg-light">Activated</th>
    </thead>

    <tbody>
<? foreach ($cms->versions as $data): ?>
<tr>
    <td><?= $data->id; ?></td>
    <td><a href="<?= hyperlink("versions:" . $data->id, ["surfaces" => "versionSlider:180"]); ?>"><?= $data->title; ?></a></td>
    <td><?= $data->folder; ?></td>
    <td><?= $data->created; ?></td>
    <td><?= $data->selected ? "Active" : "Not Active"; ?></td>
</tr>
<? unset($data); endforeach; ?>
    </tbody>
</table>
</aside>

<aside class="face back p-3">
<?php

if ($version):

    $form = new Form(
        new FormButton("save_version", "Save Changes"), [
            new FormField("textarea", "body", "JSON", "", str_replace("\/", "/", json_encode($version, JSON_PRETTY_PRINT)))
        ]
    );

else:

    $version = end($cms->versions);
    $version->id = count($cms->versions) + 1;
    $version->title = "Untitled Version";
    $version->created = date("c");
    $version->selected = false;
    $version->folder = "version/{folder-name}";

    $form = new Form(
        new FormButton("save_version", "Create Version"), [
            new FormField("textarea", "body", "JSON", "", str_replace("\/", "/", json_encode($version, JSON_PRETTY_PRINT)))
        ]
    ); $version = false;

endif;

$_FORMS['edit_version_json'] = $form; unset($form);

?>
<? $form = $_FORMS['edit_version_json']; if ($form->respond): ?>
<? if ($form->resolved): ?>
<section class="alert alert-success rounded-0 mb-3">
    Changes saved.
</section>
<? else: ?>
<section class="alert alert-danger rounded-0 mb-3">
    No changes made.
</section>
<? endif; ?>
<? endif; unset($form); ?>

<form method="POST"><? $form = $_FORMS['edit_version_json']; ?>
    <div class="input-group flex-column"><? $field = $form->field("body"); ?>
        <span class="input-group-text rounded-0"><?= $field->text; ?></span>
        <textarea class="form-control rounded-0 w-100 mt-1" rows="10" name="<?= $field->name; ?>" placeholder="<?= $field->placeholder; ?>"><?= $field->value; ?></textarea>
    </div><? unset($field); ?>

    <nav class="nav mt-3">
        <button class="btn btn-dark flex-fill rounded-0" type="submit" name="<?= $form->button->name; ?>"><?= $form->button->text; ?></button>
    </nav>
</form><? unset($form); ?>
</aside>
    </section>
</div>

<script>
label = { coin: "version", slider: "versionSlider" };

coinSliders.push(label);
rotateCoin(label.coin, label.slider); delete label;
</script>