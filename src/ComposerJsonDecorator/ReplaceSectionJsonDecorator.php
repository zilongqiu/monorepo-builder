<?php

declare(strict_types=1);

namespace Symplify\MonorepoBuilder\ComposerJsonDecorator;

use Symplify\MonorepoBuilder\ComposerJsonObject\ValueObject\ComposerJson;
use Symplify\MonorepoBuilder\Configuration\MergedPackagesCollector;
use Symplify\MonorepoBuilder\Contract\ComposerJsonDecoratorInterface;

final class ReplaceSectionJsonDecorator implements ComposerJsonDecoratorInterface
{
    /**
     * @var MergedPackagesCollector
     */
    private $mergedPackagesCollector;

    public function __construct(MergedPackagesCollector $mergedPackagesCollector)
    {
        $this->mergedPackagesCollector = $mergedPackagesCollector;
    }

    public function decorate(ComposerJson $composerJson): void
    {
        $mergedPackages = $this->mergedPackagesCollector->getPackages();

        foreach ($mergedPackages as $mergedPackage) {
            // prevent value override
            if ($composerJson->isReplacePackageSet($mergedPackage)) {
                continue;
            }

            $composerJson->setReplacePackage($mergedPackage, 'self.version');
        }
    }
}
