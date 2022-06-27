<?php

namespace T3Dev\Cfajob\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Core\Environment;
use T3Dev\Cfajob\Utility\FileUtility;

/**
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * Class clean unused files
 *
 */
class CleanUnusedFilesCommand extends AbstractCommand
{

    /**
     * Configure the command by defining the name, options and arguments
     */
    public function configure()
    {
        $this->setDescription('Delete unused files from fileadmin');
        $this->setHelp('Delete unused files from fileadmin');
        $this->addArgument(
            'period',
            InputArgument::REQUIRED,
            'Define how old the files could be (in seconds) that should be deleted (0 = delete all)'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FileRepository $resourceFactory */
        $resourceFactory = ResourceFactory::getInstance();
        $defaultStorage = $resourceFactory->getDefaultStorage();
        $folder = $defaultStorage->getFolder('tx_cfajob/students/');
        $files = $defaultStorage->getFilesInFolder($folder);

        foreach ($files as $file) {
            if ($file->getProperties()['missing'] == '1') {
                $directory = 'fileadmin/tx_cfajob/students/';
                $this->removeFilesFromRelativeDirectory($output, $directory, (int)$input->getArgument('period'));
            }
        }

        //$file = $resourceFactory->getFileReferenceObject('');
        //$directory = 'fileadmin/tx_cfajob/students/';
        //$this->removeFilesFromRelativeDirectory($output, $directory, (int)$input->getArgument('period'));
        //$directory = GeneralUtility::getFileAbsFileName('fileadmin/tx_cfajob/students/');
        //$files = GeneralUtility::getFilesInDir($directory, '', true);
        //$this->removeFilesFromRelativeDirectory($output, 'tx_cfajob/students/', (int)$input->getArgument('period'));

        return 0; // everything fine
    }
}
