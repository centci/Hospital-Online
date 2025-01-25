<?php
// print_readerbale function
function show($data)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}
// function to escape or remove unwanted character in the form
function esc($str)
{
  return nl2br(htmlspecialchars($str));
}

function set_value($key, $default ='')
{
  if (!empty($_POST[$key]))
  {
    return $_POST[$key];
  }
  return $default;
}
// function to return selected value back incase of any errors in the form
function get_select($key, $value)
{
  // Check if the form was submitted and if the key exists in the submitted data
  if (isset($_POST[$key]))
  {
    // Compare the submitted value for the key with the provided value
    if ($_POST[$key] == $value)
    {
        return "selected"; // Indicate that this option should be selected
    }
  }
  return ""; // Default return value (no "selected" attribute)
}

// success message
function message($msg = '', $erase = false)
{
  if (!empty($msg))
  {
    $_SESSION['message'] = $msg;
  }
  else
  {
    if (!empty($_SESSION['message']))
    {
      $msg = $_SESSION['message'];
      if ($erase) {
        unset($_SESSION['message']);
      }
      return $msg;
    }
  }
  return false;
}
// warrning maessage
function warrningMessage($msg = '', $erase = false)
{
  if (!empty($msg))
  {
    $_SESSION['Wmessage'] = $msg;
  }
  else
  {
    if (!empty($_SESSION['Wmessage']))
    {
      $msg = $_SESSION['Wmessage'];
      if ($erase) {
        unset($_SESSION['Wmessage']);
      }
      return $msg;
    }
  }
  return false;
}
// Change Short date date_format
function get_date($date)
{
	return date("jS M, Y", strtotime($date));
}
// Change Short date date_format
function num_date($date)
{
	return date("j-m-Y", strtotime($date));
}

// Function to resize an image to a specified maximum dimension (e.g., 700px)
function resize_image($filename, $max_size = 700)
{
    // First, check if the file exists to avoid errors
    if (!file_exists($filename)) {
        return false; // Return false if the file does not exist
    }

    // Extract the file extension in lowercase for processing
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Determine the appropriate image creation function based on the file type
    switch ($ext) {
        case 'png':
            $image = imagecreatefrompng($filename); // For PNG images
            break;
        case 'gif':
            $image = imagecreatefromgif($filename); // For GIF images
            break;
        case 'jpg': // For JPG images
        case 'jpeg':
            $image = imagecreatefromjpeg($filename);
            break;
        default:
            return false; // Return false for unsupported file formats
    }

    // Get the original width and height of the image
    $src_w = imagesx($image); // Source width
    $src_h = imagesy($image); // Source height

    // Calculate the dimensions for the resized image based on the aspect ratio
    if ($src_w > $src_h) {
        // Landscape orientation: Keep width at max_size and scale height proportionally
        $dst_w = $max_size;
        $dst_h = ($src_h / $src_w) * $max_size;
    } else {
        // Portrait or square orientation: Keep height at max_size and scale width proportionally
        $dst_h = $max_size;
        $dst_w = ($src_w / $src_h) * $max_size;
    }

    // Create a new blank image with the desired dimensions
    $dst_image = imagecreatetruecolor($dst_w, $dst_h);

    // Resize and copy the original image into the blank image
    imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

    // Overwrite the original file with the resized image based on its file type
    switch ($ext) {
        case 'png':
            imagepng($dst_image, $filename); // Save resized PNG
            break;
        case 'gif':
            imagegif($dst_image, $filename); // Save resized GIF
            break;
        case 'jpg': // Save resized JPG
        case 'jpeg':
            imagejpeg($dst_image, $filename, 70); // 70 is the JPEG quality level
            break;
    }

    // Free up memory used by the images
    imagedestroy($image);      // Destroy the original image resource
    imagedestroy($dst_image); // Destroy the resized image resource

    return $filename; // Return the path to the resized image
}

// Function to get the appropriate image based on gender and file existence
function get_image($image, $gender = 'male')
{
    // Define paths to the default images for male and female users
    $female_image = ROOT . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'user_female.jpg';
    $male_image = ROOT . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'user_male.jpg';

    // Check if the provided image file exists
    if (!file_exists($image)) {
        // If image does not exist, provide default image based on gender
        if ($gender === 'male') {
            $image = $male_image; // Set the default male image
        } else {
            $image = $female_image; // Set the default female image
        }
    } else {
        // If the image exists, resize it
        $resized_image = resize_image($image);
        if ($resized_image) {
            // If the resize is successful, set the resized image path
            $image = ROOT . DIRECTORY_SEPARATOR . $resized_image;
        }
    }

    // Normalize the file path to use forward slashes for consistency
    return str_replace('\\', '/', $image);
}

/**********************************************************************************
* function to  Remove Special Char Including Numbers and spaces from an array      *
* Note: if you dont want any character not to be removed, add it within the [...]  *
***********************************************************************************/
function RemoveSpecialChar($array)
{
  $res = preg_replace('/[^a-zA-Z]+$/','',$array);
  return $res;
}
//function to Make Randome String/Numbers ID(you can add A,B,C,D,E,F,G,......if you want numbers mix with letters and vise vasa)
function random_string($length)
{
  $array = array(0,1,2,3,4,5,6,7,8,9);
  $text = "";
  for ($x=0; $x < $length; $x++)
  {
    $random = rand(0,9);
    $text .= $array[$random];
  }

  return $text;
}
// make subtest code
function make_subTestCode($testCode)
{
  $db = new Database();
  $query = "SELECT testCode FROM tests ORDER BY id DESC LIMIT 1";
  $Tcode = $db->query($query);

  if (is_array($Tcode))
  {
    $testCode = $Tcode[0]->testCode;
  }
// show($testCode);die;
  return $testCode;
}
