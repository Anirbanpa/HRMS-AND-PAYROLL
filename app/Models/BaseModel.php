<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class BaseModel
 *
 * Base architectural model providing unified pagination, activity hooks,
 * soft deletes, and safe query helpers across all HRMS entities.
 */
abstract class BaseModel extends Model
{
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Find active records (excluding soft-deleted if enabled)
     *
     * @param array $conditions
     * @return array
     */
    public function getActive(array $conditions = []): array
    {
        $builder = $this->builder();
        if (!empty($conditions)) {
            $builder->where($conditions);
        }
        if ($this->useSoftDeletes) {
            $builder->where($this->deletedField, null);
        }
        return $builder->get()->getResultArray();
    }

    /**
     * Safe parameterized count with criteria
     *
     * @param array $criteria
     * @return int
     */
    public function countFiltered(array $criteria = []): int
    {
        $builder = $this->builder();
        if (!empty($criteria)) {
            $builder->where($criteria);
        }
        if ($this->useSoftDeletes) {
            $builder->where($this->deletedField, null);
        }
        return $builder->countAllResults();
    }
}
