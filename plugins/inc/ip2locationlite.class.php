<?php

/**
 * Class ip2location_lite
 */
final class ip2location_lite
{
    protected $errors  = [];
    protected $service = 'api.ipinfodb.com';
    protected $version = 'v3';
    protected $apiKey  = '';

    /**
     * ip2location_lite constructor.
     */
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param $key
     */
    public function setKey($key)
    {
        if (!empty($key)) {
            $this->apiKey = $key;
        }
    }

    /**
     * @return string
     */
    public function getError()
    {
        return implode("\n", $this->errors);
    }

    /**
     * @param $host
     */
    public function getCountry($host)
    {
        return $this->getResult($host, 'ip-country');
    }

    /**
     * @param $host
     */
    public function getCity($host)
    {
        return $this->getResult($host, 'ip-city');
    }

    /**
     * @param $host
     * @param $name
     */
    private function getResult($host, $name)
    {
        $ip = @gethostbyname($host);

        if (preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)) {
            $xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');

            try {
                $response = @new SimpleXMLElement($xml);

                foreach ($response as $field => $value) {
                    $result[(string)$field] = (string)$value;
                }

                return $result;
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
                return;
            }
        }

        $this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
        return;
    }
}
