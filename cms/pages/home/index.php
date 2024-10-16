<? if (crumb_id(2) == "docs"):

    $_INNER['docs'] = array_query($cms->_pages, "home/docs", "crumb");
    $file = $_INNER['docs']->file; include INDEX;

else: ?>
<? if (!$_SPACES['is_logged_in']): ?>
<? else: ?>
<section class="container-fluid">
    <nav class="nav justify-content-around">
        <input type="range" class="slider" id="sidebarSlider" name="sidebar" min="0" max="180" step="1" value="0" />
    </nav>

    <aside id="sidebar" class="coin mt-3">
        <section class="face front">
<section class="card rounded-0">
    <aside class="card-body">
        <span class="fs-3">Welcome back, <?= $cms->user->name; ?></span><br />

        <p class="mb-3">
            Status: <?= $cms->configured ? "Running" : "Not Started"; ?><br />
        </p>

        <p class="mb-3">
            <span class="fs-5">Traffic</span><br />
            Visits: <?= number_format(count($fw->visits)); ?><br />
            Visitors: <?= number_format(count($fw->visitors)); ?>
        </p>

        <p class="mb-0">
            Versions: <?= count($cms->versions); ?><br />
            Users: <?= count($cms->users); ?><br />
        </p>
    </aside>
</section>
        </section>

        <section class="face back">
<section class="card rounded-0">
    <aside class="card-body">
<? // $var = $cms; include INDEX; ?>
    </aside>
</section>
        </section>
    </aside>

<script>
label = { coin: "sidebar", slider: "sidebarSlider" };

coinSliders.push(label);
rotateCoin(label.coin, label.slider); delete label;
</script>
</section>
<? endif; ?>
<? endif; ?>