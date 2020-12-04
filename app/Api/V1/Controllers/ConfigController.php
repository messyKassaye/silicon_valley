<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\RegionWoredZoneCity;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Gender;
use App\Products;
use App\Package;
use App\Subscribtion;
use App\Report;
class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        
        $product = explode(',',Config::get('products.products'));
        $images = explode(',',Config::get('products.images'));
        $description = explode(',',Config::get('products.description'));
        for($p=0;$p<count($product);$p++){
            $products = new Products();
            $products->name = $product[$p];
            $products->product_image =env('HOST_NAME').'/uploads/'.$images[$p];
            $products->description = $description[$p];
            $products->save();

        }
        //add package
        $packages = explode(',',Config::get('packages.packages'));
        $delay = explode(',',Config::get('packages.delay'));
        for($i=0;$i<count($packages);$i++){
            $package = new Package();
            $package->name = $packages[$i];
            $package->delay_time = $delay[$i];
            $package->save();
        }

        $includes = explode(',',Config::get('includes.includes'));
        $includeDescription = explode(',',Config::get('includes.description'));
        $includeImage = explode(',',Config::get('includes.images'));
        for ($k=0; $k <count($includes); $k++) { 
            $include = new Subscribtion();
            $include->name = $includes[$k];
            $include->description = $includeDescription[$k];
            $include->image_path = $includeImage[$k];
            $include->save();
            $product = Products::find(1);
            $include->product()->sync($product);

            $product2 = Products::find(2);
            //$include->product()->sync($product2);
        }

        //add passion
        $passions = explode(',',Config::get('passions.passion'));
        for($p=0;$p<count($passions);$p++){
            $passion = new Passion();
            $passion->name = $passions[$p];
            $passion->save();
        }

        //add reports
        $reports = explode(',',Config::get('reports.reports'));
        for($r=0;$r<count($reports);$r++){
            $report = new Report();
            $report->name = $reports[$r];
            $report->save();
        }

        

        //add gender
        $genders = explode(',',Config::get('gender.gender'));
        for($i=0;$i<count($genders);$i++){
            $region = new Gender();
            $region->name = $genders[$i];
            $region->save();
        }


       
        $superAdmin = new Role();
        $superAdmin->name = 'Admin';
        if($superAdmin->save()){
            $districtManager = new Role();
            $districtManager->name = 'Users';
            $districtManager->save();

            $user = new User();
            $user->name = 'Meseret';
            $user->user_name = 'messyAdmin';
            $user->email ='meseret.kassaye@gmail.com';
            $user->phone = '0923644545';
            $user->birth_date = '12/12/1989';
            $user->profile_pic_path = '';
            $user->password = env('ADMIN_PASSWORD');
            $user->save();
            $user->role()->sync(Role::find(1));
        } 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
