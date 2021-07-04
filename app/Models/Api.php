<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class Api
{

    public function get($datos){

        try {
            $client = new Client(
                ['base_uri' => env('API_URL'), 'verify' => false]
            );
            $request = $client->get("api/postByUser",['body' => json_encode($datos)]);
            return json_decode($request->getBody()->getContents());
        } catch (RequestException $e) {
            return $e;
        }

    }

    public function getPosts(){

        try {
            $client = new Client(
                ['base_uri' => env('API_URL'), 'verify' => false]
            );
            $request = $client->get("api/getAllPosts");
            return json_decode($request->getBody()->getContents());
        } catch (RequestException $e) {
            return $e;
        }

    }

    public function post($datos){
        try {
            $client = new Client(
                ['base_uri' => env('API_URL'), 'verify' => false]
            );
            $request = $client->post("api/insertPost", ['body' => json_encode($datos)]);
            return json_decode($request->getBody()->getContents());
        } catch (RequestException $e) {
            return $e;
        }

    }

    public function put($datos){
        try {
            $client = new Client(
                ['base_uri' => env('API_URL'), 'verify' => false]
            );
            $request = $client->put("api/updatePost", ['body' => json_encode($datos)]);
            return json_decode($request->getBody()->getContents());
            
        } catch (RequestException $e) {
            return $e;
        }

    }

    public function delete($datos){
        try {
            $client = new Client(
                ['base_uri' => env('API_URL'), 'verify' => false]
            );
            $request = $client->delete("api/deletePost",['body' => json_encode($datos)]);
            return json_decode($request->getBody()->getContents());
            
        } catch (RequestException $e) {
            return null;
        }

    }

    public function likePost($datos){
        try {
            $client = new Client(
                ['base_uri' => env('API_URL'), 'verify' => false]
            );
            $request = $client->post("api/likePost",['body' => json_encode($datos)]);
            return json_decode($request->getBody()->getContents());
        } catch (RequestException $e) {
            return null;
        }

    }

}