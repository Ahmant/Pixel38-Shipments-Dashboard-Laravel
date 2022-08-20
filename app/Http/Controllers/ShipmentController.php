<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Http\Requests\StoreShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;

class ShipmentController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Shipment::class, 'shipment');
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    // protected function resourceAbilityMap()
    // {
    //     return [
    //         'index' => 'viewAny',
    //         'show' => 'view',
    //         'create' => 'create',
    //         'store' => 'create',
    //         'edit' => 'update',
    //         'update' => 'update',
    //         'destroy' => 'delete',
    //         'countByStatus' => 'countByStatus',
    //     ];
    // }

    // /**
    //  * Get the list of resource methods which do not have model parameters.
    //  *
    //  * @return array
    //  */
    // protected function resourceMethodsWithoutModels()
    // {
    //     return ['index', 'create', 'store', 'countByStatus'];
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'success' => true,
            'data' => auth()->user()->shipments
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShipmentRequest $request)
    {
        $shipment = Shipment::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        return [
            'success' => true,
            'message' => 'Shipment created',
            'data' => $shipment
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment)
    {
        return [
            'success' => true,
            'data' => $shipment
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShipmentRequest  $request
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment)
    {
        $shipment->update($request->validated());

        return [
            'success' => true,
            'message' => 'Shipment updated',
            'data' => $shipment
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return [
            'success' => true,
            'message' => 'Shipment deleted',
        ];
    }

    /**
     * Get shipments status statistics
     *
     * @return \Illuminate\Http\Response
     */
    public function countByStatus()
    {
        return [
            'success' => true,
            'data' => auth()->user()->shipmentsStatistics()
        ];
    }
}
