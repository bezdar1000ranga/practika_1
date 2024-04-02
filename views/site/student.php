<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post" class="form" enctype="multipart/form-data">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Фамилия<input type="text" name="last_name"></label>
    <label>Имя<input type="text" name="first_name"></label>
    <label>Отчество<input type="text" name="middle_name"></label>
    <label>Пол
        <select name="gender">
            <option value="">Выберите пол</option>
            <option value="male">Мужчина</option>
            <option value="female">Женщина</option>
        </select>
    </label>
    <label>Дата рождение<input type="date" name="birth_date"></label>
    <label>Адрес<input type="text" name="address"></label>
    <label>Группа
        <select name="group_id">
            <option value="">Выберите группу</option>
            <?php foreach($groups as $group): ?>
                <option value="<?= $group->getId()?>"><?= $group->group_number ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Изображение <input type="file" name="image"></label>
    <button>Зарегистрироваться</button>
</form>