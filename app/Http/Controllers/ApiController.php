<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestfulApi;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $result = ['message' => 'value not found'];

        if ($request->has('timestamp')) {
            $createdAt = Carbon::parse($request->timestamp)->toDateTimeString();
            $result = RestfulApi::where('created_at', $createdAt)->pluck('key', 'value')->toArray();
        }

        if ($request->has('key')) {
            $result = RestfulApi::where('key', $request->key)->pluck('key', 'value')->toArray();
        }

        return response()->json(['data' => $result]);
    }

    public function store(Request $request)
    {
        $req = json_decode($request->except('__token', '__method'));

        if (count($req) != 2) {
            return response('invalid error msg', 400);
        }

        $validatedData = $request->validate([
            $req[0] => 'required|unique:restful_api,key|max:255|string',
            $req[1] => 'required|max:255|string',
        ]);

        (new RestfulApi(['key' => $req[0], 'value' => $req[1]]))->save();

        return response('successful saved', 200);
    }
}
