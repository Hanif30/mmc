<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commitments = Commitment::all();
        return response()->json($commitments->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'nullable',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $commitment = new Commitment;
            $commitment->name = $request->name;
            $commitment->description = $request->description;
            $commitment->amount = $request->amount;
            $commitment->save();
            return response()->json([
                'status' => 'success',
                'message' => 'successfully stored commitment',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'store commitment failed'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $commitment = Commitment::find($id);

        if ($commitment !== null) {
            return response()->json($commitment);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'commitment not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $body = $request->all();
        $body['id'] = $id;
        $validator = Validator::make($body, [
            'name' => 'required|max:50',
            'description' => 'nullable',
            'amount' => 'required|numeric',
            'paid' => 'required|boolean',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $commitment = Commitment::find($id);

        if ($commitment !== null) {
            try {
                $commitment->name = $request->name;
                $commitment->description = $request->description;
                $commitment->amount = $request->amount;
                $commitment->paid = $request->paid;
                $commitment->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'commitment successfully updated'
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'store commitment failed'
                ]);
            }
            return response()->json($commitment);
        } else {
            return response()->json([
                'status' => 'error',
                'message'  => 'commitment not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commitment  $commitment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $commitment = Commitment::find($id);

        if ($commitment !== null) {
            try {
                $commitment->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'commitment successfully deleted'
                ]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'delete commitment failed'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'commitment not found'
            ]);
        }
    }
}
