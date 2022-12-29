<?php

declare(strict_types=1);

namespace Jimmy\CsvImport\Model;

use Exception;
use Magento\Catalog\Api\Data\ProductLinkInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\File\Csv;

class CsvImportHandler
{
    private Csv $csvProcessor;

    private ProductRepositoryInterface $productRepository;

    private ProductLinkInterfaceFactory $productLink;

    public function __construct(
        Csv $csvProcessor,
        ProductRepositoryInterface $productRepository,
        ProductLinkInterfaceFactory $productLink,
    ) {
        $this->csvProcessor = $csvProcessor;
        $this->productRepository = $productRepository;
        $this->productLink = $productLink;
    }

    /**
     * @throws Exception
     */
    public function importFromCsvFile(string $filePath): void
    {
        $rawData = $this->csvProcessor->getData($filePath);

        foreach ($rawData as $key => $val) {
            // The first row includes header data
            if ($key === 0) {
                continue;
            }

            $parentSku = $val[0];

            $csvProductLinks = [
                'upsell' => $val[1],
                'crosssell' => $val[2],
                'related' => $val[3],
            ];

            /** @var Product $magentoProduct */
            $magentoProduct = $this->productRepository->get($parentSku);

            $magentoProduct->setProductLinks(
                $this->getProductLinks($csvProductLinks, $parentSku)
            );

            $this->productRepository->save($magentoProduct);
        }
    }

    private function getProductLinks(array $csvProductLinks, string $parentSku): array
    {
        $productLinkPayload = [];

        foreach ($csvProductLinks as $linkType => $productSku) {
            $productLinkPayload[] = ($this->productLink->create())
                ->setSku($parentSku)
                ->setLinkedProductSku($productSku)
                ->setLinkType($linkType);
        }

        return $productLinkPayload;
    }
}
