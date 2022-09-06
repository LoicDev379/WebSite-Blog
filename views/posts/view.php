<?php $title_for_layout = $post->name ?>

<div class="jumbotron mt-3">
  <h1><?= $post->name ?></h1>
  <p><?= $post->content ?></p>
  <button class="btn btn-primary"><a href="<?= BASE_URL . "posts" ?>">&lArr; Retourner a la page des posts</a></button>
</div>

<!-- <= debug(($post)) ?> -->