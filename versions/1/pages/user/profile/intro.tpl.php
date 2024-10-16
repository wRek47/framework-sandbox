<section>
    <p>
        User ID: <?= $fw->user['visitor']->code; ?><br />
        Hits: <?= number_format($fw->user['visitor']->hits); ?><br />
        Created: <?= date("G.i [A] - l, F jS, Y", $fw->user['visitor']->created); ?><br />
    </p>

    <p>
        Secret Name: <?= decode_token($fw->user['token']->secret_name); ?><br />
        Secret Code: <var><?= str_repeat("*", 8); ?></var><br />
    </p>

    <p class="mb-0">
        Name: <?= $fw->user['profile']->name; ?><br />
        Birth: <?= $fw->user['profile']->birth; ?><br />
        Email: <?= $fw->user['profile']->email; ?><br />
        Phone: <?= $fw->user['profile']->phone; ?><br />
    </p>
</section>