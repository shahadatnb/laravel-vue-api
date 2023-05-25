<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Level;
use App\Models\platform;
use App\Models\Series;
use App\Models\Topic;
use http\Env\Response;

class CourseController extends Controller
{
    public function index(){
        $courses = Course::latest()->with(['submittedBy','level'])->take(6)->get();
        $series = Series::take(6)->get();

        return response()->json([
            "courses"=>$courses,
             "series"=>$series,
        ]);
    }
    public function courses(Request $request){
        $type = $request->type;
        $rsLevel = $request->level;
        $rsPlatform = $request->platform;
        $rsSeries = $request->series;
        $rsPrice = $request->price;
        $rsDuration = $request->duration;

        if ($type==='books'){
            $type = 1;
        }else{
            $type = 0;
        }
        $courses = Course::latest()->where('type',$type)
            ->where('title','like','%'.$request->search.'%')
            ->when($rsPrice,function($qurey)use($rsPrice){
                if ($rsPrice == 'free'){
                    return $qurey->where('price','<','1');
                }elseif ($rsPrice == 'paid'){
                    return $qurey->where('price','>','0');
                }

            })
            ->when($rsDuration,function($qurey)use($rsDuration){
                return $qurey->whereIn('duration',$rsDuration);
            })
            ->when($rsLevel,function($qurey)use($rsLevel){
                return $qurey->whereIn('level_id',$rsLevel);
            })
            ->when($rsPlatform,function($qurey)use($rsPlatform){
                return $qurey->whereIn('platform_id',$rsPlatform);
            })
            ->with(['reviews','platform','topics','submittedBy','level','authors','series'])
            ->when($rsSeries,function($query)use($rsSeries){
                $query->whereHas('series', function($query) use($rsSeries) {
                    $query->whereIn('series_id', $rsSeries);
                });
            })
            ->paginate(10);

        return response()->json($courses);

    }
    public function single(Request $request){
        $course = Course::where('slug',$request->slug)->with(['topics','submittedBy','level','authors','reviews'=>function($query){
            return $query->with(['author']);
        }])->first();
        if (empty($course)){
            return abort(404);
        }
        return response()->json($course);
    }

    public  function archive(Request $request){
        $type = $request->type;
        $slug = $request->slug;
        if ($type === 'topics'){
            $items = Topic::where('slug',$slug)->first();
            if (empty($items)){
                return abort(404);
            }
            $courses = $items->courses()->paginate(12);

            foreach ($courses as $course) {
               $course->submittedBy;
               $course->level;
            }
        }elseif ($type == 'series'){
            $items = Series::where('slug',$slug)->first();
            if (empty($items)){
                return abort(404);
            }
            $courses = $items->courses()->paginate(12);

            foreach ($courses as $course) {
                $course->submittedBy;
                $course->level;
            }
        }elseif ($type == 'levels'){
            $items = Level::where('slug',$slug)->first();
            if (empty($items)){
                return abort(404);
            }
            $courses = $items->courses()->paginate(12);

            foreach ($courses as $course) {
                $course->submittedBy;
                $course->level;
            }
        }elseif ($type == 'platforms'){
            $items = platform::where('slug',$slug)->first();
            if (empty($items)){
                return abort(404);
            }
            $courses = $items->courses()->paginate(12);

            foreach ($courses as $course) {
                $course->submittedBy;
                $course->level;
            }
        }elseif ($type == 'duration'){
            $courses = Course::where('duration',$slug)->with(['submittedBy','level'])->paginate(12);
            if (empty($courses)){
                return abort(404);
            }
            if ($slug == '2'){
                $name = '10+ hours';
            }elseif ($slug=='1'){
                $name = '5-10 hors';
            }else{
                $name = '1-5 hours';
            }
            $items = collect(["name" => $name]);
        }



        return response()->json([
            'courses' => $courses,
            'item' => $items,
        ]);
    }
    //Footer and courses page filter section content
    public function filterContent(Request $request){
        $type = $request->type;
        if ($type==='books'){
            $type = 1;
        }else{
            $type = 0;
        }
        $platform = platform::latest()->with(['courses'=>function($query)use($type){
            $query->where('type',$type);
        }])->take(4)->get();
        $levels = Level::latest()->with(['courses'=>function($query)use($type){
            $query->where('type',$type);
        }])->take(4)->get();
        $Series = Series::latest()->with(['courses'=>function($query)use($type){
            $query->where('type',$type);
        }])->take(4)->get();
        $topics = Topic::latest()->with(['courses'=>function($query)use($type){
            $query->where('type',$type);
        }])->take(4)->get();
        $paid= Course::select(['id'])->where('type',$type)->where('price','>',0)->count();
        $free = Course::select(['id'])->where('type',$type)->where('price','<',1)->count();
        $oneToToten = Course::select(['id'])->where('type',$type)->where('duration',0)->count();
        $fiveToten = Course::select(['id'])->where('type',$type)->where('duration',1)->count();
        $tenPlus = Course::select(['id'])->where('type',$type)->where('duration',2)->count();


        return response()->json([
            'platform' => $platform,
            'levels'  => $levels,
            'series'  => $Series,
            'topics'  => $topics,
            'paid' => $paid,
            'free' => $free,
            'oneToFive' => $oneToToten,
            'fiveToten' => $fiveToten,
            'tenPlus' => $tenPlus,
        ]);
    }
}
