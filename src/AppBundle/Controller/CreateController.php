<?php

namespace AppBundle\Controller;

use AppBundle\Helper\CollectorComponentAPI;
use Faker\Factory;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateController
 * @package AppBundle\Controller
 */
class CreateController extends Controller
{

    public function testAction()
    {
        header('Content-Type: application/json');
        $collector = new CollectorComponentAPI();
        print_r($collector->createEvent());
        print_r("============================== EVENT CREATED, NEXT CONNECTIONS \n");
        print_r($collector->createConnection());
        print_r("============================== CONNECTION CREATED, NEXT POSITIONS \n");
        print_r($collector->createPosition());
        print_r("============================== POSITIONS CREATED, NEXT MONITORING \n");
        print_r($collector->createMonitoring());

        die('==== done');
    }

    /**
     * /create?type={events,monitoring,locations,locations}
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $type = $request->get('type');
        if(!isset($type)){
            die('No type given');
        }

        $client = new Client([
            'defaults' => [
                'headers' => ['Authorization' => 'Token 90f44a24a6bd93a8ca9c21d0b9e0d81d5ab20da2']
            ]
        ]);

        switch ($type) {
            case 'all':
                $result[] = array(
                    'event' => $this->createEvent($client),
                    'position' => $this->createPosition($client),
                    'monitoring' => $this->createMonitoring($client),
                    'connection' => $this->createConnection($client)
                );
                break;
            case 'event':
                $result = $this->createEvent($client);
                break;
            case 'connection':
                $result = $this->createConnection($client);
                break;
            case 'monitoring':
                $result = $this->createMonitoring($client);
                break;
            case 'position':
                $result = $this->createPosition($client);
                break;
            default:
                echo 'possible values for type = [event, connection, monitoring, location]';
        }

        $this->backButton();
        echo '<pre>';
        print_r($result->read(10));
        print_r($result->getStatusCode());
        die('Done');
    }


    /**
     * Creates a Event entry
     * at http://149.210.236.249:8000/events
     *
     * @param null $client
     * @return mixed
     */
    protected function createEvent($client = null)
    {
        $faker = Factory::create();
        $event = array(
            "port" => $faker->randomElement(array("Ignition", "PowerStatus")),
            "value" => $faker->boolean(),
            "unitId" => $faker->randomElement(array( '14100015', '14100015', '15030000', '14120032','14120031','14120029','14120026')),
            "dateTime" => $faker->date('Y-m-d', $max = 'now')
        );

        return $client->post('http://149.210.236.249:8000/events', [ 'body' => $event ]);
    }

    /**
     * Creates a Connection event
     * at http://149.210.236.249:8000/connection
     *
     * @param null $client
     * @return mixed
     */
    protected function createConnection($client = null)
    {
        $faker = Factory::create();
        $connection = array(
            "port" => $faker->randomDigitNotNull,
            "value" => $faker->boolean(90),
            "dateTime" => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
        );

        $response = $client->post('http://149.210.236.249:8000/connections', [ 'body' => $connection ]);

        return $response;
    }

    /**
     * Creates a Monitoring entry at http://149.210.236.249:8000/monitoring
     *
     * @param null $client
     * @return mixed
     */
    protected function createMonitoring($client = null)
    {
        $faker = Factory::create();
        $monitoring = array(
            "beginTime" => $faker->dateTimeBetween('-1 month', '2017-01-01')->format('Y-m-d'),
            "endTime"   => $faker->dateTimeBetween('-1 month', '2017-01-01')->format('Y-m-d'),
            "unitId"    => $faker->randomElement(array( '14100015', '14100015', '15030000', '14120032','14120031','14120029','14120026')),
            "type"      => $faker->randomElement($this->getTypeForConnection()),
            "min"       => $faker->randomFloat(),
            "max"       => $faker->randomFloat(),
            "sum"       => $faker->randomFloat()
        );

        return $client->post('http://149.210.236.249:8000/monitoring', [ 'body' => $monitoring ]);
    }

    /**
     * Creates a Position entry at http://149.210.236.249:8000/positions
     *
     * @param null $client
     * @return mixed
     */
    protected function createPosition($client = null)
    {
        $faker = Factory::create();
        $position = array(
            "unitId" => $faker->randomElement(array( '14100015', '14100015', '15030000', '14120032','14120031','14120029','14120026')),
            "rDx" => $faker->randomFloat(),
            "rDy" => $faker->randomFloat(),
            "speed" => $faker->randomFloat(),
            "course" => $faker->randomFloat(),
            "numSattellites" => $faker->randomNumber(),
            "hdop" => $faker->randomDigit,
            "quality" => "Gps",
            "dateTime" => $faker->dateTimeBetween('-1 month', '2017-01-01')->format('Y-m-d')
        );

        return $client->post('http://149.210.236.249:8000/positions', [ 'body' => $position ]);
    }



    /**
     * Datastream urls
     *
     * @return string
     */
    private function getRootUrls()
    {
        $result = $this->client->get('http://149.210.236.249:8000/?format=json');
        $root = $result->getBody()->getContents();

        return $root;
    }

    private function getTypeForConnection()
    {
        return array('Gps/GpsAccuracyGyroBias', 'Hsdpa/SQual', 'SystemInfo/ManagedMemoryUsage', 'SystemInfo/AvailableDiskSpace', 'Gps/GpsGyroMean', 'Gps/GpsTemperature', 'Hsdpa/NumberOfConnects', 'Hsdpa/RSSI', 'Gps/NumberOfSatellitesTracked', 'Gps/Speed', 'SystemInfo/AvailableMemory', 'Gps/GpsAccuracyGyroScale', 'SystemInfo/MemoryLoad', 'Hsdpa/RSCP', 'Gps/GpsPulseScale', 'SystemInfo/ProcessorUsage', 'Hsdpa/SRxLev', 'Gps/GpsGyroBias', 'MessageStack/MessageCount');
    }

    private function backButton()
    {
        echo '
        <button onclick="goBack()">Go Back</button>
        <script>
        function goBack() {
            window.history.back();
        }
        </script>
        <br />
        <br />
        ';
    }

}
