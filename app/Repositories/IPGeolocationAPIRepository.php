<?php namespace App\Repositories;

/**
 * For more information visit http://ip-api.com/docs/api:json
 * Class IPGeolocationAPIRepository
 * @package App\Repositories
 */
class IPGeolocationAPIRepository extends AbstractAPIRepository {

    private $location;

    function __construct()
    {
        $this->url = 'http://ip-api.com/json/';
    }

    /**
     * @param $user_ip
     */
    public function getIpGeolocation($user_ip)
    {
        if (is_null($user_ip) || $user_ip === "")
        {
            throw new \HttpRequestException('no ip provided');
        }

        $this->location = $this->sendRequest($this->url . $user_ip);
    }

    /**
     * Possible keys = [ 'as','city','country','countryCode',
     *                   'isp','lat','lon','org','query','region',
     *                   'regionName','status','timezone','zip'
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->location[$key];
    }

}