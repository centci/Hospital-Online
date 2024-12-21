<?php
/**
 * User Class Model
 */
class User extends Model
{
  protected $allowedColumns = [
    'firstname',
    'lastname',
    'username',
    'gender',
    'email',
    'role',
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

  // password hash
  protected $beforInsert = ['password_hash'];

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
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['username'])) {

      $this->errors['username'] = "Only Letters Allowed, No Space!";
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

}
