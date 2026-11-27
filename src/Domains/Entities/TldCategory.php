<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Entity;

/**
 * A TLD category from the catalogue, as returned by TldCategoryClient::getAll(). Only `name` is ever returned
 * by that endpoint; order and category IDs are not exposed there (they appear only on the category embedded in
 * a TLD's own response, via the Tld entity's categoryOrder).
 *
 * @property string $name
 */
class TldCategory extends Entity
{
}
