<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Response;


class RoleController extends Controller
{
    public function index()
    {
        return response(Role::access()->get()->jsonSerialize(), Response::HTTP_OK);
    }
}
