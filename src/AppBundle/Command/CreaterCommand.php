<?php
/**
 * Created by PhpStorm.
 * User: nav
 * Date: 03-01-16
 * Time: 14:59
 */

namespace AppBundle\Command;


use AppBundle\Entity\Events;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreaterCommand  extends ContainerAwareCommand
{
    protected function configure()
    {
        // This command is going to create events, monitoring, connections and locations 
        // for us at my own api on 149.210.236.249:8000
        $this
            ->setName("create:stuff")
            ->setDescription("Geneer een aantal events");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("TE~SGT");
    }


}