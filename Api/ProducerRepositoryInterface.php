<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ProducerRepositoryInterface
{

    /**
     * Save Producer
     *
     * @param \Hieunv\WineProducer\Api\Data\ProducerInterface $producer
     * @return \Hieunv\WineProducer\Api\Data\ProducerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Hieunv\WineProducer\Api\Data\ProducerInterface $producer
    ): Data\ProducerInterface;

    /**
     * Retrieve Producer
     *
     * @param string $producerId
     * @return \Hieunv\WineProducer\Api\Data\ProducerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(string $producerId): Data\ProducerInterface;

    /**
     * Retrieve Producer matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Hieunv\WineProducer\Api\Data\ProducerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): Data\ProducerSearchResultsInterface;

    /**
     * Delete Producer
     *
     * @param \Hieunv\WineProducer\Api\Data\ProducerInterface $producer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Hieunv\WineProducer\Api\Data\ProducerInterface $producer
    ): bool;

    /**
     * Delete Producer by ID
     *
     * @param string $producerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($producerId): bool;
}
