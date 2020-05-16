<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestfulApi;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $status = 200;
        $result = [];
        if ($request->has('timestamp') && !empty($request->timestamp)) {
            $createdAt = Carbon::parse($request->timestamp)->toDateTimeString();
            $result = RestfulApi::where('created_at', $createdAt)->pluck('key', 'value')->toArray();
        } elseif ($request->has('key') && !empty($request->key)) {
            $result = RestfulApi::where('key', $request->key)->pluck('key', 'value')->toArray();
        }

        if ($result) {
            $status = 200;
            return response(json_encode(['data' => $result]), $status);
        }

        $result = ['message' => 'value not found'];
        $status = 400;

        return response(json_encode(['data' => $result]), $status);
    }

    public function store(Request $request)
    {
        $req = $request->all();

        if (count($req) != 1) {
            return response('invalid error msg', 400);
        }
        $key = array_key_first($req);
        $value = $request->$key;

        $validator = Validator::make($request->all(), [
            $key => 'required|max:255|string',
        ]);

        if ($validator->fails()) {
            return response($$validator->errors()->all(), 422);
        }

        if (RestfulApi::where('key', $key)->exists()) {
            return response(['key already existed'], 422);
        }

        try {
            (new RestfulApi())->fill(['key' => $key, 'value' => $value])->save();

            return response('successful saved', 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response('failed to update', 500);
        }
    }
}
