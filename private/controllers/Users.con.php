<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Users controller
 */
class Users extends Controller
{
  // displaying All Users Function
  public function index()
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }
    $user = new User();
    $rows = $user->findAll();
    // show($rows);die;
    require $this->viewsPath("admin/users/users");
  }

  // Register Users function
  public function register()
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

  	$errors = [];

    $user = new User();
    $role = new Role();
    $specialize = new Specialization();

    $roleRow = $role->findAll();
    $specializeRow = $specialize->findAll();
    if(count($_POST) > 0)
    {
      // show($_POST);die;

      if ($user->validate($_POST))
      {
        $_POST['date'] = date('Y-m-d H:i:s');
        $_POST['userSaveBy'] = Auth::getUserId();
        $user->insert($_POST);
        message('You Have Successfully Registered User.');
      	$this->redirect("Users/users");
      }
      else
      {
      	// errors
      	$errors = $user->errors;
      }
    }
    require $this->viewsPath("admin/users/register");
  }

  public function profile($id = null)
  {
    if (!Auth::logged_in()) {
        $this->redirect('login');
    }
    $errors = [];
    $user = new User();
    $title = "Profile";
    $id = $id ?? Auth::getUserId();
    $row = $user->first('id', $id);

    // Handle form submission
    if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$folder = "uploads/images/";
			if(!file_exists($folder))
			{
				mkdir($folder,0777,true);
				file_put_contents($folder."index.php", "<?php //silence");
				file_put_contents("uploads/index.php", "<?php //silence");
			}

 			if($user->edit_validate($_POST,$id))
 			{

				$allowed = ['image/jpeg','image/png'];

				if(!empty($_FILES['image']['name'])){

					if($_FILES['image']['error'] == 0){

						if(in_array($_FILES['image']['type'], $allowed))
						{
							//everything good
							$destination = $folder.time().$_FILES['image']['name'];
							move_uploaded_file($_FILES['image']['tmp_name'], $destination);

							resize_image($destination);
							$_POST['image'] = $destination;
							if(file_exists($row->image))
							{
								unlink($row->image);
							}

						}else{
							$user->errors['image'] = "This file type is not allowed";
						}
					}else{
						$user->errors['image'] = "Could not upload image";
					}
				}
// show($user->errors);die;
				$user->update($id,$_POST);

				//message("Profile saved successfully");
				//redirect('admin/profile/'.$id);
 			}

			if(empty($user->errors)){
				$arr['message'] = "Profile saved successfully";
			}else{
				$arr['message'] = "Please correct these errors";
				$arr['errors'] = $user->errors;
			}

			echo json_encode($arr);

 			die;
		}

    // Load the profile view
    require $this->viewsPath("admin/users/profile");
  }

  // Users Logout Functions
  public function logout()
  {
    Auth::logout();
    $this->redirect('login');
  }
}
