<?php
namespace Market\Traits;

trait CategoryTrait
{
    protected $categories;
    public function setCategories($cat)
    {
	$this->categories = $cat;
    }
}

