<h2>Создать дисциплину</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post" class="form">
   <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
   <label>Имя <input type="text" name="discipline_name"></label>
   <button>Зарегистрироваться</button>
</form>