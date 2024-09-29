<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TokenController extends Controller {
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'tokenName' => ''
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());


        $validatedData = $validator->safe();
        $validatedData['tokenName'] = $validatedData['tokenName'] ?? $request->header('User-Agent') ?? "Default";

        $isSuccess = Auth::attempt(['email' => $validatedData["email"], 'password' => $validatedData["password"]]);
        if (!$isSuccess)
            return response()->json(['error' => "Email or password incorrect."]);

        $token = $request->user()->createToken($validatedData['tokenName']);

        return  response()->json([
            'token' => $token->plainTextToken
        ]);
    }

    public function getTokens(Request $request) {
        return response()->json($request->user()->tokens);
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'tokenId' => 'required|numeric',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        $validatedData = $validator->safe();

        if (!$token = $request->user()->tokens()->where('id', $validatedData["tokenId"])->first())
            return response()->json(['error' => "Token don't exist with this ID"]);

        $token->delete();

        return response()->json(['success' => "Token successfully deleted."]);
    }
}
