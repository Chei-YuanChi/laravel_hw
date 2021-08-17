<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function get_N(Request $request){
        $error = '';
        if ($request->has('n')){
            $file_n = storage_path('ratings_small.csv');
            $file = fopen($file_n, "r");
            $num = $request['n'];
            if(!is_null($num)){
                $data = fgetcsv($file);
                while ($num != 0){
                    $data = fgetcsv($file);
                    $userid = Movie::where('userId', '=', $data[0])->first();
                    $movieid = Movie::where('movieId', '=', $data[1])->first();
                    if (!($userid != null && $movieid != null)){
                        $new_movie = new Movie();
                        $new_movie -> userId = $data[0];
                        $new_movie -> movieId = $data[1];
                        $new_movie -> rating = $data[2];
                        $new_movie -> save();
                    }
                    $num -= 1;
                }
            }
            else $error = "Input is empty.";
            fclose($file);
        }
        $listmovie = Movie::all();
        $returnmovielist = array();
        if (count($listmovie) != 0){
            for ($i = 0; $i < count($listmovie); $i++){
                $amovie = [
                    'userId' => $listmovie[$i] -> userId,
                    'movieId' => $listmovie[$i] -> movieId,
                    'rating' => $listmovie[$i] ->rating
                ];
                array_push($returnmovielist, $amovie);
            }
        }
        return view('get_n',["movielist" => $returnmovielist, "message" => $error]);
    }

    public function delete(Request $request){
        $message = '';
        $listmovie = Movie::all();
        $returnmovielist = array();
        if (count($listmovie) != 0){
            for ($i = 0; $i < count($listmovie); $i++){
                $amovie = [
                    'userId' => $listmovie[$i] -> userId,
                    'movieId' => $listmovie[$i] -> movieId,
                    'rating' => $listmovie[$i] ->rating
                ];
                array_push($returnmovielist, $amovie);
            }
        }
        return view('delete', ["movielist" => $returnmovielist, "message" => $message]);
    }

    public function delete_post(Request $request){
        $message = '';
        if (is_null($request['userID']) || is_null($request['movieID'])) $message = "Input format is error!";
        else{
            $userid = Movie::where('userId', '=', $request['userID'])->first();
            $movieid = Movie::where('movieId', '=', $request['movieID'])->first();
            if (is_null($userid) || is_null($movieid)) $message = "The user-item data is not found.";
            else{
                Movie::where('userId', '=', $request['userID'])->where('movieId', '=', $request['movieID'] )->delete();
                $message = "Delete data successful.";
            }
        }
        $listmovie = Movie::all();
        $returnmovielist = array();
        if (count($listmovie) != 0){
            for ($i = 0; $i < count($listmovie); $i++){
                $amovie = [
                    'userId' => $listmovie[$i] -> userId,
                    'movieId' => $listmovie[$i] -> movieId,
                    'rating' => $listmovie[$i] ->rating
                ];
                array_push($returnmovielist, $amovie);
            }
        }
        return view('delete', ["movielist" => $returnmovielist, "message" => $message]);
    }

    public function modify(Request $request){
        $message = '';
        $listmovie = Movie::all();
        $returnmovielist = array();
        if (count($listmovie) != 0){
            for ($i = 0; $i < count($listmovie); $i++){
                $amovie = [
                    'userId' => $listmovie[$i] -> userId,
                    'movieId' => $listmovie[$i] -> movieId,
                    'rating' => $listmovie[$i] ->rating
                ];
                array_push($returnmovielist, $amovie);
            }
        }
        return view('modify', ["movielist" => $returnmovielist, "message" => $message]);
    }
    public function modify_post(Request $request){
        $message = '';
        if (is_null($request['userID']) || is_null($request['movieID']) || is_null($request['rating'])) $message = "Input format is error!";
        else{
            $userid = Movie::where('userId', '=', $request['userID'])->first();
            $movieid = Movie::where('movieId', '=', $request['movieID'])->first();
            if (is_null($userid) || is_null($movieid)) $message = "The user-item data is not found.";
            else{
                if ($request['rating'] > 5) $rate = 5;
                else $rate = $request['rating'];
                Movie::where('userId', '=', $request['userID'])->where('movieId', '=', $request['movieID'] )->update(array('rating' => $rate));
                $message = "Modify data successful.";
            }
        }
        return view('modify', ["message" => $message]);
    }

    public function watched(Request $request){
        $error = '';
        $returnmovielist = array();
        if ($request->has('userID')){
            if (is_null($request['userID'])) $error = "Input error.";
            else{
                $listmovie = Movie::where('userId', '=', $request['userID'])->get();
                if (count($listmovie) != 0){
                    for ($i = 0; $i < count($listmovie); $i++){
                        $amovie = [
                            'userId' => $listmovie[$i] -> userId,
                            'movieId' => $listmovie[$i] -> movieId,
                            'rating' => $listmovie[$i] ->rating
                        ];
                        array_push($returnmovielist, $amovie);
                    }
                }
                else $error = "The user is not found.";
            }
        }
        return view('watched', ["movielist" => $returnmovielist, "message" => $error]);
    }
    
    public function recommend(Request $request){
        $error = '';
        $msg = '';
        $returnmovielist = array();
        if ($request->has('userID')){
            if (is_null($request['userID'])) $error = "Input error.";
            else{
                $file_n = storage_path('recommend.csv');
                $file = fopen($file_n, "r");
                $data = fgetcsv($file);
                if ($request['userID'] > count($data) || $request['userID'] <= 0) $error = "The user is not found.";
                else{
                    for($i = 0; $i < 2; $i++){
                        $data = fgetcsv($file);
                        array_push($returnmovielist, $data[$request['userID']] - 1);
                    }
                    $msg = $request['userID'];
                }
            }
        }
        return view('recommend', ["movielist" => $returnmovielist, "message" => $error, "msg" => $msg]);
    }
}
