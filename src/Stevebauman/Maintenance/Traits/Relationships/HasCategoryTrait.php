<?php

namespace Stevebauman\Maintenance\Traits\Relationships;

use Stevebauman\Maintenance\Models\Category;

trait HasCategoryTrait
{
    /**
     * The has one category relationship.
     *
     * @return mixed
     */
    public function category()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\Category', 'id', 'category_id');
    }

    /**
     * Filters results by specified category.
     *
     * @return object
     */
    public function scopeCategory($query, $categoryId = null)
    {
        if ($categoryId) {
            /*
             * Get descendants and self inventory category nodes
             */
            $categories = Category::find($categoryId)->getDescendantsAndSelf();
            /*
             * Perform a subquery on main query
             */
            $query->where(function ($query) use ($categories) {
                /*
                 * For each category, apply a orWhere query to the sub-query
                 */
                foreach ($categories as $category) {
                    $query->orWhere('category_id', $category->id);
                }

                return $query;
            });
        }
    }
}
