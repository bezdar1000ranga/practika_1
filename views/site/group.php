<h2>Создать группу</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post" class="form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
   <label>дисциплина
        <select name="discipline_id">
            <option value="">Все дисциплины</option>
            <?php foreach($disciplines as $discipline): ?>
                <option value="<?= $discipline->getId()?>"><?=$discipline->discipline_name ?></option>
            <?php endforeach; ?>
        </select>
    </label>
   <label>номер группы <input type="number" name="group_number"></label>
   <label>специальность<input type="text" name="speciality"></label>
   <label>курс<input type="text" name="course"></label>
   <label>семестр<input type="text" name="semester"></label>
   </label>
   <button>Зарегистрироваться</button>
</form>