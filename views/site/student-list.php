<h2>Успеваемость</h2>
<form method="post" class="form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>дисциплина
        <select name="discipline">
            <option value="">Выбрать дисциплину</option>
            <?php foreach($disciplines as $discipline):?>
                <option value="<?= $discipline->getId() ?>"><?= $discipline->discipline_name ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button>найти</button>
</form>

<div class="row">
    <?php foreach($students as $student): ?>
    <div class="item">
        <img src="<?= $student->image ?>" alt="Photo">
            <p>фамилия <?= $student->last_name ?></p>
            <p>имя <?= $student->first_name ?></p>
            <p>отчество <?= $student->middle_name ?></p>
            <p>пол <?= $student->gender ?></p>
            <p>дата рождение <?= $student->birth_date ?></p>
            <p>адрес <?= $student->address ?></p>
            <p>группа <?= $student->group_id ?></p>
            <?php if (!is_null($student->performance)): ?>
                <?php foreach ($student->performance as $performance): ?>
                    <p>дисциплина <?= $performance->discipline_id ?></p>
                    <p>оценка <?= $performance->avg ?></p>
                    <p>часы <?= $performance->hours ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
    </div>
    <?php endforeach; ?>    
</div>