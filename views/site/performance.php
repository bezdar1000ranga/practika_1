<h2>Регистрация нового пользователя</h2>
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
    <label>студент
        <select name="student_id">
            <option value="">Выбрать студента</option>    
            <?php foreach($students as $student): ?>
                <option value="<?= $student->getId()?>"><?= $student->first_name ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>оценка<input type="text" name="avg"></label>
    <label>время<input type="text" name="hours"></label>
    <button>Зарегистрироваться</button>
</form>