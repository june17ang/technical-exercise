<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestfulApi;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $status = 200;
        $result = [];
        if ($request->has('timestamp') && !empty($request->timestamp)) {
            if ((string) (int) $request->timestamp === $request->timestamp
            && ($request->timestamp <= PHP_INT_MAX)
            && ($request->timestamp >= ~PHP_INT_MAX)) {
                $createdAt = Carbon::parse(intval($request->timestamp))->toDateTimeString();
                $result = RestfulApi::where('created_at', $createdAt)->pluck('key', 'value')->toArray();
            }else {
                return response('invalid timestamp', 500);
            }

        } elseif (!empty($request->key)) {
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
