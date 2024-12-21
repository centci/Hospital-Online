<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc(APP_NAME) ?></title>


    <link href="<?=ROOT?>/assets/adminAssets/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?=ROOT?>/assets/adminAssets/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?=ROOT?>/assets/adminAssets/assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="<?=ROOT?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/custom.css">
    <!-- <link rel="stylesheet" href="<?=ROOT?>/assets/css/custom.css"> -->
  </head>
  <body id="body">
    <?php
      $controller = get_class($this);
      $controller = strtolower($controller);
      $no_nav = ['login'];
    ?>
    <?php if (!in_array($controller, $no_nav)): ?>
      <?php require $this->viewsPath('head_foot/nav'); ?>
    <?php endif; ?>
    <div class="container-fluid" style="min-width: 330px;">

      <?php if (message()): ?><!-- Success message. -->
        <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          <?=message('', true) ?>!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?><!-- Success message end. -->

      <?php if (warrningMessage()): ?><!-- Success message. -->
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
          <i class="bi bi-check-circle me-1"></i>
          <?=warrningMessage('', true) ?>!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?><!-- Success message end. -->
