<?php

function show($data)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}

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

function get_select($key, $vlaue)
{
	if (isset($_POST[$key]))
	{
		if ($_POST[$key] == $vlaue)
		{
			return "selected";
		}
	}

	return "";
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
// crop image function
function resize_image($filename, $max_size = 700)
{

  $ext = explode(".", $filename);
  $ext = strtolower(end($ext));

  if (file_exists($filename))
  {
    switch ($ext) {
      case 'png':
        $image = imagecreatefrompng($filename);
        break;

      case 'gif':
        $image = imagecreatefromgif($filename);
        break;

      case 'jpg':
      case 'jpeg':
        $image = imagecreatefromjpeg($filename);
        break;

      default:
        $image = imagecreatefromjpeg($filename);
        break;
    }

    $src_w = imagesx($image);
    $src_h = imagesy($image);

    if ($src_w > $src_h)
    {
      $dst_w = $max_size;
      $dst_h = ($src_h / $src_w) * $max_size;
    }
    else
    {
      $dst_w = ($src_w / $src_h) * $max_size;
      $dst_h = $max_size;
    }

    $dst_image = imagecreatetruecolor($dst_w, $dst_h);

    imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

    imagedestroy($image);

    imagejpeg($dst_image,$filename,70);

    switch ($ext) {
      case 'png':
        imagepng($dst_image,$filename);
        break;

      case 'gif':
        imagegif($dst_image,$filename);
        break;

      case 'jpg':
      case 'jpeg':
        imagejpeg($dst_image,$filename,70);
        break;

      default:
        imagejpeg($dst_image,$filename,70);
        break;
    }

    imagedestroy($dst_image);

  }
  return $filename;
}

//function to Make Randome String ID
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

// function to change image acording to gender
function get_image($image, $gender = 'male')
{
  if (!file_exists($image))
	{
    $image = ROOT.'/assets/images/user_female.jpg';
    if ($gender == 'male')
		{
      $image = ROOT.'/assets/images/user_male.jpg';
    }
  }
	else
	{
		$image = ROOT . '/' . resize_image($image);
	}
  return $image;
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

// make subtest code
function make_subTestCode($testCode)
{
  $db = New Database();
  $query = "SELECT testCode FROM tests ORDER BY id DESC LIMIT 1";
  $Tcode = $db->query($query);

  if (is_array($Tcode))
  {
    $testCode = $Tcode[0]->testCode;
  }
// show($testCode);die;
  return $testCode;
}
