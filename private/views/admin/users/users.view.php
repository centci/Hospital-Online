<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>


<div class='container-fluids shadow p-4 mx-auto profile'>
  <!-- Search nav bar -->
	<nav class="navbar navbar-light bg-light">
	<!-- button for adding new User -->
  <a href="<?=ROOT?>/Users/register">
  	<button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add New</button>
  </a>
    <form class="form-line">
      <div class="input-group">
        <input class="form-control" type="text" name="find" value="" placeholder="Search">
        <div class="input-group-prepend">
          <button class="input-group-text"><i class="fa fa-search"></i>&nbsp</button>
        </div>
      </div>
    </form>
	</nav>

  <div class="card-group justify-content-center">
    <!-- image cards start -->
    <?php foreach ($rows as $row): ?>
			<?php $image = get_image($row->image, $row->gender); /* displaying image according to gender*/ ?>

    <div class="card  m-1 shadow" style="max-width: 8rem; min-width: 8rem;">
      <a href="<?=ROOT?>/Users/profile/<?=$row->id ?>">
				<img src="<?=$image?>" alt="User Profile" class="d-block mx-auto card-img-top" alt="Profile image">
      <div class="card-body">
        <h6 class="card-title" style="font-size: 10px;"><?=ucfirst($row->firstname." ".$row->lastname)?></h6>
        <h6 class="card-text" style="font-size: 9px; color: #000;"><b>Rank: <?=ucfirst($row->role)?></b> </h6>
      </div>
      </a>
    </div>
    <?php endforeach; ?>
    <!-- image cards end-->
  </div>
</div>

<?php require $this->viewsPath('admin/head_foot/admin-footer'); ?>
