<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\BarResource;
use App\Http\Resources\BarCollection;
use App\Models\Bar;


class BarsController extends Controller
{
    /**
     * Get all bars (with pagination)
     * @param: void()
     * @return: \JSON
     */
    public function getAllBars(){  
        $bars = Bar::paginate();
        /**
         * Return all data (paginated)
         */
        return new BarCollection($bars);
    }

    /**
     * Get bar by id
     * @param: $id: Integer
     * @return: \JSON
     */
    public function getBarById(int $id){
        if(!$id || $id <= 0 || !is_int($id)){

            return response()->json(['error' => true, 'message' => 'Invalid reference id (must be integer positive)!']);
        }

        $bar = Bar::find($id);

        if(!$bar){

            return response()->json(['error' => true, 'message' => 'Invalid reference id (no bar found with this request)!']);
        }
        /**
         * Return a JSON object as well
         */
        return response()->json(['error' => true, 'data' => new BarResource($bar)]);
    }

    /**
     * Filter bar by name / address / combination
     * @param: Illuminate\Http\Request $request
     * @return: \JSON
     * Note: This function can be available in terms of logic under the 'getAllBars' 
     * where the parameters of the search criteria are null
     */
    public function filterByCriteria(Request $request){  
        /**
         * Validate input data (request parameters)
         */
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|min:2',
            'address' => 'nullable|min:2',
        ]);
        /**
         * If Error found
         */
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        /**
         * Access validated data
         */   
        $name = $request->name;
        $address = $request->address;

        $query = Bar::query();

        if($name && strlen($name) > 1){
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        if($address && strlen($address) > 1){
            $query->where('address', 'LIKE', '%'.$address.'%');           
        }

        $bars = $query->paginate();
        /**
         * Return a Bar collection (paginated)
         */
        return new BarCollection($bars);
    }   
    
    /**
     * Add new bar
     * @param: Illuminate\Http\Request $request
     * @return: \JSON
     */
    public function addBar(Request $request){
        try{
            /**
             * Validate input data (request parameters)
             */
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:bars|min:2|max:191',
                'address' => 'required|min:2|max:191',
            ]);
            /**
             * If Error found
             */
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            /**
             * Populate data
             */   
            $name = $request->name;
            $address = $request->address;  
            
            $bar = new Bar;
            $bar->name = $name;
            $bar->address = $address;

            if($bar->save()){

                return response()->json(['error' => false, 'message' => 'Bar has been added successfully.'], 
                200, [], JSON_PRETTY_PRINT);
            }
        }catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
        catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Update an existing bar
     * @param: Illuminate\Http\Request $request
     * @return: \JSON
     */
    public function updateBar($id, Request $request){
        try{
            $name = $request->name;
            $address = $request->address;

            $bar = Bar::find($id);

            if(!$bar){
                return response()->json(['error' => true, 'message'=> 'Bar was not found!']);
            }
            /**
             * Validate input data (request parameters)
             */
            $validator = Validator::make($request->all(), [
                'name'    => 'required|min:2|max:191|unique:bars,name,' . $id . ',id',
                'address' => 'required|min:2|max:191',
            ]);
            /**
             * If Error found
             */
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            /**
             * Update data (Bar info)
             */   
            $bar->name = $name;
            $bar->address = $address;

            if($bar->save()){

                return response()->json(['error' => false, 'message' => 'Bar has been updated successfully.'], 
                200, [], JSON_PRETTY_PRINT);
            }
        }catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
        catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }    

}
