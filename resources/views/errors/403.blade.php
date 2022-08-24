@extends('layouts.error', [
    'errorCode' => '403',
    'errorDescription' => 'Action forbidden',
    'message' => $exception->getMessage() ?? "Non avresti dovuto venire qui",
    'image' => "avatar-troll.svg",
])
