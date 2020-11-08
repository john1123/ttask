<?php
    // $page - номер текущей страницы
    $maxPage = ceil($tasksCount/PAGE_SIZE); // максимально существующая страница
?>
<table class="table table-sm">
  <thead>
    <tr>
        <th scope="col"><a href="#">Имя пользователя</a></th>
        <th scope="col"><a href="#">E-mail</a></th>
        <th scope="col"><a href="#">Текст задачи</a></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tasks as $arTask) { ?>
    <tr class='<?= strlen($arTask['done']) > 0 ? 'done' : '' ?>'>
      <td><?= $arTask['username'] ?></td>
      <td><?= $arTask['email'] ?></td>
      <td><?= $arTask['task'] ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php if ($tasksCount > PAGE_SIZE) { ?>
<nav aria-label="pager">
    <ul class="pagination">
        <li class="page-item<?= $page == 1 ? ' disabled' : ''?>">
            <a class="page-link" href="?controller=tasks&action=list&page=<?= $page-1 ?>" tabindex="-1">&lt;</a>
        </li>
<?php for ($i=1; $i<=$maxPage; $i++) { ?>
        <li class="page-item<?= $page == $i ? ' active' : '' ?>">
            <a class="page-link" href="?controller=tasks&action=list&page=<?= $i ?>"><?= $i ?><?= $page == $i ? ' <span class="sr-only">(current)</span>' : '' ?></a>
        </li>
<?php } ?>
        <li class="page-item<?= $page == $maxPage ? ' disabled' : ''?>">
            <a class="page-link" href="?controller=tasks&action=list&page=<?= $page+1 ?>">&gt;</a>
        </li>
    </ul>
</nav>
<?php } ?>

Всего задач: <?= $tasksCount ?>

<p>
    <a href="?controller=tasks&action=edit&id=0" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
        Создать задачу
    </a>
</p>