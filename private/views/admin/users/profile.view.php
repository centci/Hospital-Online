<?php require $this->viewsPath('admin/head_foot/admin-header'); ?>

<?php if ($row): ?>
  <div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=ROOT?>/Users/users"><?= get_class($this); ?></a></li>
        <li class="breadcrumb-item active">Profile</li>
        <li class="breadcrumb-item active"><?=esc(ucfirst($row->firstname)." ".ucfirst($row->lastname))?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <?php $image = get_image($row->image, $row->gender); /* displaying image according to gender*/ ?>

            <img src="<?=$image?>"  alt="Profile" class="rounded-circle progile-image">
            <h2><?=esc(ucfirst($row->firstname)." ".ucfirst($row->lastname))?></h2>
            <h3><?=esc(ucfirst($row->roleInfo->role))?></h3>
            <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" id="profile-overview-tab">Overview</button>
              </li>

              <li class="nav-item">
                <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" id="profile-edit-tab">Edit Profile</button>
              </li>

              <li class="nav-item">
                <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" id="profile-settings-tab">Settings</button>
              </li>

              <li class="nav-item">
                <button onclick="set_tab(this.getAttribute('data-bs-target'))" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" id="profile-change-password-tab">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <b>About Me, Read More....</b>
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                      <div class="accordion-body">
                        <?=esc(ucfirst($row->about))?>
                      </div>
                    </div>
                  </div>
                </div>
                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->firstname)." ".ucfirst($row->lastname))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Gender</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->gender))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Company</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->company))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Job</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->roleInfo->role))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->country))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->address))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->phone))?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?=esc(ucfirst($row->email))?></div>
                </div>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form method="POST" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="d-flex">
                        <img class="js-image-preview" src="<?=$image?>" alt="Profile" >
                        <div class="js-filename m-2 mt-5"> Selected File: None </div>
                      </div>

                      <div class="pt-2">
                        <label href="#" class="btn btn-primary btn-sm" title="Upload new profile image">
                          <i class="text-white bi bi-upload"></i>
                          <input class="js-profile-image-input" onchange="load_image(this.files[0])" type="file" name="image" value="" style="display: none;">
                        </label>
                        <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                      </div>

                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="firstname" type="text" class="form-control" id="firstname" value="<?=set_value('firstname', esc($row->firstname))?>" required>
                      <small class="js-error-firstname text-danger">
                      <?php if (isset($errors['firstname'])): ?> <?= $errors['firstname']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="lastname" type="text" class="form-control" id="lastname" value="<?=set_value('lastname', esc($row->lastname))?>" required>
                      <small class="js-error-lastname text-danger">
                      <?php if (isset($errors['lastname'])): ?> <?= $errors['lastname']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="username" type="text" class="form-control" id="username" value="<?=set_value('username', esc($row->username))?>" required>
                      <small class="js-error-username text-danger">
                      <?php if (isset($errors['username'])): ?> <?= $errors['username']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Gender" class="col-md-4 col-lg-3 col-form-label">Gender</label>
                    <div class="col-md-8 col-lg-9">
                      <select class="form-select form-select <?= isset($errors['gender']) ? 'border-danger' : 'border-primary';?>" name="gender" required>
                        <option <?= get_select('gender', '') ?> value="<?=esc($row->gender)?>"><?=esc(ucfirst($row->gender))?></option>
                        <option <?= get_select('gender', 'male') ?> value="male">Male</option>
                        <option <?= get_select('gender', 'female') ?> value="female">Female</option>
                      </select>
                      <small class="js-error-gender text-danger">
                      <?php if (isset($errors['gender'])): ?> <?= $errors['gender']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="company" type="text" class="form-control" id="company" value="<?=set_value('company', esc($row->company))?>" required>
                      <small class="js-error-company text-danger">
                      <?php if (isset($errors['company'])): ?> <?= $errors['company']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                    <div class="col-md-8 col-lg-9">
                      <select class="form-select form-select <?= isset($errors['country']) ? 'border-danger' : 'border-primary';?>" name="country" required>
                        <option <?= get_select('country', '') ?> value="<?=esc($row->country)?>"><?=esc(ucfirst($row->country))?></option>
                        <option <?= get_select('country', 'uganda') ?> value="uganda">Uganda</option>
                        <option <?= get_select('country', 'kenya') ?> value="kenya">Kenya</option>
                      </select>
                      <small class="js-error-country text-danger">
                      <?php if (isset($errors['country'])): ?> <?= $errors['country']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="address" type="text" class="form-control" id="Address" value="<?=set_value('address', esc($row->address))?>" required>
                      <small class="js-error-address text-danger">
                      <?php if (isset($errors['address'])): ?> <?= $errors['address']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="phone" type="text" class="form-control" id="Phone" value="<?=set_value('phone', esc($row->phone))?>" required>
                      <small class="js-error-phone text-danger">
                      <?php if (isset($errors['phone'])): ?> <?= $errors['phone']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="Email" value="<?=set_value('email', esc($row->email))?>" required>
                      <small class="js-error-email text-danger">
                      <?php if (isset($errors['email'])): ?> <?= $errors['email']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="about" class="form-control" id="about" style="height: 100px">
                        <?=set_value('about', $row->about)?>
                      </textarea>
                      <small class="js-error-about text-danger">
                      <?php if (isset($errors['about'])): ?> <?= $errors['about']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="twitterlink" type="text" class="form-control" id="Twitter" value="<?=set_value('twitterlink', esc($row->twitterlink))?>">
                      <small class="js-error-twitterlink text-danger">
                      <?php if (isset($errors['twitterlink'])): ?> <?= $errors['twitterlink']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="facebooklink" type="text" class="form-control" id="Facebook" value="<?=set_value('facebooklink', esc($row->facebooklink))?>">
                      <small class="js-error-facebooklink text-danger">
                      <?php if (isset($errors['facebooklink'])): ?> <?= $errors['facebooklink']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="instagramlink" type="text" class="form-control" id="Instagram" value="<?=set_value('instagramlink', esc($row->instagramlink))?>">
                      <small class="js-error-instagramlink text-danger">
                      <?php if (isset($errors['instagramlink'])): ?> <?= $errors['instagramlink']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="linkedinlink" type="text" class="form-control" id="Linkedin" value="<?=set_value('linkedinlink', esc($row->linkedinlink))?>">
                      <small class="js-error-linkedinlink text-danger">
                      <?php if (isset($errors['linkedinlink'])): ?> <?= $errors['linkedinlink']?> <?php endif; ?>
                      </small>
                    </div>
                  </div>
                  <!-- progress bar for profile saving -->
                  <div class="js-prog progress my-3 hide">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"  aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                  </div> <!-- progress bar for profile saving end -->

                  <div class="">
                    <a href="<?=ROOT?>/admin" class="btn btn-primary">Back</a>
                    <button type="button" onclick="save_profile(event)" type="submit" class="btn btn-danger float-end">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-settings">

                <!-- Settings Form -->
                <form>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="changesMade" checked>
                        <label class="form-check-label" for="changesMade">
                          Changes made to your account
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="newProducts" checked>
                        <label class="form-check-label" for="newProducts">
                          Information on new products and services
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proOffers">
                        <label class="form-check-label" for="proOffers">
                          Marketing and promo offers
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                        <label class="form-check-label" for="securityNotify">
                          Security alerts
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End settings Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form>

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>
<?php else: ?>

  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>
      No profile found!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<script>


  var tab = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab") : "#profile-overview-tab";

  function show_tab(tab_name)
  {
    const someTabTriggerEl = document.querySelector(tab_name + "-tab");
    const tab = new bootstrap.Tab(someTabTriggerEl);
    tab.show();
  }

  function set_tab(tab_name)
  {
    tab = tab_name;
    sessionStorage.setItem("tab", tab_name);
  }
  function load_image(file)
  {
    document.querySelector(".js-filename").innerHTML = "Selected File: " + file.name;
    var imglink = window.URL.createObjectURL(file);
    document.querySelector(".js-image-preview").src = imglink;
  }

  window.onload = function ()
  {
    show_tab(tab);
  }

  // profile saving
  function save_profile(e)
  {
    var form = e.currentTarget.form;
    var inputs = form.querySelectorAll("input,textarea,select");
    var obj = {};
    var image_added = false;

    for (var i = 0; i < inputs.length; i++)
    {
      var key = inputs[i].name;
      if (key == "image")
      {
        if(typeof inputs[i].files[0] == 'object')
        {
          obj[key] = inputs[i].files[0];
          image_added = true;
        }
      }else
      {
        obj[key] = inputs[i].value;
      }
    }
    // VALIDATE IMAGE
    if (image_added)
    {
      var allowed = ['jpeg','jpg','png'];
      if(typeof obj.image == 'object')
      {
        var ext = obj.image.name.split('.').pop();
      }

      if (!allowed.includes(ext.toLowerCase()))
      {
        alert('File Type Invalid, Only (' + allowed.toString(",") + ') Are Allowed For Profile Image');
        return;
      }
    }

    send_data(obj);
  }

  function send_data(obj, progbar = "js-prog")
  {
    var prog = document.querySelector("."+progbar);
    prog.children[0].style.width = "0%";
    prog.classList.remove("hide");

    var myform = new FormData();
    for (key in obj)
    {
      myform.append(key,obj[key]);
    }

    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange', function(){
      if (ajax.readyState == 4)
      {
        if (ajax.status == 200)
        {
          handle_result(ajax.responseText);
          // console.log(ajax.responseText);
        }
        else
        {
          // errors
          alert('an error occoured');
        }
      }
    });
    // check for progress bar status and display
    ajax.upload.addEventListener('progress', function(e)
    {
      var percent = Math.round((e.loaded / e.total) * 100);
      prog.children[0].style.width = percent + "%";
      prog.children[0].innerHTML = "Saving.." + percent + "%";
    });

    ajax.open('post','',true);
    ajax.send(myform);
  }

  function handle_result(result)
  {
    console.log(result);
    var obj = JSON.parse(result);
    if (typeof obj == 'object')
    {
      // object was created

      if (typeof obj.errors == 'object')
      {
        // we have errors
        display_errors(obj.errors);
        alert("Please correct the errors on the page");

      }
      else
      {
        // save Complete
        alert("Profile saved Successfully");

        // refresh/reload the page
        window.location.reload();
      }
    }
  }

  function display_errors(errors)
  {
    for(key in errors)
    {
      // console.log(".js-error-"+key);
      document.querySelector(".js-error-"+key).innerHTML = errors[key];
    }

  }

</script>
<?php require $this->viewsPath('admin/head_foot/admin-footer') ?>
