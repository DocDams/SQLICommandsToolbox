<?php

namespace SQLI\CommandsToolboxBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanRedisCacheCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName( 'sqli:clear_redis_cache' )
            ->setDescription( 'Clear Redis persistence cache' );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        // getting the cache service in php

        /** @var $cacheService TagAwareAdapter */
        $cacheService = $this->getContainer()->get( 'ezpublish.cache_pool' );

        // To clear all cache
        $cacheService->clear();

        // To clear a specific cache item (check source code in eZ\Publish\Core\Persistence\Cache\*Handlers for further info)
        //$cacheService->clear('content', 'info', $contentId);

        // Stash cache is hierarchical, so you can clear all content/info cache like so:
        //$cacheService->clear('content', 'info');
    }
}
