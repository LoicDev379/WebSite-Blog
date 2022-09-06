<div class="page-header">
  <h1>Le blog</h1>
  <hr>
</div>

<?php foreach ($posts as $key => $v) : ?>
  <h2><?= $v->name ?></h2>
  <p><?= $v->content ?></p>
  <button class="btn btn-primary btn-lire-la-suite">
    <!-- <p> -->
    <a href="<?= Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>">Lire la suite &rarr;</a>
    <!-- </p> -->
  </button>
<?php endforeach; ?>
<?php debug($v); ?>

<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $page; $i++) : ?>
      <li class="page-item <?= $i == $this->request->page ? "active" : ""; ?>"><a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
    <?php endfor; ?>
  </ul>
</nav>