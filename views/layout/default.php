<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title_for_layout) ? $title_for_layout : "Site" ?></title>
  <link rel="stylesheet" href="<?= BASE_URL . "webroot" . DS . "bootstrap" . DS . "4.0.0" . DS . "css" . DS . "bootstrap.min.css" ?>">
  <link rel="stylesheet" href="<?= BASE_URL . "webroot" . DS . "css" . DS . "style.css?t=" . time() ?>">
  <script defer src="<?= BASE_URL . "webroot" . DS . "bootstrap" . DS . "4.0.0" . DS . "jquery" . DS . "jquery-3.6.0.js" ?>"></script>
</head>

<body>

  <nav style="position:static" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <h3><a class="navbar-brand" href="#" style="color:blue">kljDevCoorporation</a></h3>



      <div class="" id="">
        <ul class="navbar-nav mr-3">
          <?php $pagesMenu = $this->request("Pages", "getMenu"); ?>
          <?php foreach ($pagesMenu as $pm) : ?>
            <li><a href="<?= BASE_URL . "pages/view/" . $pm->id ?>" title="<?= $pm->name ?>"><?= $pm->name ?></a></li> &nbsp;&nbsp;&nbsp;
          <?php endforeach; ?>
          <li><a href="<?= BASE_URL . "posts" ?>" title="<?= "actu" ?>">Actualite</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <?= $content_for_layout ?>
  </div>

</body>

</html>