<?php
//declare(strict_types=1);

namespace T3Dev\Cfajob\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class AbstractImportCommand
 */
abstract class AbstractCommand extends Command
{

    /**
     * @param OutputInterface $output
     * @param string $directory
     * @param int $period
     * @return void
     */
    protected function removeFilesFromRelativeDirectory(
        OutputInterface $output,
        string $directory,
        int $period
    ): void {
        $files = GeneralUtility::getFilesInDir(GeneralUtility::getFileAbsFileName($directory), '', true);
        $counter = 0;
        foreach ($files as $file) {
            if ($period === 0 || ($period > 0 && (time() - filemtime($file) > $period))) {
                $counter++;
                unlink($file);
            }
        }
        $output->writeln($counter . ' files removed from your system');
    }
}
