<?php

namespace Wealthbot\FixturesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wealthbot\AdminBundle\Entity\Security;

class LoadSecurityDataCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('wealthbot:fixtures:security')
            ->setDescription('Load security data form CSV.')
            ->setHelp('');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        $securityRepo = $em->getRepository('WealthbotAdminBundle:Security');
        $securityTypeRepo = $em->getRepository('WealthbotAdminBundle:SecurityType');

        $i = 0;
        $typeHash = array();

        $securities = $this->loadCsvData('security_full.csv', $maxLength = 10000, $delimiter = ',');
        foreach ($securities as $index => $item) {
            if ($index === 0) continue;

            $type   = trim($item[0]);
            $type   = $type === 'ETF' ? 'EQ' : 'MU';
            $symbol = trim($item[1]);
            $name   = trim($item[2]);
            $ratio  = round((float) str_replace(',', '.', trim($item[3])), 2);

            if (isset($typeHash[$type])) {
                $securityType = $typeHash[$type];
            } else {
                $securityType = $securityTypeRepo->findOneByName($type);
                if ($securityType) {
                    $typeHash[$type] = $securityType;
                }
            }

            $security = $securityRepo->findOneBySymbol($symbol);
            if (!$security && $securityType) {
                $security = new Security();
                $security->setName($name);
                $security->setSymbol($symbol);
                $security->setSecurityType($securityType);
                $security->setExpenseRatio($ratio);
                $em->persist($security);

                if ((++$i % 100) == 0) {
                    $em->flush();
                    $output->writeln("Security items [{$i}] has been loaded.");
                }
            }
        }

        $em->flush();
        $output->writeln("Security items [{$i}] has been loaded.");
        $output->writeln("Success!");
    }

    protected function loadCsvData($filename, $maxLength = 1000, $delimiter = ';')
    {
        $data   = array();
        $path   = __DIR__ . '/../DataFixtures/CSV/' . $filename;
        $handle = fopen($path, 'r');

        if (false !== $handle) {
            while ($item = fgetcsv($handle, $maxLength, $delimiter)) {
                $data[] = $item;
            }
            fclose($handle);
        }

        return $data;
    }
}
