
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?=ROOT?>/home">
      <?=esc(APP_NAME);?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- register patient -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-users"></i>Patients
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?=ROOT?>/patients/add"><i class="fa fa-plus"></i>New</a></li>
              <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/patients"><i class="fa fa-list"></i>List</a></li>
          </ul>
        </li>
        <!--create visit -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-people-fill"></i>Visit
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?=ROOT?>/visits/search"><i class="fa fa-plus"></i>New</a></li>
              <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/visits"><i class="fa fa-list"></i>Consultation List</a></li>
            <li><a class="dropdown-item" href="<?=ROOT?>/visits/selfrequest"><i class="fa fa-list"></i>Self Request List</a></li>
          </ul>
        </li>

        <!-- Laboratory service -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-flask"></i>Laboratory
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?=ROOT?>/laboratorys/laboratory?Request_New=New"><i class="fa fa-plus"></i>Requests</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/laboratorys/Laboratorysavedrequest"><i class="fa fa-plus"></i>Saved</a></li>
              <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/laboratorys/laboratoryreports"><i class="fa fa-edit"></i>Reports</a></li>
          </ul>
        </li>
        <!-- Financial service -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-credit-card-alt" aria-hidden="true"></i>Finance
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?=ROOT?>/PendingPayments"><i class="fa fa-plus"></i>Pending Payment</a></li>
              <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/PendingPayments/todaySales"><i class="fa fa-edit"></i>Todays Sales</a></li>
          </ul>
        </li>

      </ul>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Hi <b><?=ucfirst(Auth::getFirstname());?></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?=ROOT?>/admin"><i class="bi bi-grid-fill"></i>Dashboard</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/Users/profile"><i class="fa fa-user"></i>Profile</a></li>
              <div class="dropdown-divider"></div>
            <li><a class="dropdown-item"href="<?=ROOT?>/edit-user&id="><i class="fa fa-screwdriver-wrench"></i>Settings</a></li>
              <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="<?=ROOT?>/Users/logout"><i class="fa fa-right-from-bracket"></i>Logout</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>
