<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Bar;
use App\Models\Stock;
use App\Models\Beverage;

class BeverageBarStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $beers = Http::acceptJson()->get(env('S3_BUCKET_OBJECTS_URL') . '/beers.json');

        $beverages = $beers->json();

        foreach($beverages as $beverage){

            DB::table('beverages')->insert([
                'name' => $beverage['name'],
                'barcode' => $beverage['codebar'],
                'alcoholUnit' => $beverage['alcoholUnits'],
                'type' => strtolower($beverage['type'])
            ]);
        }

        $bars = Http::acceptJson()->get(env('S3_BUCKET_OBJECTS_URL') . '/bars.json');

        $barsList = $bars->json();

        foreach($barsList as $bar){

            $bar_id = DB::table('bars')->insertGetId([
                'name' => $bar['barName'],
                'address' => $bar['address']
            ]);

            foreach($bar['stock'] as $stock){

                $beverage = Beverage::whereRaw('LOWER(name) = ?', [strtolower($stock['name'])])->first();
                if($beverage){

                    DB::table('stocks')->insert([
                        'bar_id' =>  $bar_id,
                        'beverage_id' => $beverage->id,
                        'price' => $stock['price'],
                    ]);  
                }
            }
        }

        $visits = Http::acceptJson()->get(env('S3_BUCKET_OBJECTS_URL') . '/visit_events.json');

        $events = $visits->json();

        foreach($events as $event){

            $bar = Bar::whereRaw('LOWER(name) = ?', [strtolower($event['bar_name'])])->first();
            if($bar){

                $visit_id = DB::table('visits')->insertGetId([
                    'uuid' => $event['uuid'],
                    'bar_id' => $bar->id,                    
                    'visitedOn' => $event['visited']
                ]);

                $beverage = Beverage::whereRaw('LOWER(name) = ?', [strtolower($event['beverage'])])->first();
                if($beverage){

                    $stock = Stock::where(['bar_id' => $bar->id, 'beverage_id'=> $beverage->id])->first();
                    if($stock){

                        if($event['drinks'] > 0){

                            DB::table('drinks')->insert([
                                'stock_id'  => $stock->id,
                                'visit_id' => $visit_id,
                                'quantity'  => $event['drinks'],
                                'happyHour' => $event['happy_hour']?1:0,
                            ]);
                        }
                    }
                }
            }
        }
    }
}

