<?php declare(strict_types=1);

namespace Yireo\LiveTestRunner\TestCase;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

class CatalogTestCase extends GenericTestCase
{
    /**
     * @return ProductRepositoryInterface
     */
    protected function getProductRepository(): ProductRepositoryInterface
    {
        return $this->get(ProductRepositoryInterface::class);
    }

    /**
     * @return CategoryRepositoryInterface
     */
    protected function getCategoryRepository(): CategoryRepositoryInterface
    {
        return $this->get(CategoryRepositoryInterface::class);
    }

    /**
     * @return SearchCriteriaBuilder
     */
    protected function getSearchCriteriaBuilder(): SearchCriteriaBuilder
    {
        return $this->getObjectManager()->create(SearchCriteriaBuilder::class);
    }

    /**
     * @param int $categoryId
     */
    protected function assertCategoryIdExists(int $categoryId)
    {
        $exception = null;
        try {
            $category = $this->getCategoryRepository()->get($categoryId);
            $this->assertEquals($categoryId, $category->getId());
        } catch (NoSuchEntityException $exception) {
        }

        $this->assertNull($exception, 'Failed loading category with ID ' . $categoryId);
    }
}
