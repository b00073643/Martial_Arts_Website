<?php
require_once '_header.php';
?>

<form
    action="index.php?action=createNewModule"
    method="post"
>
    <h1>Create New Module</h1>

    <h2>Department</h2>
    <p>
        <input type="text" name="department">
    </p>

    <h2>Module Code</h2>
    <p>
        <input type="text" name="code">
    </p>

    <h2>Module title</h2>
    <p>
        <input type="text" name="title">
    </p>

    <h2>Credits</h2>
    <p>
        <input type="number" name="credits">
    </p>

    <input type="submit" value="Create new module">
</form>


