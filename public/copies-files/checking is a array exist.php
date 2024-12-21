<?php

$DATA = Array(
'data_type' => 'save',
'subTestCode_2' => 'LAB0002-3',
'xtraTestName_2' => 'abc',
'xtraRefRanges_2' => 'abc',
'xtraUnitid_2' => 'abc',
'xtraTestCode_2' => 'LAB0002',
'xtraUserId_2' => '1',
'xtraTestDate_2' => '2024-07-18 23:11:00');

$baseKey = ['xtraTestName',];

$suffixes = ['_0','_1','_2','_3','_4','_5','_6','_7','_8','_9','_10','_11','_12','_13','_14','_15','_16','_17','_18','_19','_20'];
foreach ($suffixes as $suffix)
{
  $completeKey = $baseKey.$suffix;
  if (array_key_exists($completeKey,$DATA))
  {
    // code...
    echo "the key '$completeKey' exists in the array";
  }else
  {
    echo "the key '$completeKey' dose not exists in the array.";
  }
  echo "\n";
}

// ###################### SECOND CODE #############################


$DATA = Array(
'data_type' => 'save',
'subTestCode_2' => 'LAB0002-3',
'xtraTestName_2' => 'abc',
'xtraRefRanges_2' => 'abc',
'xtraUnitid_2' => 'abc',
'xtraTestCode_2' => 'LAB0002',
'xtraUserId_2' => '1',
'xtraTestDate_2' => '2024-07-18 23:11:00');

$baseKeys = ['xtraTestCode', 'subTestCode', 'xtraTestName', 'xtraRefRanges', 'xtraUnitid', 'xtraUserId', 'xtraTestDate'];
$suffixes = ['_0','_1','_2','_3','_4','_5','_6','_7','_8','_9','_10','_11','_12','_13','_14','_15','_16','_17','_18','_19','_20'];
foreach ($baseKeys as $baseKey)
{
  foreach ($suffixes as $suffix)
  {
    $completeKey = $baseKey.$suffix;
    if (array_key_exists($completeKey,$DATA))
    {
      // code...
      echo "the key '$completeKey' exists in the array";
    }else
    {
      echo "the key '$completeKey' dose not exists in the array.";
    }
    echo "\n";
  }
}
