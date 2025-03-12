<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Model;

use Hieunv\WineProducer\Api\Data\ProducerInterface;
use Magento\Framework\Model\AbstractModel;

class Producer extends AbstractModel implements ProducerInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Hieunv\WineProducer\Model\ResourceModel\Producer::class);
    }

    /**
     * @inheritDoc
     */
    public function getProducerId(): ?string
    {
        return $this->getData(self::PRODUCER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProducerId($producerId): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
    {
        return $this->setData(self::PRODUCER_ID, $producerId);
    }

    /**
     * @inheritDoc
     */
    public function getEnable(): ?string
    {
        return $this->getData(self::ENABLE);
    }

    /**
     * @inheritDoc
     */
    public function setEnable($enable): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
    {
        return $this->setData(self::ENABLE, $enable);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getImage(): ?string
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $image): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * @inheritDoc
     */
    public function getWebsite(): ?string
    {
        return $this->getData(self::WEBSITE);
    }

    /**
     * @inheritDoc
     */
    public function setWebsite(string $website): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
    {
        return $this->setData(self::WEBSITE, $website);
    }
}
