<?php

namespace AppBundle\Command;

use AppBundle\Controller\CreateController;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('citygis:fake')
            ->setDescription('Fakes citygis data and pushes it to server 1 [149.210.236.249:8000] ');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Starting creating resources at 149.210.236.249:8000");
        $output->writeln("===================================================");

        $output->writeln($response);
    }
}
