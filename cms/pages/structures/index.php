<?php

list($structure_id, $structure) = array_query_both($cms->pages, crumb_value(1), "id");

?><section class="card rounded-0">
    <header class="card-header d-none"></header>

    <aside class="card-body pb-0">
<? if ($structure): $var = $structure; include INDEX; ?>
<section class="row row-cols-3 mb-3">
    <nav class="col">
        <aside class="card rounded-0">
            <figure class="card-body mb-0">
                <figcaption>Card</figcaption>
            </figure>

            <footer class="card-footer rounded-0 p-0">
                <a class="btn btn-light rounded-0 w-100" href="<?= hyperlink(); ?>">Use Structure</a>
            </footer>
        </aside>
    </nav>

    <nav class="col">
        <aside class="card rounded-0">
            <figure class="card-body mb-0">
                <figcaption>Coin</figcaption>
            </figure>

            <footer class="card-footer rounded-0 p-0">
                <a class="btn btn-light rounded-0 w-100" href="<?= hyperlink(); ?>">Use Structure</a>
            </footer>
        </aside>
    </nav>

    <nav class="col">
        <aside class="card rounded-0">
            <figure class="card-body mb-0">
                <figcaption>Cube</figcaption>
            </figure>

            <footer class="card-footer rounded-0 p-0">
                <a class="btn btn-light rounded-0 w-100" href="<?= hyperlink(); ?>">Use Structure</a>
            </footer>
        </aside>
    </nav>
</section>
<? else: ?>
<table class="table table-bordered">
    <thead>
        <th class="bg-light">ID</th>
        <th class="bg-light">Title</th>
        <th class="bg-light">Crumb</th>
        <th class="bg-light">File</th>
        <th class="bg-light">In</th>
        <th class="bg-light">Out</th>
    </thead>

    <tbody>
<? foreach ($cms->pages as $data): ?>
        <tr>
            <td><?= $data->id; ?></td>
            <td><?= $data->title; ?></td>
            <td><?= $data->crumb; ?></td>
            <td><a href="<?= hyperlink("structures:" . $data->id, ["filesystem" => $data->file]); ?>"><?= $data->file; ?></a></td>
            <td class="text-center"><a href="<?= hyperlink("structures:" . $data->id); ?>"><i class="bi bi-arrow-up"></i></a></td>
            <td class="text-center"><a href="<?= hyperlink("structures:" . $data->id, ["surfaces" => "pagesSlider:180"]); ?>"><i class="bi bi-arrow-right"></i></a></td>
        </tr>
<? unset($data); endforeach; ?>
    </tbody>
</table>
<? endif; ?>
    </aside>
</section>