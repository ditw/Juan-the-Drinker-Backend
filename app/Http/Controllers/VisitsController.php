<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Http\Resources\VisitResource;
use App\Http\Resources\VisitCollection;
use App\Models\Visit;


class VisitsController extends Controller
{
    /**
     * Get all visits (with pagination)
     * @param: void()
     * @return: \JSON
     */
    public function getAllVisits(){  
        $visits = Visit::paginate();
        /**
         * Return all data (paginated)
         */
        return new VisitCollection($visits);
    }

    /**
     * Get bar by id
     * @param: $id: Integer
     * @return: \JSON
     */
    public function getVisitById(int $id){
        if(!$id || $id <= 0 || !is_int($id)){

            return response()->json(['error' => true, 'message' => 'Invalid reference id (must be integer positive)!']);
        }

        $visit = Visit::find($id);

        if(!$visit){

            return response()->json(['error' => true, 'message' => 'Invalid reference id (no visit found with this request)!']);
        }
        /**
         * Return a JSON object as well
         */
        return response()->json(['error' => true, 'data' => new VisitResource($visit)]);
    }

    /**
     * Filter visit by date range (from/to)
     * @param: Illuminate\Http\Request $request
     * @return: \JSON
     * Note: This function can be available in terms of logic under the 'getAllVisits' 
     * where the parameters of the search criteria are null
     * If no request parameters provided (from/to), the function returns all visits
     * If 'from' and 'to' parameters are identical, it returns data for the exact date
     */
    public function filterByDateRange(Request $request){  
        /**
         * Validate input data (request parameters)
         */
        $validator = Validator::make($request->all(), [
            'from' => 'nullable|date|date_format:Y-m-d',
            'to'   => 'nullable|date|date_format:Y-m-d',
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
        $fd = $request->from;
        $td = $request->to;

        $query = Visit::query();

        if($fd){
            $query->whereDate('visitedOn', '>=', $fd);     
        }

        if($td){
            $query->whereDate('visitedOn', '<=', $td);     
        }

        $visits = $query->paginate();
        /**
         * Return a Bar collection (paginated)
         */
        return new VisitCollection($visits);
    }   
    
    /**
     * Add new visit
     * @param: Illuminate\Http\Request $request
     * @return: \JSON
     * Note: onVisit parameter accepts date type, it can be set to accept date/time parameter as well, for this
     * purpose, it only accepts date type with format yyyy-mm-dd
     */
    public function addVisit(Request $request){
        try{
            /**
             * Validate input data (request parameters)
             */
            $validator = Validator::make($request->all(), [
                'bar_id' => 'required|integer|exists:App\Models\Bar,id',
                'visited_on' => 'required|date|date_format:Y-m-d',
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
            $bar_id = $request->bar_id;
            $ts = $request->visited_on;  
            
            $visit = new Visit;
            $visit->bar_id = $bar_id;
            $visit->visitedOn = $ts;
            $visit->uuid = Str::orderedUuid();

            if($visit->save()){

                return response()->json(['error' => false, 'message' => 'Visit has been added successfully.'], 
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
     * Update an existing visit
     * @param: Illuminate\Http\Request $request
     * @return: \JSON
     * Note: Typically, a visit may not have an edit action because a visit is set by time once it has been added,
     * A visit may not be changed in terms of date.
     */
    public function updateVisit($id, Request $request){
        try{

            $visit = Visit::find($id);

            if(!$visit){
                return response()->json(['error' => true, 'message'=> 'Visit was not found!']);
            }
            /**
             * Validate input data (request parameters)
             */
            $validator = Validator::make($request->all(), [
                'bar_id' => 'required|integer|exists:App\Models\Bar,id',
                'visited_on' => 'required|date|date_format:Y-m-d',
            ]);
            /**
             * If Error found
             */
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
             
            $bar_id = $request->bar_id;
            $visit_on = $request->visited_on; 
            /**
             * Update data (Visit info)
             */   
            $visit->bar_id = $bar_id;
            $visit->visitedOn = $visit_on;

            if($visit->save()){

                return response()->json(['error' => false, 'message' => 'Visit has been updated successfully.'], 
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
