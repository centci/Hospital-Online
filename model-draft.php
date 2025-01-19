<?php
/**

 * Main Model class

 */
class Model extends Database
{
    public $errors = [];
    public $table;

    public function __construct()
    {
        // Automatically set the table name if not defined in the child model
        if (!property_exists($this, 'table')) {
            $this->table = strtolower(get_class($this)) . "s"; // Default: Class name + "s" (e.g., Department -> departments)
        }
    }
// ===========================================================================================

}
