<?php
require_once '_header.php';
?>

<table>
    <tr>
        <th>(details)</th>
        <th>id</th>
        <th>department</th>
        <th>code</th>
        <th>title</th>
        <th>credits</th>
        <th>(delete)</th>
    </tr>


<?php

//---------------------------
foreach ($modules as $module):
    /**
     * @var $module \Itb\Module
     */
//---------------------------
?>
    <tr>
        <td>
            <a href="/index.php?action=showOne&id=<?= $module->getId() ?>">(details)</a>
        </td>
        <td>
            <?= $module->getId() ?>
        </td>
        <td>
            <?= $module->getDepartment() ?>
        </td>
        <td>
            <?= $module->getCode() ?>
        </td>
        <td>
            <?= $module->getTitle() ?>
        </td>
        <td>
            <?= $module->getCredits() ?>
        </td>
        <td>
            <form
                action="index.php"
                method="get"
                >
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $module->getId() ?>">

                <input type="submit" value="DELETE">
            </form>
        </td>
    </tr>


<?php
//---------------------------
endforeach;
//---------------------------
?>

</table>


