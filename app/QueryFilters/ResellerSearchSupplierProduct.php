<?php

namespace App\QueryFilters;

use Cerbero\QueryFilters\QueryFilters;
use Modules\Master\Models\MpProductCategory;

/**
 * Filter records based on query parameters.
 *
 */
class ResellerSearchSupplierProduct extends QueryFilters
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
    public function mpProductCategoryId($productCategoryId)
    {
        if (!is_null($productCategoryId)) {
            $getChildProductCategory = MpProductCategory::where('id', $productCategoryId)
                                        ->with(str_repeat('children.', 5))
                                        ->first();

            if ($getChildProductCategory) {
                $childProductCategories = $getChildProductCategory->children;
                if ($childProductCategories->count() > 0) {
                    $childIdsProductCategory = $childProductCategories->pluck('id');
                    $childIdsProductCategoryArray = $childIdsProductCategory->all();
                    array_push($childIdsProductCategoryArray, (int) $productCategoryId);
                    $this->query->whereIn('mp_product_category_id', $childIdsProductCategoryArray);
                } else {
                    $this->query->where('mp_product_category_id', $productCategoryId);
                }
            }
        }
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
}
