<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Pop it MVC</title>
   <style>

    body{
        padding: 0;
        margin: 0;
        font-family: sans-serif;
    }

    .header__menu{
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 25px;
    }
    header{
        padding: 15px;
        background-color: #D9D9D9;

    }
    .header__menu > a{
        color: #000;
        font-size: 20px;
        font-weight: medium;
        text-decoration: none;
    }

    .form{
        display: flex;
        flex-direction:column;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    h1,h2,h3 {
        text-align: center;
    }

    .row{
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .form{
        display: flex;
        align-items: center;
        flex-direction:column;
        justify-content: center;
    }
   </style>
</head>
<body>
<header class="header">
   <nav class="header__menu">
       <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
       <?php
       if (!app()->auth::check()):
           ?>
           <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
           <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
       <?php
       else:
           ?>
           <?php if(app()->auth::checkRole()): ?>
                <a href="<?= app()->route->getUrl('/discipline') ?>">создать дисциплину</a>
                <a href="<?= app()->route->getUrl('/group') ?>">создать группу</a>
                <a href="<?= app()->route->getUrl('/student') ?>">создать студента</a>
                <a href="<?= app()->route->getUrl('/performance') ?>">дать оценку</a>
            <?php endif; ?>
            <a href="<?= app()->route->getUrl('/student-list') ?>">Успеваемость</a>
            <a href="<?= app()->route->getUrl('/student-group') ?>">Найти</a>
            <a href="<?= app()->route->getUrl('/discipline-list') ?>">Дисциплина</a>
            <a href="<?= app()->route->getUrl('/poisk') ?>">поиск</a>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
       <?php
       endif;
       ?>
   </nav>
</header>
<main   >
   <?= $content ?? '' ?>
</main>

</body>
</html>
