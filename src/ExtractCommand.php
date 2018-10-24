<?php
namespace Robjmills\ColorExtract;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;


class ExtractCommand extends Command
{
    protected function configure()
    {
        $this->setName("yml")
            ->setDescription("CLI for adding dominant image color to YML file of content set images");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = __DIR__ . '/../image_sets.yml';
        if (($contents = @file_get_contents($filePath)) === false) {
            $output->writeln("Expected file " . $filePath . " was missing");
            return;
        }
        $contentSets = Yaml::parse($contents);

        $extractor = new ColorExtract();
        foreach ($contentSets as $contentSetKey => $contentSetValue) {
            $i = 1;
            foreach ($contentSetValue as $image) {
                $dominantColor = $extractor->extract($image['url']);
                $output->writeln('Dominant color for ' . $image['url'] . ' is ' . $dominantColor);
                $contentSets[$contentSetKey][$i]['dominantColor'] = $dominantColor;
                $i++;
            }
        }
        file_put_contents(__DIR__ . '/../' . 'image_sets_modified.yml', Yaml::dump($contentSets, 5));
    }
}