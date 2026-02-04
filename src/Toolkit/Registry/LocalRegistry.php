<?php

namespace App\Toolkit\Registry;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\UX\Toolkit\Kit\Kit;
use Symfony\UX\Toolkit\Kit\KitFactory;
use Symfony\UX\Toolkit\Registry\LocalRegistry as BaseLocalRegistry;
use Symfony\UX\Toolkit\Registry\RegistryInterface;

#[AsDecorator('.ux_toolkit.registry.local')]
final class LocalRegistry implements RegistryInterface
{
    public function __construct(
        #[AutowireDecorated]
        private readonly RegistryInterface $inner,
        #[Autowire(service: '.ux_toolkit.kit.kit_factory')]
        private readonly KitFactory $kitFactory,
        private readonly Filesystem $filesystem,
        #[Autowire('%kernel.project_dir%/kits')]
        private readonly string $localKitsDir,
    ) {
    }

    public static function supports(string $kitName): bool
    {
        return BaseLocalRegistry::supports($kitName);
    }

    public function getKit(string $kitName): Kit
    {
        $kitDir = Path::join($this->localKitsDir, $kitName);
        if ($this->filesystem->exists($kitDir)) {
            return $this->kitFactory->createKitFromAbsolutePath($kitDir);
        }

        return $this->inner->getKit($kitName);
    }
}
