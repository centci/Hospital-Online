<?php
/**
 * Visit Class Model
 */
class LabRequest extends Model
{
  protected $table = 'labRequests'; // Explicitly set the table name

  protected $allowedColumns = [
// saving item to tabel laboratorys
  'labReqSampleId',
  'labReqPatientId',
  'labReqVisitId',
  'labReqTestCode',
  'LabReqCashierSavedReceiptNo',
  'labReqSavedByUserId',
  'DrawnDate',
  ];
}
