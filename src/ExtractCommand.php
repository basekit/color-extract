<?php
namespace ColorExtract;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExtractCommand extends Command
{
    protected function configure()
    {
        $this->setName("extract")
            ->addArgument('file', InputArgument::REQUIRED, 'What is the path of the image?)')
            ->setDescription("CLI for getting dominant image color of single remote file");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        if (($contents = @file_get_contents($file)) === false) {
            $output->writeln('<error>'. $file . ' could not be found</error>');
            return;
        }
        $extractor = new ColorExtract();
        $dominantColor = $extractor->extract($file);
        $output->writeln('<info>Dominant color: '. $dominantColor.'</info>');
    }
}