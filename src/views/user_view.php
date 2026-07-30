<h1><?= $title ?></h1>

<ul>
    <?php foreach ($users as $user): ?>
        <li><?= $user['name'] ?> (<?= $user['umur'] ?>)</li>
    <?php endforeach; ?>
</ul>