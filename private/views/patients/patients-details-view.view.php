
<?php require $this->viewsPath('head_foot/header'); ?>
<div class="container-fluids shadow p-4 mt-2 mx-auto profile">
  <div class="row">
    <div class="col-sm-4 col-md-3">
      <?php $image = get_image($row->image, $row->gender); /* displaying image according to gender*/ ?>

      <img src="<?= $image ?>" alt="User Profile" class="d-block mx-auto rounded-circle border border-info" style="max-width: 160px;">
      <h3 class="text-center"><?=esc(ucfirst($row->firstname ." ". $row->lastname)) ?></h3>

      <div class="text-center">
        <a href="<?=ROOT?>/patients/edit/<?=$row->id?>">
        <button class="btn btn-sm btn-info" type="submit" name="button">Edit <i class="fa fa-edit"></i></button>
        </a>
        <a href="#">
        <button class="btn btn-sm btn-warning" type="submit" name="button">Delete <i class="fa fa-trash-alt"></i></button>
        </a>
        <a href="<?=ROOT?>/patients">
        <button class="btn btn-sm btn-secondary" type="submit" name="button">Back <i class="fa fa-chevron-right"></i></button>
        </a>
      </div>
    </div>

    <div class="col-sm-8 col-md-9 bg-light">
      <table class="table table-striped table-hover">
        <tbody>
          <tr>
            <th>First Name:</th>
            <td><?=esc(ucfirst($row->firstname ." ". $row->middlename)) ?></td>
          </tr>
          <tr>
            <th>Last Name:</th>
            <td><?=esc(ucfirst($row->lastname)) ?></td>
          </tr>
          <tr>
            <th>Gender:</th>
            <td><?=esc(ucfirst($row->gender)) ?></td>
          </tr>
          <tr>
            <th>Age:</th>
            <td><?=esc(ucfirst($row->Age)) ?></td>
          </tr>
          <tr>
            <th>Phone:</th>
            <td><?=esc(ucfirst($row->phone)) ?> </td>
          </tr>
          <tr>
            <th>Date Joined:</th>
            <td><?=esc(get_date($row->date)) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <hr>

  <div class="container-fluids">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active accordion-button collapsed p-2" href="#" data-bs-toggle="collapse" data-bs-target="#patient-basic-info">Basic Info</a>
      </li>
    </ul>
    <div class="row">
      <div class="col-lg">
        <div class="card">
          <div class="card-body">
            <!-- Accordion without outline borders -->
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <div id="patient-basic-info" class="accordion-collapse collapse">
                  <div class="">
                    <table class="table">
                      <tbody>
                        <tr>
                          <th>Patient No:</th>
                          <td class="text-end"><?=esc(ucfirst($row->patientId)) ?></td>
                        </tr>
                        <tr>
                          <th>Next Of Kin:</th>
                          <td class="text-end"><?=esc(ucfirst($row->lastname)) ?></td>
                        </tr>
                        <tr>
                          <th>Nok phone:</th>
                          <td class="text-end"><?=esc(ucfirst($row->nokphone)) ?></td>
                        </tr>
                        <tr>
                          <th>Country:</th>
                          <td class="text-end"><?=esc(ucfirst($row->country)) ?></td>
                        </tr>
                        <tr>
                          <th>District:</th>
                          <td class="text-end"><?=esc(ucfirst($row->phone)) ?> </td>
                        </tr>
                        <tr>
                          <th>County:</th>
                          <td class="text-end"><?=esc(ucfirst($row->county)) ?> </td>
                        </tr>
                        <tr>
                          <th>Sub County:</th>
                          <td class="text-end"><?=esc(ucfirst($row->subcounty)) ?> </td>
                        </tr>
                        <tr>
                          <th>Village:</th>
                          <td class="text-end"><?=esc(ucfirst($row->village)) ?> </td>
                        </tr>
                        <tr>
                          <th>Registered By</th>
                          <td class="text-end"><?=esc(ucfirst($row->userRow->name)) ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div><!-- End Accordion without outline borders -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require $this->viewsPath('head_foot/footer'); ?>
