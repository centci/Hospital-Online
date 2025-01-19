<?php
/**
 * User Class Model
 */
class User extends Model
{
  protected $table = 'users'; // Explicitly set the table name

  protected $allowedColumns = [
    'userId',
    'firstname',
    'lastname',
    'username',
    'gender',
    'email',
    'role',
    'specialize',
    'image',
    'about',
    'company',
    'country',
    'address',
    'phone',
    'twitterlink',
    'facebooklink',
    'instagramlink',
    'linkedinlink',
    'date',
    'password'
  ];

  //protected function to hash password, make User Id
  protected $beforeInsert = ['password_hash', 'makeUserId'];

  protected $afterSelect = [
    'getRoleById',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate First Name
    if (empty($DATA['firstname'])) {
      $this->errors['firstname'] = "First Name Is Required!";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['firstname'])) {

      $this->errors['firstname'] = "Only Letters Allowed, No Space!";
    }

    // Validate Last Name
    if (empty($DATA['lastname'])) {
      $this->errors['lastname'] = "Last Name Is Required!";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['lastname'])) {

      $this->errors['lastname'] = "Only Letters Allowed, No Space!";
    }
    // Validate User Name
    if (empty($DATA['username'])) {
      $this->errors['username'] = "Username Is Required!";
    }elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $DATA['username'])) {
      $this->errors['username'] = "Username must be 3-20 characters, containing only letters, numbers, and underscores.";
    }elseif ($this->where('username',$DATA['username']))
    {
      $this->errors['username'] = "User Name Already Taken!";
    }
    // validate gender
    if (empty($DATA['gender'])) {
      $this->errors['gender'] = "Gender Is Required!";
    }
    // validate Role
    if (empty($DATA['role'])) {
      $this->errors['role'] = "Role Is Required!";
    }
    // validate Country
    if (empty($DATA['country'])) {
      $this->errors['country'] = "Country Is Required!";
    }
    // Validate Phone Number
    if (empty($DATA['phone'])) {
      $this->errors['phone'] = "Phone Numbers Is Required!";
    }elseif (!preg_match('/^[0-9]+$/', $DATA['phone'])) {

      $this->errors['phone'] = "Only Numbers Allowed, No Space!";
    }
    // Validate email
    if (empty($DATA['email']) ) {
      $this->errors['email'] = "Email Is Required!";
    }
    elseif (!filter_var($DATA['email'], FILTER_VALIDATE_EMAIL))
    {
      $this->errors['email'] = "Please Enter Valide Email!";
    }
    elseif ($this->where('email',$DATA['email']))
    {
      $this->errors['email'] = "Email Already Exists!";
    }

    // Validate Password
    if (!$id)
    {
      if (empty($DATA['password']))
      {
        $this->errors['password'] = "Please Enter Password.";

      }elseif (empty($DATA['password_retype']))
      {
        $this->errors['password_retype'] = "Please Confirm Password.";
      }elseif ($DATA['password'] !== $DATA['password_retype'])
      {
        $this->errors['password'] = "Password Do Not Match.";
      }elseif (strlen($DATA['password']) < 8)
      {
        $this->errors['password'] = "Password Must Be Atleast 8 Character Long.";
      }
    }else
    {
      if (!empty($DATA['password']))
      {
        if (empty($DATA['password_retype']))
        {
          $this->errors['password_retype'] = "Please Confirm Password.";
        }elseif ($DATA['password'] !== $DATA['password_retype'])
        {
          $this->errors['password'] = "Password Do Not Match.";
        }elseif (strlen($DATA['password']) < 8)
        {
          $this->errors['password'] = "Password Must Be Atleast 8 Character Long.";
        }
      }
    }

    if (count($this->errors) == 0) {
      return true;
    }
    return false;
  }

  // FORM VALIDATION BEFORE INSERTING EDITED DATA TO DATABASE
  public function edit_validate($DATA,$id)
  {
  	$this->errors = [];
    // Validate First Name
    if (empty($DATA['firstname'])) {
      $this->errors['firstname'] = "First Name Is Required!";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['firstname']))
    {
      $this->errors['firstname'] = "Only Letters Allowed, No Space!";
    }

    // Validate Last Name
    if (empty($DATA['lastname'])) {
      $this->errors['lastname'] = "Last Name Is Required!";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['lastname']))
    {
      $this->errors['lastname'] = "Only Letters Allowed, No Space!";
    }

    // Validate User Name
    if (empty($DATA['username'])) {
      $this->errors['username'] = "Username Is Required!";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['username']))
    {
      $this->errors['username'] = "Only Letters Allowed, No Space!";
    }

    // validate gender
    if (empty($DATA['gender'])) {
      $this->errors['gender'] = "Gender Is Required!";
    }

    // validate Country
    if (empty($DATA['country'])) {
      $this->errors['country'] = "Country Is Required!";
    }

    // Validate Phone Number
    if (empty($DATA['phone'])) {
      $this->errors['phone'] = "Phone Numbers Is Required!";
    }elseif (!preg_match('/^[0-9]+$/', $DATA['phone']))
    {
      $this->errors['phone'] = "Only Numbers Allowed, No Space!";
    }

    // Validate Address
    if (empty($DATA['address'])) {
      $this->errors['address'] = "Address Is Required!";
    }elseif (!preg_match('/^[a-zA-Z0-9 ]+$/', $DATA['address'])) {
      $this->errors['address'] = "Only Numbers Allowed!";
    }

    // Validate Company
    if (empty($DATA['company'])) {
      $this->errors['company'] = "Company Is Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['company'])) {
      $this->errors['company'] = "Only Numbers Allowed!";
    }

    // Validate email
    if (empty($DATA['email']) ) {
      $this->errors['email'] = "Email Is Required!";
    }
    elseif (!filter_var($DATA['email'], FILTER_VALIDATE_EMAIL))
    {
      $this->errors['email'] = "Please Enter Valide Email!";
    }
    elseif ($results = $this->where('email',$DATA['email']))
    {
      foreach ($results as $result) {
        if ($id != $result->id) {
          $this->errors['email'] = "Email Already Exists!";
        }
      }
    }

    // Validate About
    if (empty($DATA['about']) ) {
      $this->errors['about'] = "About Your Self Is Required!";
    }

    // validate twitter link
    if (!empty($DATA['twitterlink']))
    {
      if (!filter_var($DATA['twitterlink'],FILTER_VALIDATE_URL))
      {
        $this->errors['twitterlink'] = "Please Enter Valid Twitter Link.";
      }
    }
    // validate facebook link
    if (!empty($DATA['facebooklink']))
    {
      if (!filter_var($DATA['facebooklink'],FILTER_VALIDATE_URL))
      {
        $this->errors['facebooklink'] = "Please Enter Valid Facebook Link.";
      }
    }
    // validate instagram link
    if (!empty($DATA['instagramlink']))
    {
      if (!filter_var($DATA['instagramlink'],FILTER_VALIDATE_URL))
      {
        $this->errors['instagramlink'] = "Please Enter Valid Instagram Link.";
      }
    }
    // validate linkedin link
    if (!empty($DATA['linkedinlink']))
    {
      if (!filter_var($DATA['linkedinlink'],FILTER_VALIDATE_URL))
      {
        $this->errors['linkedinlink'] = "Please Enter Valid Linkedin Link.";
      }
    }
    if (count($this->errors) == 0) {
      return true;
    }
    return false;
  }

  public function password_hash($data)
  {
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    return $data;
  }

  // Function to generate User Id
  public function makeUserId($userData)
  {
    // Instantiate the database connection
    $db = new Database();

    // Query to fetch the last user ID
    $query = "SELECT userId FROM users ORDER BY id DESC LIMIT 1";
    $result = $db->query($query);

    $lastId = is_array($result) ? $result[0]->userId : null; // Fetch the last userId if available

    // Check if a previous userId exists
    if (!empty($lastId)) {
        // Extract the number from the userId
        $lastNumericCode = substr($lastId, 4); // Get the number after 'USR-'

        // Increment the number and pad with zeros to 4 digits
        $nextUserCode = str_pad(($lastNumericCode + 1), 4, "0", STR_PAD_LEFT);

        // Create the new user ID
        $userId = 'USR-' . $nextUserCode;
    } else {
        // Initialize with the default value for the first user
        $userId = 'USR-0001';
    }

    // Prepare the user ID array
    $userData['userId'] = $userId;
    // show($userData);die;
    // Return the updated array
    return $userData;
  }

  // get user by id
  public function getRoleById($rows)
  {

    $db = new Database();
    if (!empty($rows[0]->usersRoleId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT role FROM roles WHERE roleId = :roleId LIMIT 1";
        $role = $db->query($query,['roleId'=>$row->usersRoleId]);

        if (!empty($role))
        {
          $rows[$key]->roleRow = $role[0];
        }
      }
    }

    return $rows;
  }

}
