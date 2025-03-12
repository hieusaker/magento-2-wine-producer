<?php

namespace Hieunv\WineProducer\Controller\Adminhtml\Producer;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Hieunv\WineProducer\Model\ImageUploader as ImageUploaderModel;
use Magento\Framework\Controller\ResultInterface;

class ImageUploader extends Action
{
    /**
     * @var ImageUploaderModel
     */
    public ImageUploaderModel $imageUploader;

    /**
     * @param Context $context
     * @param ImageUploaderModel $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploaderModel $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Image uploader
     *
     * @return ResponseInterface|Json|(Json&ResultInterface)|ResultInterface
     */
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('producer_image');
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
