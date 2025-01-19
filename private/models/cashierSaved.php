<?php
/**
 * Visit Class Model
 */
class cashierSaved extends Model
{
  protected $table = "cashierSaveds";

  protected $allowedColumns = [
// saving item to tabel cashierSaveds
    'cashierSavedReceiptNo',
    'cashierSavedTestCode',
    'cashierSavedPendingPayId',
    'cashierSavedBy',
    'cashierSavedStatus',
    'cashierSavedDate',
  ];
}
