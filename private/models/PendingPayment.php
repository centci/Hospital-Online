<?php
/**
 * Visit Class Model
 */
class PendingPayment extends Model
{
  protected $table = 'pendingPayments'; // Explicitly set the table name

  protected $allowedColumns = [
  // saving item to tabel pendingPayments
    'pendingPayId',
    'pendingPayVisitId',
    'patientNo',
    'departmentId',
    'itemCode',
    'sentBy',
    'pendingPayDate',
  ];

  protected $afterSelect = [
    'patientInfo',
    // 'testsInfo',
    // 'departmentInfo',
    'getUserById',
  ];
  // protected $beforeInsert = [
  //   'make_pendingPayId',
  // ];

  // get Patients information by patientNo
  public function patientInfo($rows)
  {
    // show($rows);die;

    $db = new Database();
    if (!empty($rows))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT firstname, middlename, lastname FROM patients WHERE patientId = :patientNo LIMIT 1";
        $ptnInfo = $db->query($query,['patientNo'=>$row->patientNo]);
        if (!empty($ptnInfo))
        {
          $ptnInfo[0]->fullName = esc($ptnInfo[0]->firstname ." ".$ptnInfo[0]->lastname);
          $rows[$key]->ptnInfoRow = $ptnInfo[0];
        }
      }
    }
    return $rows;
  }

  // get user by id
  public function getUserById($rows)
  {
    // show($rows);die;

    $db = new Database();
    if (!empty($rows))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT firstname,lastname,username FROM users WHERE id = :sentBy LIMIT 1";
        $user = $db->query($query,['sentBy'=>$row->sentBy]);
        if (!empty($user))
        {
          $user[0]->fullName = esc($user[0]->firstname ." ". $user[0]->lastname);
          $rows[$key]->userRow = $user[0];
        }
      }
    }
    return $rows;
  }
}
