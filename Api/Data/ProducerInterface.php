<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Api\Data;

interface ProducerInterface
{

    public const ENABLE = 'enable';
    public const IMAGE = 'image';
    public const NAME = 'name';
    public const PRODUCER_ID = 'producer_id';
    public const DESCRIPTION = 'description';
    public const WEBSITE = 'website';

    /**
     * Get producer_id
     *
     * @return string|null
     */
    public function getProducerId(): ?string;

    /**
     * Set producer_id
     *
     * @param string $producerId
     * @return \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
     */
    public function setProducerId($producerId): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface;

    /**
     * Get enable
     *
     * @return string|null
     */
    public function getEnable(): ?string;

    /**
     * Set enable
     *
     * @param string $enable
     * @return \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
     */
    public function setEnable($enable): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set name
     *
     * @param string $name
     * @return \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
     */
    public function setName(string $name): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface;

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set description
     *
     * @param string $description
     * @return \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
     */
    public function setDescription(string $description): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface;

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage(): ?string;

    /**
     * Set image
     *
     * @param string $image
     * @return \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
     */
    public function setImage(string $image): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface;

    /**
     * Get website
     *
     * @return string|null
     */
    public function getWebsite(): ?string;

    /**
     * Set website
     *
     * @param string $website
     * @return \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface
     */
    public function setWebsite(string $website): \Hieunv\WineProducer\Producer\Api\Data\ProducerInterface;
}
