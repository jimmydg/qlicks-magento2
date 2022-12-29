<?php

declare(strict_types=1);

namespace Jimmy\CsvImport\Services;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;

class FileSystemService
{
    private File $filesystem;

    private DirectoryList $directoryList;

    public function __construct(
        File $filesystem,
        DirectoryList $directoryList,
    ) {
        $this->filesystem = $filesystem;
        $this->directoryList = $directoryList;
    }

    /**
     * @throws LocalizedException
     * @throws FileSystemException
     */
    public function copyCsvToVarDirectory(array $csvFile): void
    {
        $date = date('Y-m-d_H:i:s');
        $fileName = $csvFile['name'];

        $this->filesystem->cp(
            $csvFile['tmp_name'],
            $this->generateVarPath() . "$date-$fileName"
        );
    }

    /**
     * @throws LocalizedException
     * @throws FileSystemException
     */
    private function generateVarPath(): string
    {
        $destination = $this->directoryList->getPath('var') . "/importexport/";

        if ($this->filesystem->isWriteable($destination)) {
            return $destination;
        }

        if ($this->filesystem->mkdir($destination)) {
            return $destination;
        }

        throw new LocalizedException(__('Could not create importexport folder.'));
    }
}
