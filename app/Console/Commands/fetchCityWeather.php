<?php

namespace App\Console\Commands;

use Exception;
use App\Models\City;
use GuzzleHttp\Client;
use App\Models\CityWeather;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class fetchCityWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchCityWeather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will fetch city weather from openweatherapi and store it to city_weather table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::channel('fetchCityWeatherLog')->info("fetchCityWeather handle ---> about to fetch city weather data");
        
        $apiKey = City::OEPNWEATHERMAP_API_KEY;
        $unitCelsius = true;

        $cities = City::query()
        ->where('fetch_weather_data', City::FLAG_FETCH_WEATHER_DATA_YES)
        ->where('status', City::STATUS_ACTIVE)->get();

        $count = count($cities);
        Log::channel('fetchCityWeatherLog')->info("city counts:$count");

        foreach ($cities as $key => $city) {
            $cityName = $city->name;
            $cityId = $city->id;

            $tempQuery = $unitCelsius?"&units=metric":"&units=imperial";
            $apiURL = "http://api.openweathermap.org/data/2.5/weather?q=".urlencode($cityName).",NZ&appid=$apiKey$tempQuery";

            try{
                $client = new Client();
                $clientResponse = $client->get($apiURL);
                $status = $clientResponse->getStatusCode();

                if($status==200){
                    $dataJson = $clientResponse->getBody();
                    $data = json_decode($clientResponse->getBody());
    
                    $iconName = $data->weather[0]->icon;
                    $iconURL = "https://openweathermap.org/img/wn/$iconName@2x.png";
                    $temprature = $data->main->temp;
                    $phrase = $unitCelsius?"°C":"°F";
                    $tempraturePhrase = $temprature.$phrase;
                    $cityNameOpen = $cityName;//$data->name;  
    
                    $city = CityWeather::updateOrCreate(
                        ['city_id' => $cityId],
                        ['city_id' => $cityId,'city_name' => $cityNameOpen,
                        'temprature' => $temprature,'temprature_phrase' => $tempraturePhrase,
                        'unit' => $unitCelsius,'icon_url' => $iconURL]
                    );
                    Log::channel('fetchCityWeatherLog')->info("city: $city");
                }
                else{
                    $reason = $clientResponse->getReasonPhrase();
                }
            }
            catch(\GuzzleHttp\Exception\RequestException $e){
                if($e->hasResponse()){
                    if ($e->getResponse()->getStatusCode() == '404'){
                        Log::channel('fetchCityWeatherLog')->error("cityName:$cityName cityId:$cityId Exception:".$e->getResponse()->getBody());
                    }
                }
            }
            catch(Exception $e){                
                Log::channel('fetchCityWeatherLog')->error("Exception: ".$e->getMessage());
            }
            // sleep(1);
        }//foreach
    }
}
