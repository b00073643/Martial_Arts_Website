<!doctype html>
<html lang="en">
<head>
    <style>
        @import 'css/style.css';
    </style>
    <title>MGW</title>
</head>

<body>
<nav>
    <ul>
        <li>
            <a href="/">Home page (list all)</a>
        </li>

        <li>
            <a href="/index.php?action=showOne&id=2">detail of Module with ID 2</a>
        </li>

        <li>
            <a href="/index.php?action=doubleIMMCredits">Double IMM module credits</a>
        </li>

        <li>
            <form
                action="index.php"
                method="get"
            >
                <input type="hidden" name="action" value="showNewModuleForm">

                <input type="submit" value="new module form">
            </form>
        </li>
    </ul>
</nav>
<hr>
