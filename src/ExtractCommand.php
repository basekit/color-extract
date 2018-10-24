<?php
namespace Robjmills\ColorExtract;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;


class ExtractCommand extends Command
{
    protected function configure()
    {
        $this->setName("yml")
            ->setDescription("CLI for adding dominant image color to YML file of content set images")
            ->addArgument('file', InputArgument::REQUIRED, 'What is the path of the YML file)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');

        $contents = file_get_contents(__DIR__ . '/../' . $file);
        $contentSets = Yaml::parse($contents);

        $log = new Logger('image:store');
        $log->pushHandler(new StreamHandler('/log.txt'));

        $extractor = new Extract($log);
        foreach($contentSets as $contentSetKey => $contentSetValue) {
            $i = 1;
            foreach ($contentSetValue as $image) {
                $dominantColor = $extractor->extract($image['url']);
                $output->writeln('Dominant color for '.$image['url'].' is '.$dominantColor);
                $contentSets[$contentSetKey][$i]['dominantColor'] = $dominantColor;
                $i++;
            }
        }
        file_put_contents(__DIR__ . '/../' . 'image_sets_modified.yml', Yaml::dump($contentSets, 5));
    }
}