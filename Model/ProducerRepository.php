<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Model;

use Hieunv\WineProducer\Api\Data\ProducerInterface;
use Hieunv\WineProducer\Api\Data\ProducerInterfaceFactory;
use Hieunv\WineProducer\Api\Data\ProducerSearchResultsInterfaceFactory;
use Hieunv\WineProducer\Api\ProducerRepositoryInterface;
use Hieunv\WineProducer\Model\ResourceModel\Producer as ResourceProducer;
use Hieunv\WineProducer\Model\ResourceModel\Producer\CollectionFactory as ProducerCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProducerRepository implements ProducerRepositoryInterface
{

    /**
     * @var ProducerCollectionFactory
     */
    protected ProducerCollectionFactory $producerCollectionFactory;

    /**
     * @var Producer
     */
    protected Producer|ProducerSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @var ProducerInterfaceFactory
     */
    protected ProducerInterfaceFactory $producerFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var ResourceProducer
     */
    protected ResourceProducer $resource;

    /**
     * @param ResourceProducer $resource
     * @param ProducerInterfaceFactory $producerFactory
     * @param ProducerCollectionFactory $producerCollectionFactory
     * @param ProducerSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceProducer $resource,
        ProducerInterfaceFactory $producerFactory,
        ProducerCollectionFactory $producerCollectionFactory,
        ProducerSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->producerFactory = $producerFactory;
        $this->producerCollectionFactory = $producerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(ProducerInterface $producer): ProducerInterface
    {
        try {
            $this->resource->save($producer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the producer: %1',
                $exception->getMessage()
            ));
        }
        return $producer;
    }

    /**
     * @inheritDoc
     */
    public function get(string $producerId): ProducerInterface
    {
        $producer = $this->producerFactory->create();
        $this->resource->load($producer, $producerId);
        if (!$producer->getId()) {
            throw new NoSuchEntityException(__('Producer with id "%1" does not exist.', $producerId));
        }
        return $producer;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ): \Hieunv\WineProducer\Api\Data\ProducerSearchResultsInterface {
        $collection = $this->producerCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(ProducerInterface $producer): bool
    {
        try {
            $producerModel = $this->producerFactory->create();
            $this->resource->load($producerModel, $producer->getProducerId());
            $this->resource->delete($producerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Producer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($producerId): bool
    {
        return $this->delete($this->get($producerId));
    }
}
