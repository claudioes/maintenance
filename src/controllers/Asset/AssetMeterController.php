<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\MeterValidator;
use Stevebauman\Maintenance\Services\MeterReadingService;
use Stevebauman\Maintenance\Services\MeterService;
use Stevebauman\Maintenance\Services\AssetService;
use Stevebauman\Maintenance\Controllers\AbstractController;

/*
 * Handles asset meter creation and updating
 */
class AssetMeterController extends AbstractController {
    
    public function __construct(
            AssetService $asset,
            MeterService $meter, 
            MeterReadingService $meterReading, 
            MeterValidator $meterValidator)
    {
        $this->asset = $asset;
        $this->meter = $meter;
        $this->meterReading = $meterReading;
        $this->meterValidator = $meterValidator;
    }
    
    /**
     * Creates a meter and attaches it to the asset
     * 
     * @param integer $asset_id
     * @return response
     */
    public function store($asset_id)
    {
        $validator = new $this->meterValidator;
        
        if($validator->passes()){
            
            /*
             * Find the asset
             */
            $asset = $this->asset->find($asset_id);
            
            /*
             * Create the meter
             */
            $meter = $this->meter->setInput($this->inputAll())->create();
            
            /*
             * If the meter has been created
             */
            if($meter){
                /*
                 * Attach the meter to the asset
                 */
                $asset->meters()->attach($meter);
                
                /*
                 * Set the data for the meter reading
                 */
                $data = $this->inputAll();
                $data['meter_id'] = $meter->id;
                
                /*
                 * Create the meter reading
                 */
                $this->meterReading->setInput($data)->create();
                
                $this->message = 'Successfully created meter reading';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.assets.show', array($asset->id));
                
            } else{
                $this->message = 'There was an error trying to create a meter for this asset. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.assets.show', array($asset->id));
            }
            
        } else{
            $this->errors = $validator->getErrors();
        }
        
        return $this->response();
    }
    
    /**
     * Displays the specified meter and it's readings
     * 
     * @param integer $asset_id
     * @param integer $meter_id
     */
    public function show($asset_id, $meter_id)
    {
        $asset = $this->asset->find($asset_id);
        
        $meter = $this->meter->find($meter_id);
        
        return $this->view('maintenance::assets.meters.show', array(
            'title' => 'Viewing Asset Meter: '.$meter->name,
            'asset' => $asset,
            'meter' => $meter,
        ));
    }
    
    public function edit($asset_id, $meter_id)
    {
        
    }
    
    public function update($asset_id, $meter_id)
    {
        
    }
    
    public function destroy($asset_id, $meter_id)
    {
        $this->meter->destroy($meter_id);
        
        $this->message = 'Successfully deleted meter';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.assets.show', array($asset_id));
        
        return $this->response();
    }
    
}