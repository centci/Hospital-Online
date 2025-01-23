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

    $user = new User();
    $title = "Profile";
    $id = $id ?? Auth::getUserId();
    $row = $user->first('id', $id);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $row) {
        $folder = 'uploads/images/';
// show($_POST);die;
        // Create directory if it doesn't exist
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
            file_put_contents($folder . "index.php", "<?php //silence");
            file_put_contents("uploads/index.php", "<?php //silence");
        }

        // Validate user input
        if ($user->edit_validate($_POST, $id)) {
            $allowedFiles = ['image/jpeg', 'image/png'];

            // Check if an image file was uploaded
            if (!empty($_FILES['image']['name'])) {
                if ($_FILES['image']['error'] == 0) {
                    // Validate file type
                    if (in_array($_FILES['image']['type'], $allowedFiles)) {
                        $destination = $folder . time() . "_" . basename($_FILES['image']['name']);
                        // Move the uploaded file
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            // Resize the image now
                            if (resize_image($destination) === false) {
                                // Handle error in resizing
                                $this->errors['image'] = "Error resizing the image.";
                            } else {
                                $_POST['image'] = $destination;

                                // Remove old image if it exists
                                if (file_exists($row->image)) {
                                    unlink($row->image);
                                }
                            }
                        } else {
                            $this->errors['image'] = "Failed to move the uploaded file.";
                        }
                    } else {
                        $this->errors['image'] = "This File Type Is Not Allowed";
                    }
                } else {
                    $this->errors['image'] = "Error, Couldn't Upload Image";
                }
            }
            show($_POST);die;

            // Update the user profile
            $user->update($id, $_POST);

            // Prepare JSON response
            $arr = [];
            if (empty($user->errors)) {
                $arr['message'] = "Profile Updated Successfully";
            } else {
                $arr['message'] = "Please correct these errors";
                $arr['errors'] = $user->errors;
            }
            // show($arr);die;

            echo json_encode($arr);
        }
        die();
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
