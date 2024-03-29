<h2>Дисциплина</h2>
<form method="post" class="form">
    <label>группа
        <select name="group">
            <option value="">Все группы</option>
            <?php foreach($groups as $group): ?>
                <option value="<?= $group->getId()?>"><?=$group->group_number ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>семестр <input type="number" name="semester"></label>
    <label>курс <input type="number" name="course"></label>
    <button>найти</button>
</form>

<div class="row">
    <?php foreach($items as $item): ?>
    <div class="item">
        <p>дисциплина <?= $item->discipline_id ?></p>
        <p>номер <?= $item->group_number ?></p>
        <p>специальность <?= $item->speciality ?></p>
        <p>курс <?= $item->course ?></p>
        <p>семестер <?= $item->semester ?></p>
    </div>
    <?php endforeach; ?>    
</div>