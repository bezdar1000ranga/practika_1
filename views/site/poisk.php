<h2>Успеваемость</h2>
<form method="post" class="form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>имя студента <input type="text" name="student_name"></label>
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
    </div>
    <?php endforeach; ?>    
</div>