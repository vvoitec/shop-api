<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use App\Common\Domain\Filtering\Criteria;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;

class DoctrineCriteriaAdapter implements CriteriaAdapter
{
    public function convert(Criteria $criteria): DoctrineCriteria
    {
        return new DoctrineCriteria(
            $this->buildExpression($criteria->filters()),
            null,
            $criteria->offset(),
            $criteria->limit(),
        );
    }

    private function buildExpression(array $filters)
    {
        $criteria = new DoctrineCriteria();
        $expressions = array();
        foreach ($filters as $fieldName => $filter) {
            if ($filter) {
                array_push($expressions,
                    is_array($filter) ?
                        $criteria::expr()->in($fieldName, $filter)
                        : $criteria::expr()->eq($fieldName, $filter)
                );
            }
        }
        return count($expressions) > 1 ? $criteria::expr()->andX(...$expressions) : $expressions[0] ?? null;
    }
}