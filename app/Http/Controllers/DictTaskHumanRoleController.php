<?php

namespace App\Http\Controllers;

use App\DictTaskHumanRole;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictTaskHumanRoleController extends Controller
{
    public function index()
    {
        return response(DictTaskHumanRole::all()->jsonSerialize(), Response::HTTP_OK);
    }}
