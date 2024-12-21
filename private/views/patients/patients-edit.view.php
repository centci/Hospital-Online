
<?php require $this->viewsPath('head_foot/header'); ?>

<div class='col-lg-8 container-fluids rounded shadow p-2 mx-auto mt-3'>
  <div class="container border border-primary rounded p-2 mb-3">
    <center>
      <h1><i class="fa fa-users text-primary"></i></h1>
      <h3>Patients Registration Form</h3>
    </center>
  </div>

  <form method="POST" class="">
    <div class="row">
      <div class="col-sm-2 my-1">
        <div class="input-group">
          <select class="form-select <?= isset($errors['title']) ? 'border-danger' : ''; ?>" name="title">
            <option <?=esc(get_select('title', ''))?> value="<?=esc($row->title)?>"><?=esc(ucfirst($row->title))?></option>
            <option <?=esc(get_select('title', 'mr.'))?> value="mr.">Mr.</option>
            <option <?=esc(get_select('title', 'mrs.'))?> value="mrs.">Mrs.</option>
            <option <?=esc(get_select('title', 'ms.'))?> value="ms.">Ms.</option>
            <option <?=esc(get_select('title', 'miss.'))?> value="miss.">Miss.</option>
            <option <?=esc(get_select('title', 'rev.'))?> value="rev.">Rev.</option>
          </select>
        </div>
        <small class="text-danger">
        <?php if (isset($errors['title'])): ?> <?= $errors['title']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-4 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['firstname']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-user"></i></span>
          <input type="text" class="form-control <?= isset($errors['firstname']) ? 'border-danger' : ''; ?>" name="firstname" value="<?= esc(set_value('firstname',$row->firstname)); ?>" placeholder="First Name">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['firstname'])): ?> <?= $errors['firstname']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-3 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['middlename']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-user"></i></span>
          <input type="text" class="form-control <?= isset($errors['middlename']) ? 'border-danger' : ''; ?>" name="middlename" value="<?= esc(set_value('middlename',$row->middlename)); ?>" placeholder="Middle Name">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['middlename'])): ?> <?= $errors['middlename']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-3 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['lastname']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-user"></i></span>
          <input type="text" class="form-control <?= isset($errors['lastname']) ? 'border-danger' : ''; ?>" name="lastname" value="<?= esc(set_value('lastname',$row->lastname)); ?>" placeholder="Last Name">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['lastname'])): ?> <?= $errors['lastname']?> <?php endif; ?>
        </small>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-4 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['dob']) ? 'border-danger' : ''; ?>" id=""><i class="fas fa-birthday-cake"></i><b>DOB</b></span>
          <input type="date" class="form-control <?= isset($errors['dob']) ? 'border-danger' : ''; ?>" name="dob" value="<?= esc(set_value('dob',$row->dob)); ?>" placeholder="DOB">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['dob'])): ?> <?= $errors['dob']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-4 my-1">
        <div class="input-group">
        <span class="input-group-text <?= isset($errors['gender']) ? 'border-danger' : ''; ?>" id=""><i class="fa-solid fa-mars-double"></i></span>
        <select name="gender" class="form-select <?= isset($errors['gender']) ? 'border-danger' : ''; ?>">
          <option <?=esc(get_select('gender', ''))?> value="<?=esc($row->gender)?>"><?=esc(ucfirst($row->gender))?></option>
          <option <?=esc(get_select('gender', 'male'))?> value="male">Male</option>
          <option <?=esc(get_select('gender', 'female'))?> value="female">Female</option>
        </select>
        </div>
        <small class="text-danger">
        <?php if (isset($errors['gender'])): ?> <?= $errors['gender']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-4 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['phone']) ? 'border-danger' : ''; ?>" id=""><i class="fas fa-phone-volume"></i> </span>
          <input type="text" class="form-control <?= isset($errors['phone']) ? 'border-danger' : ''; ?>" name="phone" value="<?= esc(set_value('phone',$row->phone)); ?>"  placeholder="Phone">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['phone'])): ?> <?= $errors['phone']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-4 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['nok']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-user-friends"></i></span>
          <input type="text" class="form-control <?= isset($errors['nok']) ? 'border-danger' : ''; ?>" name="nok" value="<?= esc(set_value('nok',$row->nok)); ?>" placeholder="Next Of Kin">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['nok'])): ?> <?= $errors['nok']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-4 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['nokphone']) ? 'border-danger' : ''; ?>" id=""><i class="fas fa-phone-volume"></i></span>
          <input type="text" class="form-control <?= isset($errors['nokphone']) ? 'border-danger' : ''; ?>" name="nokphone" value="<?= esc(set_value('nokphone',$row->nokphone)); ?>" placeholder="NOK Phone">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['nokphone'])): ?> <?= $errors['nokphone']?> <?php endif; ?>
        </small>
      </div>
      <!-- ============================== -->
      <div class="col-sm-4 my-1">
        <div class="input-group">
        <span class="input-group-text <?= isset($errors['country']) ? 'border-danger' : ''; ?>" id=""><i class="fas fa-flag"></i></span>
        <select name="country" class="form-select <?= isset($errors['country']) ? 'border-danger' : ''; ?>">
          <option <?=esc(get_select('country', ''))?> value="<?=esc($row->country)?>"><?=esc(ucfirst($row->country))?></option>
          <option <?=esc(get_select('country', 'uganda'))?> value="uganda">Uganda</option>
          <option <?=esc(get_select('country', 'zimbabwe'))?> value="zimbabwe">Zimbabwe</option>
          <option <?=esc(get_select('country', 'rwanda'))?> value="rwanda">Rwanda</option>
          <option <?=esc(get_select('country', 'kenya'))?> value="kenya">Kenya</option>
          <option <?=esc(get_select('country', 'tanzania'))?> value="kenya">Tanzania</option>
        </select>
        </div>
        <small class="text-danger">
        <?php if (isset($errors['country'])): ?> <?= $errors['country']?> <?php endif; ?>
        </small>
      </div>
    </div>
    <!-- ================================== -->

    <div class="row">
      <div class="col-sm-3 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['district']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-earth"></i></span>
          <input type="text" class="form-control <?= isset($errors['district']) ? 'border-danger' : ''; ?>" name="district" value="<?= esc(set_value('district',$row->district)); ?>" placeholder="District">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['district'])): ?> <?= $errors['district']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-3 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['county']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-earth"></i></span>
          <input type="text" class="form-control <?= isset($errors['county']) ? 'border-danger' : ''; ?>" name="county" value="<?= esc(set_value('county',$row->county)); ?>" placeholder="County">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['county'])): ?> <?= $errors['county']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-3 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['subcounty']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-earth"></i></span>
          <input type="text" class="form-control <?= isset($errors['subcounty']) ? 'border-danger' : ''; ?>" name="subcounty" value="<?= esc(set_value('subcounty',$row->subcounty)); ?>" placeholder="Sub-County">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['subcounty'])): ?> <?= $errors['subcounty']?> <?php endif; ?>
        </small>
      </div>

      <div class="col-sm-3 my-1">
        <div class="input-group">
          <span class="input-group-text <?= isset($errors['village']) ? 'border-danger' : ''; ?>" id=""><i class="fa fa-earth"></i></span>
          <input type="text" class="form-control <?= isset($errors['village']) ? 'border-danger' : ''; ?>" name="village" value="<?= esc(set_value('village',$row->village)); ?>" placeholder="Village">
        </div>
        <small class="text-danger">
        <?php if (isset($errors['village'])): ?> <?= $errors['village']?> <?php endif; ?>
        </small>
      </div>
    </div>

    <div class="col-12">
      <button class='btn btn-primary btn-sm float-end mt-3'>Save</button>
      <a href="<?=ROOT?>/patients" class='btn btn-warning btn-sm text-white mt-3'>Cancel</a>
    </div>
  </form>

</div>
<?php require $this->viewsPath('head_foot/footer'); ?>

<!-- birthplace

parish

c_country

c_district

cs_county

c_village -->
