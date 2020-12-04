<?php


namespace App\Api\V1\Services;

use App\Advert;
use App\Car;
use App\DownloadRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Auth;
class FileZipperService
{

    protected $smsSender;
    public function __construct(SMSSenderService $SMSSenderService)
    {
        $this->smsSender = $SMSSenderService;
    }


    public function startZipping(){
        $downloadRequest = DownloadRequest::where('status','=','new_request')->get();
        $public_path = public_path();

      foreach ($downloadRequest as $requests){
          $user = User::find($requests['user_id']);
          if(is_dir($public_path.'/Zips')==false){
              mkdir($public_path.'/Zips');
              mkdir($public_path.'/Zips/files');
          }

          //check if drivers cars and downloader  have  set their address
          if(count($user->place)>0){

              //first time downloader for drivers and for all downloader
              if ($requests['downloadedAdverts']==null){
                  $adverts = DB::table('advert_place')->whereIn('place_id',[1,$user->place[0]['id']])->join('adverts',function ($join){
                      $join->on('advert_place.advert_id','=','adverts.id');
                  })->where('adverts.status','on_advert')->select('adverts.product_name','adverts.file_name','adverts.id')->get();
                  return $this->prepareFile($user,$public_path,$adverts,$requests['id'],$requests['device_id']);
              }else{
                  //if drivers have downloaded adverts before and if they need new adverts
                  $downloadedAdverts = json_decode($requests['downloadedAdverts']);
                  $adverts = DB::table('advert_place')->whereIn('place_id',[1,$user->place[0]['id']])->join('adverts',function ($join){
                      $join->on('advert_place.advert_id','=','adverts.id');
                  })->where('adverts.status','on_advert')
                      ->whereNotIn('id',$downloadedAdverts)->select('adverts.product_name','adverts.file_name','adverts.id')->get();

                  if(count($adverts)<=0){
                      return response()->json(['status'=>false,'message'=>'No new advert is registered until now']);
                  }else{
                      return $this->prepareFile($user,$public_path,$adverts,$requests['id']);
                  }

              }

          }else{
              echo 'No place';
              //return response()->json(['status'=>false,'message'=>'You are not set your address/location. Please set your location and start downloading your file now']);
          }
      }

    }
    public function userInfo($fileName,$data){
        $json = json_encode($data,JSON_PRETTY_PRINT);
        file_put_contents($fileName,$json);
    }

    public function writeOnTextFile($fileName,$text){
        $fileNames = fopen($fileName,'a+');
        $texts = implode('\n',array_unique(explode('\n', $text)));
        fwrite($fileNames,$texts.PHP_EOL);
        fclose($fileNames);
    }

    public function deleteZippedFile($fileName){
        $file = public_path()."/Zips/".$fileName;
        if (file_exists($file)) {
            unlink(public_path() . "/Zips/" .$fileName);
            $zipFileName = $fileName;
            $fileNameIndex = strripos($zipFileName,".");
            $JSONFileName = substr($zipFileName,0,$fileNameIndex);
            $realJSONFileName = $JSONFileName.".json";
            if (file_exists(public_path()."/Zips/files/".$realJSONFileName)){
                unlink(public_path()."/Zips/files/".$realJSONFileName);
            }
        }
    }

    public function prepareFile($user,$public_path,$adverts,$requestId,$device_id)
    {
        $today = Carbon::now()->format('dmyhis');
        $text_file_name = $user->first_name . $device_id;
        fopen($public_path . '/Zips/files/' . $text_file_name . '.json', 'w');
        $textFilePath = $public_path . '/Zips/files/' . $text_file_name . '.json';

        $zip = new ZipArchive;
        $userInfo = array(
            "id" => $user->id,
            "date" => $today
        );
        $users = $userInfo;

        $mainArray = array();
        $mainArray['userInfo'] = $users;

        $advertsData = array();

        $zipName = $user->first_name . $device_id . '.zip';

        foreach (json_decode($adverts, true) as $adv) {
            $advertsData[] = array(
                'id' => $adv['id'],
                'company_name'=>$this->companyName($adv['id']),
                'product_name'=>$adv['product_name'],
                'maximumViewPerDay' => $this->maximumPerDayView($adv['id']),
                'privilege' => $this->findLevel($adv['id']),
                'fileName' => $adv['file_name']
            );
            $mainArray['advertData'] = $advertsData;
            $this->userInfo($textFilePath, $mainArray);
            if ($zip->open($public_path . '/Zips/' . $zipName, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($public_path . '/uploads/' . $adv['file_name'], $adv['file_name']);
                $zip->addFile($public_path . '/Zips/files/' . $text_file_name . '.json', $text_file_name . ".json");
                $zip->close();
            } else {
                echo 'failed';
            }
        }

        //update download request
        $downloadRequest = DownloadRequest::find($requestId);
        $downloadRequest->file_name = $zipName;
        $downloadRequest->status = 'request_processed';
        $downloadRequest->save();

        //send sms notification that download request is completed
        $message= 'Hello, '.$user->first_name.' your download request is completed. Now you can start downloading your file. \nGulo ads group';
        $this->smsSender->send($user->phone,$message);

    }

    public function companyName($id){
        $advert = DB::table('adverts')
            ->join('companies',function ($join){
                $join->on('adverts.company_id','=','companies.id');
            })->where('adverts.id',$id)->select('companies.name')->get();

        return $advert[0]->name;
    }

    public function maximumPerDayView($advertId){
        $advert = Advert::find(2);
        $cars = DB::table('cars')->join('car_place',function ($join){
            $join->on('cars.id','=','car_place.car_id');
        })->get();
        $carsNumber = count($cars);
        //total per play advert divided by number of advert day
        // and then dividing the result for each cars
        //equal growth
        return  round(($advert->required_views_number/env('ADVERT_DAYS'))/$carsNumber);

    }

    public function findLevel($advertId){
        return "Highest";
    }
}