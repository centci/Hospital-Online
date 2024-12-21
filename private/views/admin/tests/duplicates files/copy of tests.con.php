<?php

  // validating of forms
  if ($xtratest->validate($_POST))
  {
    // $xtraTest = [];
    $xtraTestName = [];
    $xtraRefRanges = [];
    $xtraUnitid = [];
    $xtraTestCode = [];
    $xtraUserId = [];
    $xtraTestDate = [];
    foreach ($_POST as $key => $value)
    {
  // Removing all the input under score and numbers at the end of each names
      if(preg_match("/^[xtraTestName]+_[0-9]+$/", $key))
      {
        $xtraTestNameKey = RemoveSpecialChar($key);
        $xtraTestName[$xtraTestNameKey][] = $value;
      }
      if(preg_match("/^[xtraRefRanges]+_[0-9]+$/", $key))
      {
        $xtraRefRangesKey = RemoveSpecialChar($key);
        $xtraRefRanges[$xtraRefRangesKey][] = $value;
      }
      if(preg_match("/^[xtraUnitid]+_[0-9]+$/", $key))
      {
        $xtraUnitidKey = RemoveSpecialChar($key);
        $xtraUnitid[$xtraUnitidKey][] = $value;
      }
      if(preg_match("/^[xtraTestCode]+_[0-9]+$/", $key))
      {
        $xtraTestCodeKey = RemoveSpecialChar($key);
        $xtraTestCode[$xtraTestCodeKey][] = $value;
      }
      if(preg_match("/^[xtraUserId]+_[0-9]+$/", $key))
      {
        $xtraUserIdKey = RemoveSpecialChar($key);
        $xtraUserId[$xtraUserIdKey][] = $value;
      }
      if(preg_match("/^[xtraTestDate]+_[0-9]+$/", $key))
      {
        $xtraTestDateKey = RemoveSpecialChar($key);
        $xtraTestDate[$xtraTestDateKey][] = $value;
      }
  // End of Removing all the input under score and numbers at the end of each names

    }

    foreach ($xtraTestName as $key => $rows) {
      foreach ($rows as $key2 => $value) {
        $arr = [];
        $arr['xtraTestName'] 		= $value;
        $arr['xtraRefRanges'] = $xtraTest[$key][$key2];
      }
      // code...
    }
    show($xtraTestName);
    // show($_POST);
    die;

    $info['data'] = 'extra test saved';
    $info['data_type'] = save;
  }



// ==================================================another code===========================

f ($xtratest->validate($_POST))
{
  $xtraTest = [];
  foreach ($_POST as $key => $value)
  {
// Removing all the input under score and numbers at the end of each names
    if(preg_match("/^[xtraTestName]+_[0-9]+$/", $key))
    {
      $mainkey = RemoveSpecialChar($key);
      $xtraTest[$mainkey][] = $value;
    }
    if(preg_match("/^[xtraRefRanges]+_[0-9]+$/", $key))
    {
      $mainkey = RemoveSpecialChar($key);
      $xtraTest[$mainkey][] = $value;
    }
    if(preg_match("/^[xtraUnitid]+_[0-9]+$/", $key))
    {
      $mainkey = RemoveSpecialChar($key);
      $xtraTest[$mainkey][] = $value;
    }
    if(preg_match("/^[xtraTestCode]+_[0-9]+$/", $key))
    {
      $mainkey = RemoveSpecialChar($key);
      $xtraTest[$mainkey][] = $value;
    }
    if(preg_match("/^[xtraUserId]+_[0-9]+$/", $key))
    {
      $mainkey = RemoveSpecialChar($key);
      $xtraTest[$mainkey][] = $value;
    }
    if(preg_match("/^[xtraTestDate]+_[0-9]+$/", $key))
    {
      $mainkey = RemoveSpecialChar($key);
      $xtraTest[$mainkey][] = $value;
    }
// End of Removing all the input under score and numbers at the end of each names

  }
// ===================================================================================
for ($i=0; $i < count ($xtraTestName); $i++)
{
  $datasave = [
    'xtraTestName'      => $xtraTestName,
    'xtraRefRanges'     => $xtraRefRanges,
    'xtraUnitid'        => $xtraUnitid,
    'xtraTestCode'        => $xtraTestCode,
    'xtraUserId'        => $xtraUserId,
    'xtraTestDate'      => $xtraTestDate,
  ];
}
show($datasave);
die;
// $arrayName = array(
//   array('first' => 'nelson', 'lastname'=>'makon' ),
//   array('age' => '23', 'sex'=>'male' ),
// );
//
// foreach ($arrayName as $key => $value) {
//   // code...
//   show($key);
//
// }
//
// die;

// show($xtraTest);
// die;
