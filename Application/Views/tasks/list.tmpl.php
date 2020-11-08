<?php

use Framework\Session;

    // $page - номер текущей страницы
    $maxPage = ceil($tasksCount/PAGE_SIZE); // максимально существующая страница
    $sort = $sortField . '_' . $sortDir;
?>
<table class="table table-sm">
  <thead>
    <tr>
        <th scope="col">
            <a href="?controller=tasks&action=list&sort=username">
                Имя пользователя
                <?php if ($sort == 'username_asc') { ?>
                <img src="img/up-arrow.svg" width="16" height="16"/>
                <?php } if ($sort == 'username_desc') { ?>
                <img src="img/down-arrow.svg" width="16" height="16"/>
                <?php } ?>
            </a>
        </th>
        <th scope="col">
            <a href="?controller=tasks&action=list&sort=email">
                E-mail
                <?php if ($sort == 'email_asc') { ?>
                <img src="img/up-arrow.svg" width="16" height="16"/>
                <?php } if ($sort == 'email_desc') { ?>
                <img src="img/down-arrow.svg" width="16" height="16"/>
                <?php } ?>
            </a>
        </th>
        <th scope="col">
            <a href="?controller=tasks&action=list&sort=task">
                Текст задачи
                <?php if ($sort == 'task_asc') { ?>
                <img src="img/up-arrow.svg" width="16" height="16"/>
                <?php } if ($sort == 'task_desc') { ?>
                <img src="img/down-arrow.svg" width="16" height="16"/>
                <?php } ?>
            </a>
        </th>
        <th scope="col">
        </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tasks as $arTask) { ?>
    <tr class='<?= strlen($arTask['done']) > 0 ? 'done' : '' ?>'>
      <td><?= $arTask['username'] ?></td>
      <td><?= $arTask['email'] ?></td>
      <td><?= $arTask['task'] ?></td>
      <?php if ( Session::issetVariable('user')) { ?>
      <td><a href="?controller=tasks&action=edit&id=<?= $arTask['id'] ?>">
              <img src="img/edit.svg" alt="Редактировать" title="Редактировать" height="24" width="24"/>
          </a>
      </td>
      <?php } ?>
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
        <?php if ( Session::issetVariable('user')) { ?>
        <li class="page-item<?= $page == $maxPage ? ' disabled' : ''?>">
            <a class="page-link" href="?controller=tasks&action=list&page=<?= $page+1 ?>">&gt;</a>
        </li>
        <?php } ?>
    </ul>
</nav>
<?php } ?>

Всего задач: <?= $tasksCount ?>

<p>&nbsp;</p>
<p>
    <a href="?controller=tasks&action=edit" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
        Создать задачу
    </a>
</p>
