<?php

namespace AppBundle\Service;

class FlightInfo
{
    /**
     * @var string
     */
    private $unit;

    /**
     * @var string
     */
    private $timeunit;

    /**
     * Constructor
     *
     * @param string $unit Defined in config.yml
     *
     */
    public function __construct($unit, $timeunit)
    {
        $this->unit = $unit;
        $this->timeunit = $timeunit;
    }


    /**
     * Distance calculation between latitude/longitude based on Harnive's formula
     * http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
     *
     * @param float $latitudeFrom  Departure
     * @param float $longitudeFrom Departure
     * @param float $latitudeTo    Arrival
     * @param float $longitudeTo   Arrival
     *
     * @return float
     */
    public function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $d = 0;
        $earth_radius = 6371;
        $dLat = deg2rad($latitudeTo - $latitudeFrom);
        $dLon = deg2rad($longitudeTo - $longitudeFrom);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));

        switch ($this->unit) {
            case 'km':
                $d = $c * $earth_radius;
                break;
            case 'mi':
                $d = $c * $earth_radius / 1.609344;
                break;
            case 'nmi':
                $d = $c * $earth_radius / 1.852;
                break;
        }

        return $d;
    }

    /**
     * time calculation between two site
     * http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe#PHP
     *
     * @param float $cruiseSpeed PlaneModel
     * @param float $distance
     *
     *
     * @return float
     */
    public function getTime($cruiseSpeed, $distance)
    {


        switch ($this->timeunit) {
            case 'h':
                $time = ($distance * 1) / $cruiseSpeed;
                break;
            case 'min':
                $time = ($distance * 60) / $cruiseSpeed;
                break;
            case 'sec':
                $time = ($distance * 3600) / $cruiseSpeed;
                break;
        }

        return $time;
    }
}