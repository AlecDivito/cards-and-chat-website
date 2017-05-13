<?php namespace App\Repositories;

/**
 * For more information visit https://openweathermap.org/api
 * Class WeatherAPIRepository
 * @package App\Repositories
 */
class WeatherAPIRepository extends AbstractAPIRepository {

    /*
     * Possible $options names and values:
     * q={city name}
     * q={city name},{country code}
     * id={city id}
     * lat={lat}&lon={lon}
     * zip={zip code} // assumed zip is in the states
     * zip={zip code},{country code}
     * units={units} // Fahrenheit = imperial, Celsius = metric
     */

    protected $key;

    function __construct($key)
    {
        $this->key = $key;
        $this->url = 'http://api.openweathermap.org/data/2.5';
    }

    public function getWeather($options = [])
    {
        return $this->sendRequest("{$this->url}/weather", $this->validateOptions($options));
    }

    public function getForcast($options = [])
    {
        return $this->sendRequest("{$this->url}/forecast", $this->validateOptions($options));
    }

    public function getDailyForcast($options = [])
    {
        return $this->sendRequest("{$this->url}/forecast/daily", $this->validateOptions($options));
    }

    private function validateOptions($options)
    {
        $options['appid'] = $this->key;

        if ( ! array_key_exists('q', $options))
        {
            // no city was given, therefore we must use the users ip to find his current location
            $ipGeoLocation = new IPGeolocationAPIRepository();
            $ipGeoLocation->getIpGeolocation($options['ip']);
            $options['lon'] = $ipGeoLocation->get('lon');
            $options['lat'] = $ipGeoLocation->get('lat');
            if ($ipGeoLocation->get('country') === 'United States')
            {
                $options['units'] = 'imperial';
            }
            else
            {
                $options['units'] = 'metric';
            }
        }
        else
        {   // default units are metric
            $options['units'] = 'metric';
        }

        return $options;
    }

}