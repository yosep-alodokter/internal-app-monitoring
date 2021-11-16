<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;

/**
 * Filter records based on query parameters.
 *
 */
class ResellerSearchSupplierProductWithChildCategory extends QueryFilters
{
    /**
     * Filter records based on the query parameter "name"
     * 
     * @return void
     */
    public function name($name)
    {
        if (!is_null($name))
            $this->query->where('name', 'like', $name . '%');
    }

    /**
     * Filter records based on the query parameter "mp_product_category_id"
     * 
     * @return void
     */
    public function mpProductCategoryId($categoryId)
    {
        if (!is_null($categoryId))
            $this->query->where('mp_product_category_id', $categoryId);
    }

    /**
     * Filter records based on the query parameter "mp_product_brand_id"
     * 
     * @return void
     */
    public function mpProductBrandId($brandId)
    {
        if (!is_null($brandId))
            $this->query->where('mp_product_brand_id', $brandId);
    }

    /**
     * Filter records based on the query parameter "supplier_id"
     * 
     * @return void
     */
    public function supplierId($supplierId)
    {
        if (!is_null($supplierId))
            $this->query->where('supplier_id', $supplierId);
    }

    /**
     * Filter records based on the query parameter "mp_product_category_child_id"
     * 
     * @return void
     */
    public function mpProductCategoryChildId($categoryId)
    {
        if (!is_null($categoryId))
            $this->query->orWhere('mp_product_category_id', $categoryId);
    }
}
