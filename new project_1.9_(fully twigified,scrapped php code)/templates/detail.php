<?php
require_once '_header.php';
?>

<h1>Details for record with id = <?= $module->getId() ?> </h1>

<h2>Id</h2>
<p>
    <?= $module->getId() ?>
</p>

<h2>Department</h2>
<p>
    <?= $module->getDepartment() ?>
</p>

<h2>Module Code</h2>
<p>
    <?= $module->getCode() ?>
</p>

<h2>Module title</h2>
<p>
    <?= $module->getTitle() ?>
</p>

<h2>Credits</h2>
<p>
    <?= $module->getCredits() ?>
</p>

