<?php

declare(strict_types=1);

namespace Jimmy\CsvImport\Controller\Adminhtml\Import;

use Exception;
use Jimmy\CsvImport\Model\CsvImportHandler;
use Jimmy\CsvImport\Services\FileSystemService;
use Laminas\Http\Request;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;

class Upload implements HttpPostActionInterface
{
    private RedirectFactory $redirectFactory;

    private ManagerInterface $messageManager;

    private RequestInterface|Request $request;

    private CsvImportHandler $importHandler;

    private FileSystemService $fileSystemService;

    public function __construct(
        RedirectFactory $redirectFactory,
        Context $context,
        CsvImportHandler $importHandler,
        FileSystemService $fileSystemService
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $context->getMessageManager();
        $this->request = $context->getRequest();
        $this->importHandler = $importHandler;
        $this->fileSystemService = $fileSystemService;
    }

    public function execute(): Redirect
    {
        $csvFile = $this->request->getFiles('import_csv_file');

        if (!$this->request->isPost() || !$csvFile) {
            $this->messageManager->addErrorMessage('Invalid file upload attempt.');
        }

        try {
            $this->fileSystemService->copyCsvToVarDirectory($csvFile);

            $this->importHandler->importFromCsvFile($csvFile['tmp_name']);

            $this->messageManager->addSuccessMessage('Updated products successfully.');
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage('Unable to import products: ' . $e->getMessage());
        }

        $redirect = $this->redirectFactory->create();
        return $redirect->setPath('index/import/index');
    }
}

