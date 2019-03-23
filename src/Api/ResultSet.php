<?php
/**
 * Part of the Open Web Analytics PHP REST Client package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Open Web Analytics PHP REST Client
 * @version    0.1.2
 * @author     VerdeIT
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019-2019, VerdeIT
 * @link       https://github.com/hafael/owa-php-client
 */

namespace Hafael\OpenWebAnalytics\Api;


class ResultSet extends Api
{

    /**
     * This method returns the profile of the item defined by the tenantid, itemid and the itemtypeid.
     *
     * @param $itemId
     * @param $itemType
     * @return array|mixed
     */
    public function getResultSet($metrics, $startDate, $endDate, $dimensions = null, $constraints = [])
    {
        foreach($constraints as $constraint) {
            $this->setConstraint($constraint[0], $constraint[1], $constraint[2]);
        }
        return $this->_get("api.php", [
            "owa_do" => "getResultSet",
            "owa_metrics" => $metrics,
            "owa_constraints" => $this->getParsedConstraints(),
            "owa_dimensions" => $dimensions,
            "owa_startDate" => $startDate,
            "owa_endDate" => $endDate,
        ]);
    }


}