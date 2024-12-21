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
    $user = New User();
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

    if(count($_POST) > 0)
    {
      $user = New User();
      if ($user->validate($_POST))
      {
        $_POST['date'] = date('Y-m-d H:i:s');
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
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }
    $user = New User();

    // reading user profile
    $title = "Profile";
    $id = $id ?? Auth::getId();
    $row = $user->first('id',$id);

    // Updating user profile
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $row)
    {

      $folder = 'uploads/images/';
      if (!file_exists($folder))
      {
        mkdir($folder,0777,true);
        file_put_contents($folder."index.php", "<?php //silence");
        file_put_contents("uploads/index.php", "<?php //silence");
      }
      if ($user->edit_validate($_POST,$id))
      {
        $allowedfiles = ['image/jpeg','image/png'];

        if(!empty($_FILES['image']['name']))
        {
          if($_FILES['image']['error'] == 0)
          {
            if (in_array($_FILES['image']['type'], $allowedfiles))
            {
              $destination = $folder.time().$_FILES['image']['name'];
              move_uploaded_file($_FILES['image']['tmp_name'], $destination);

              // crop the image here now
              resize_image($destination);

              $_POST['image'] = $destination;
              if (file_exists($row->image))
              {
                unlink($row->image);
              }
            }
            else
            {
              $this->errors['image'] = "This File Type Is Not Allowed";
            }
          }
          else
          {
            $this->errors['image'] = "Error, Couldnt Upload Image";
          }
        }

        $user->update($id,$_POST);
        // message("Profile Updated Successfully");
        // $this->redirect('Users/profile/'.$id);

      }
      //handle results for json
      if (empty($user->errors))
      {
        $arr['message'] = "Profile Updated Successfully";
      }
      else
      {
        $arr['message'] = "Please correct these errors";
        $arr['errors'] = $user->errors;
      }
      echo json_encode($arr);
      //handle results for json end here

      // else
      // {
      // 	// errors
      // 	$errors = $user->errors;
      // }
      die();
    }

    require $this->viewsPath("admin/users/profile");
  }

  // Users Logout Functions
  public function logout()
  {
    Auth::logout();
    $this->redirect('login');
  }
}
