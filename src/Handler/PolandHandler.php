<?php

namespace App\Handler;

use App\Entity\StatsEntry;
use App\Entity\StatsSet;
use App\Entity\StatsSource;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;

class PolandHandler
{
    /** @var StatsSource */
    protected $source;

    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(StatsSource $source, EntityManagerInterface $em)
    {
        $this->source = $source;
        $this->em = $em;
    }

    public function handle()
    {
        $html = file_get_contents($this->source->getSource());

        $startString = '<pre id="registerData" class="hide">';
        $endString = '</pre';
        $dataStart = stripos($html, $startString);
        $startPos = $dataStart + strlen($startString);
        $endPos = stripos($html, $endString, $startPos);

        $data = substr($html, $startPos, $endPos - $startPos);
        $dataJson = json_decode($data, true);
        preg_match('/(([1-9]|[0-2]\d|[3][0-1])\.([1-9]|[0]\d|[1][0-2])\.[2][0]\d{2})$|(([1-9]|[0-2]\d|[3][0-1])\.([1-9]|[0]\d|[1][0-2])\.[2][0]\d{2}\s([1-9]|[0-1]\d|[2][0-3])\:[0-5]\d)$/i', $dataJson['description'], $matches);

        $dateString = $matches[0];
        $covidStats = json_decode($dataJson['parsedData'], true);
        $tz = new DateTimeZone("Europe/Warsaw");
        $date = new DateTime($dateString, $tz);
        $count = 0;
        $source = $this->source;
        /** @var StatsSet */
        if (!$lastEntry = $source->getStatsSets()->first()) {
            $statsSet = new StatsSet();
            $statsSet->setSource($source);
            $statsSet->setLastUpdate($date);

            foreach ($covidStats as $covidStat) {
                $stat = new StatsEntry();
                $stat->setStatsSet($statsSet);
                $stat->setCode($this->canonical($covidStat['Województwo']));
                $stat->setName($covidStat["Województwo"]);
                $stat->setDeaths(intval($covidStat["Liczba zgonów"]));
                $stat->setDeathsDelta(0);
                $stat->setDeathsYesterday(0);
                $stat->setConfirmed(intval($covidStat["Liczba"]));
                $stat->setConfirmedDelta(0);
                $stat->setConfirmedYesterday(0);
                $count++;
                $this->em->persist($stat);
            }

            $this->em->persist($statsSet);
        } elseif ($lastEntry->getLastUpdate() < $date) {
            var_dump($lastEntry->getLastUpdate()->format(DATE_RFC3339_EXTENDED));
            var_dump($date->format(DATE_RFC3339_EXTENDED));
            $statsSet = new StatsSet();
            $statsSet->setSource($source);
            $statsSet->setLastUpdate($date);

            $prevDayEntry = null;
            while ($source->getStatsSets()->next()) {
                /** @var StatsSet */
                $candidate = $source->getStatsSets()->current();
                if ($candidate->getLastUpdate()->format('d') !== $date->format('d')) {
                    var_dump('using ' . $candidate->getLastUpdate()->format(DATE_RFC3339_EXTENDED));
                    $prevDayEntry = $candidate;
                    break;
                }
            }

            foreach ($covidStats as $covidStat) {
                $code = $this->canonical($covidStat['Województwo']);
                $lastEntryStat = $lastEntry->getStatsEntries()[$code];
                $stat = new StatsEntry();
                $stat->setStatsSet($statsSet);
                $stat->setCode($code);
                $stat->setName($covidStat["Województwo"]);
                $stat->setDeaths(intval($covidStat["Liczba zgonów"]));
                $stat->setDeathsDelta(($lastEntryStat ? $stat->getDeaths() - $lastEntryStat->getDeaths() : 0));
                $stat->setConfirmed(intval($covidStat["Liczba"]));
                $stat->setConfirmedDelta(($lastEntryStat ? $stat->getConfirmed() - $lastEntryStat->getConfirmed() : 0));

                $stat->setDeathsYesterday(0);
                $stat->setConfirmedYesterday(0);

                if ($prevDayEntry) {
                    if ($prevDayStat = $prevDayEntry->getStatsEntries()[$code]) {
                        $stat->setDeathsYesterday($stat->getDeaths() - $prevDayStat->getDeaths());
                        $stat->setConfirmedYesterday($stat->getConfirmed() - $prevDayStat->getConfirmed());
                    }
                }

                $count++;
                $this->em->persist($stat);
            }

            $this->em->persist($statsSet);
        }
        $this->em->flush();

        return $count;
    }

    protected function canonical(string $string)
    {
        return crc32($string);
    }
}
