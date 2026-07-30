<?php

/** biar ekstensi tidak error
 * @var string $title
 * @var array $users
 */
?>
<h1><?= htmlspecialchars($title) ?></h1>

<ul>
    <?php foreach ($users as $user): ?>
        <li><?= htmlspecialchars($user['name']) ?> (<?= $user['umur'] ?>)</li>
    <?php endforeach; ?>
</ul>