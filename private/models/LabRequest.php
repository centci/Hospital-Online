<?php
/**
 * Visit Class Model
 */
class LabRequest extends Model
{
  protected $allowedColumns = [
// saving item to tabel laboratorys
  'labReqSampleId',
  'labReqPtn_id',
  'labReqTestCode',
  'LabReqFinaceReceipt',
  'labReqSaved_by',
  'DrawnDate',
  ];
}
