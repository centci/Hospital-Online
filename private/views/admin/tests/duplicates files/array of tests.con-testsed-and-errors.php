<?php
// ===========TEMPORARY CODE USED TO INSERT INTO extratests TABLE===============
// for loop code for inserting array in the database

for ($i=0; $i < count ($_POST['xtraTestName']); $i++)
{
  $xtraTestName   =  $_POST['xtraTestName'][$i];
  $xtraRefRanges  =  $_POST['xtraRefRanges'][$i];
  $xtraUnitid     =  $_POST['xtraUnitid'][$i];
  $xtraTestCode     =  $_POST['xtraTestCode'][$i];
  $xtraUserId     =  $_POST['xtraUserId'][$i];
  $xtraTestDate   =  $_POST['xtraTestDate'][$i];

  $sql = ("INSERT INTO `extratests` (`xtraTestName`, `xtraRefRanges`, `xtraUnitid`, `xtraUserId`, `xtraTestCode`, `xtraTestDate`) VALUES ('$xtraTestName', '$xtraRefRanges', '$xtraUnitid', '$xtraTestCode', '$xtraUserId', '$xtraTestDate');");
  $results = $db->query($sql);

  // die;
}
// ========================THE END OF TEMPORARY CODE============================

/*-----------------------------------------------------------------------------------------------------------------*
 * ======================ERROR WHEN INSERTING TWO DIMENTIONAL ARRAY USING (INSERT FUNCTION IN THE MODEL)===========*
 *-----------------------------------------------------------------------------------------------------------------*/

Warning: Array to string conversion in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24

Warning: Array to string conversion in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24

Warning: Array to string conversion in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24

Warning: Array to string conversion in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24

Warning: Array to string conversion in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24

Warning: Array to string conversion in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24

Fatal error: Uncaught PDOException: SQLSTATE[22007]: Invalid datetime format: 1366 Incorrect integer value: 'Array' for column `clinic`.`extratests`.`xtraUnitid` at row 1 in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php:24 Stack trace: #0 /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php(24): PDOStatement->execute(Array) #1 /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Model.php(115): Database->query('INSERT INTO ext...', Array) #2 /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/controllers/Tests.con.php(123): Model->insert(Array) #3 /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/App.php(37): Tests->addExtraTests('78') #4 /Applications/XAMPP/xamppfiles/htdocs/projects/inno/public/index.php(7): App->__construct() #5 {main} thrown in /Applications/XAMPP/xamppfiles/htdocs/projects/inno/private/core/Database.php on line 24


// ------------------------THE ARRAY CODE BELLOW WAS USED-----------------------------------------------
$tests = Array
(
    [xtraTestName] => Array
        (
            [0] => one name
            [1] => two name
        )

    [xtraRefRanges] => Array
        (
            [0] => ref one
            [1] => ref two
        )

    [xtraUnitid] => Array
        (
            [0] => 5
            [1] => 3
        )

    [xtraTestCode] => Array
        (
            [0] => 78
            [1] => 78
        )

    [xtraUserId] => Array
        (
            [0] => 1
            [1] => 1
        )

    [xtraTestDate] => Array
        (
            [0] => 2024-01-28 00:16:15
            [1] => 2024-01-28 00:16:15
        )

);
// --------------------------END OF THE ARRAY CODE USED-------------------------------------------------

// ------------------------THE FOR LOOP CODE BELLOW WAS USED-----------------------------------------------
for ($i=0; $i < count ($_POST['xtraTestName']); $i++)
{
      $_POST['xtraTestName'][$i];
      $_POST['xtraRefRanges'][$i];
      $_POST['xtraUnitid'][$i];
      $_POST['xtraTestCode'][$i];
      $_POST['xtraUserId'][$i];
      $_POST['xtraTestDate'][$i];

  $extratest->insert($_POST);

}
// ------------------------END OF THE FOR LOOP CODE USED--------------------------------------------------
