<?php
/**
 * Created by PhpStorm.
 * User: nav
 * Date: 03-01-16
 * Time: 18:38
 */

namespace AppBundle\Helper;


use Faker\Factory;
use GuzzleHttp\Client;

class CollectorComponentAPI
{
    private $client;
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->client = new Client([
            'defaults' => [
                'headers' => ['Authorization' => 'Token 90f44a24a6bd93a8ca9c21d0b9e0d81d5ab20da2']
            ]
        ]);
    }

    public function createEvent()
    {
        $event = array(
            "port" => $this->faker->randomElement(array("Ignition", "PowerStatus")),
            "value" => $this->faker->randomElement(array('1','0')),
            "unitId" => $this->faker->randomElement(array(
                '14100015', '14100015', '15030000', '14120032','14120031','14120029','14120026'
            )),
            "dateTime" => $this->faker->date('Y-m-d', $max = 'now')
        );
        // Nav Appaiya 3 Januari 2015
        // dump($event); // Nice symfony dumping in profiler

        return $this->client->post('http://149.210.236.249:8000/events', [ 'body' => $event ])->json();
    }

    public function createConnection()
    {
        $connection = array(
            "port" => $this->faker->randomDigitNotNull,
            "value" => $this->faker->randomElement(array('1','0')),
            "dateTime" => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            "permissions" => $this->faker->randomElements(array(
                "add_logentry",
                "change_logentry",
                "delete_logentry",
                "add_connection",
                "change_connection",
                "delete_connection",
                "add_event",
                "change_event",
                "delete_event",
                "add_monitoring",
                "change_monitoring",
                "delete_monitoring",
                "add_position",
                "change_position",
                "delete_position",
                "add_group",
                "change_group",
                "delete_group",
                "add_permission",
                "change_permission",
                "delete_permission",
                "add_token",
                "change_token",
                "delete_token",
                "add_contenttype",
                "change_contenttype",
                "delete_contenttype",
                "add_session",
                "change_session",
                "delete_session",
                "add_site",
                "change_site",
                "delete_site",
                "add_user",
                "change_user",
                "delete_user"
            ),3)
        );

        return $this->client->post('http://149.210.236.249:8000/connections', ['body'=>$connection])->json();
    }

    public function createPosition()
    {
        $position = array(
            "unitId" => $this->faker->randomElement(array( '14100015', '14100015', '15030000', '14120032','14120031','14120029','14120026')),
            "rDx" => $this->faker->randomFloat(),
            "rDy" => $this->faker->randomFloat(),
            "speed" => $this->faker->randomFloat(),
            "course" => $this->faker->randomFloat(),
            "numSattellites" => $this->faker->randomNumber(),
            "hdop" => $this->faker->randomDigit,
            "quality" => "Gps",
            "dateTime" => $this->faker->dateTimeBetween('-1 month', '2017-01-01')->format('Y-m-d')
        );

        return $this->client->post('http://149.210.236.249:8000/positions', ['body'=>$position])->json();
    }

    public function createMonitoring()
    {
        $monitoring = array(
            "beginTime" => $this->faker->dateTimeBetween('-1 month', '2017-01-01')->format('Y-m-d'),
            "endTime"   => $this->faker->dateTimeBetween('-1 month', '2017-01-01')->format('Y-m-d'),
            "unitId"    => $this->faker->randomElement(array( '14100015', '14100015', '15030000', '14120032','14120031','14120029','14120026')),
            "type"      => $this->faker->randomElement(array('Gps/GpsAccuracyGyroBias', 'Hsdpa/SQual', 'SystemInfo/ManagedMemoryUsage', 'SystemInfo/AvailableDiskSpace', 'Gps/GpsGyroMean', 'Gps/GpsTemperature', 'Hsdpa/NumberOfConnects', 'Hsdpa/RSSI', 'Gps/NumberOfSatellitesTracked', 'Gps/Speed', 'SystemInfo/AvailableMemory', 'Gps/GpsAccuracyGyroScale', 'SystemInfo/MemoryLoad', 'Hsdpa/RSCP', 'Gps/GpsPulseScale', 'SystemInfo/ProcessorUsage', 'Hsdpa/SRxLev', 'Gps/GpsGyroBias', 'MessageStack/MessageCount')),
            "min"       => $this->faker->randomFloat(),
            "max"       => $this->faker->randomFloat(),
            "sum"       => $this->faker->randomFloat()
        );

        return $this->client->post('http://149.210.236.249:8000/monitoring', ['body'=>$monitoring])->json();
    }
}