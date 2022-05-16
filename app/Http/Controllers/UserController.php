<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Group;
use App\LogLaunch;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function changePwd(number $id, string $pwd)
    {
        try {
            $user = User::find($id);

            if (Hash::check($pwd->value, $user->password)) {
                $hash = Hash::make($pwd);
                $user->password = $hash;
                $user->save();
            }

        } catch (Exception $e) {
            \Log::warning($e->getMessage());
        }
    }

    public function updatePwds()
    {
        $pwds = DB::select('select 1 from users');
        foreach ($pwds as $value) {
            changePwd($value['id'], $value['value']);
        }
    }

    public function reLogin(Request $request)
    {
        try {
            $admin = auth()->guard('api')->user();
            if ($admin->is_admin !== '1') {
                return response()->json(['error' => 'You are not an admin.'], 401);
            }

            $data = DB::select('select 1 from users where id=' . $request[0]);

            DB::table('oauth_access_tokens')->where('user_id', '=', $request['id'])->delete();
            auth()->logout();

            if (Auth::attempt(['email' => $data->value, 'password' => $data->value])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $user = User::with('group')->findOrFail($user->id);
                $success['user'] = $user;
                return response()->json(['success' => $success], $this->successStatus);
            }

        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function saveUserSettings(Request $request)
    {
        $items = User::findOrFail($request['id']);
        $items->user_settings = $request['content'];
        $items->update();
        return response(null, Response::HTTP_OK);
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $user = User::with('group')->findOrFail($user['id']);
            $success['user'] = $user;

            $logLaunch = LogLaunch::where('user_id', $user['id'])->whereNull('is_checked')->whereNull('exit_time')->first();
            if ($logLaunch) {
                $success['unclosed_date'] = $logLaunch->start_time;
                $logLaunch->is_checked = 1;
                $logLaunch->save();
            }

            $item = new LogLaunch();
            $item->start_time = Carbon::now();
            $item->user_id = $user['id'];
            $item->save();
            $success['session_id'] = $item['id'];

            return response()->json(['success' => $success], $this->successStatus);
        } else if (
            strtolower(request('email')) === 'admin' && request('password') === 'admin' && User::count() === 0
        ) {
            {
                $input = [
                    'name' => 'admin',
                    'is_admin' => 1,
                    'is_locked' => 0,
                    'email' => 'admin',
                    'password' => 'admin',
                    'c_password' => 'admin',
                    'password_change_request' => 1
                ];
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $success['token'] = $user->createToken('MyApp')->accessToken;
                $success['name'] = $user->name;
                $success['id'] = $user->id;
                $success['password_change_request'] = 1;
            }
            {
                $items = new Employee();
                $items->name = 'имя';
                $items->surname = 'фамилия';
                $items->patronymic = 'отчество';
                $items->user_id = $user->id;
                $items->working_id = 1; //todo некорректно, надо смотреть словарь
                $items->save();
            }
            {
                $item = new Group();
                $item->title = 'группа';
                $item->name = 'group';
                $item->group_size = 0;
                $item->user_id = $user->id;
                $item->save();
            }
            return response()->json(['success' => $success], $this->successStatus);
        } else
            return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function register(Request $request)
    {
        if (User::where('email', $request->email)->get()->count() === 1) {
            return response()->json(['errorUnique' => 'ошибка уникальности'], 406);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_admin' => 'required',
            'email' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['password_change_request'] = 1;
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        $success['is_admin'] = $user->is_admin;
        $success['id'] = $user->id;
        $success['password_change_request'] = 1;

        return response()->json(['success' => $success], $this->successStatus);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        try {
            $admin = auth()->guard('api')->user();
            if ($admin->is_admin !== '1') {
                return response()->json(['error' => 'You are not an admin.'], 401);
            }
            $requestData = $request->All();
            $validator = Validator::make($requestData, [
                'password' => 'required|min:3',
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $user = User::find($requestData['id']);
            $user->password = Hash::make($requestData['password']);
            $user->password_change_request = 1;
            // $user->password = bcrypt($request->get('new_password'));
            $user->save();
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
        }
        return response()->json('success', $this->successStatus);
    }

    public function changePassword(Request $request)
    {
        if (auth()->guard('api')->check()) {
            $requestData = $request->All();
            $validator = $this->validatePasswords($requestData);
            if ($validator->fails()) {
                return response()->json(
                    ['state' => 'error', 'info' => $validator->errors()->all()],
                    $this->successStatus);
            } else {
                $user = auth()->guard('api')->user();
                if (Hash::check($requestData['password'], $user->getAuthPassword())) {
                    $user->password = Hash::make($requestData['new_password']);
                    $user->password_change_request = 0;
                    $user->save();
                    return response()->json(['state' => 'success', 'info' => []], $this->successStatus);
                } else {
                    return response()->json(
                        ['state' => 'error', 'info' => ['Sorry, your current password was not recognised. Please try again.']], $this->successStatus);
                }
            }
        } else {
            return response()->json(['state' => 'error', 'info' => ['Auth check failed']], $this->successStatus);
        }
    }

    public function validatePasswords(array $data)
    {
        $messages = [
            'password.required' => 'Не указан текущий пароль',
            'new_password.required' => 'Не указан новый пароль',
            'new_password.min' => 'Размер пароля не может быть менее 3-х символов',
            'new_password.different' => 'Новвый пароль и старый должны отличаться',
            'new_password_confirmation.same' => 'Подтверждение нового пароля не совпадает с паролем'];

        $validator = Validator::make($data, [
            'password' => 'required',
            'new_password' => 'required|min:3|max:128|different:password',
            'new_password_confirmation' => 'required|same:new_password',
        ], $messages);

        return $validator;
    }

    public function setActivity(Request $request)
    {
        $item = LogLaunch::findOrFail($request['session_id']);
        $item->last_activity = Carbon::now();
        $item->save();
    }

    public function logout(Request $request)
    {
        DB::table('oauth_access_tokens')->where('user_id', '=', $request['id'])->delete();
        auth()->logout();

        $item = LogLaunch::findOrFail($request['session_id']);
        $item->exit_time = Carbon::now();
        $item->save();

        //  auth()->logout();

//        $token = auth()->guard('api')->token();
//        $token->revoke();
//        $token->delete();

        ///////////////////////////////////////////////////////

//        $user2 = Auth::user();
//        $user1 = auth()->guard('api')->user();

//        auth()->guard('api')->token()->revoke();
//
//        auth()->guard('api')->tokens->each(function ($token, $key) {
//            $token->delete();
//        });
//
//        if (Auth::check()) {
//            Auth::user()->AauthAcessToken()->delete();
//        }
//
//        DB::table('oauth_access_tokens')
//            ->where('user_id', Auth::user()->id)
//            ->update([
//                'revoked' => true
//            ]);
//
//        $accessToken = Auth::user()->token();
//        $token = $user1->tokens->find($accessToken);
//        $token->revoke();
//
//
//        DB::table('oauth_refresh_tokens')
//            ->where('access_token_id', $accessToken->id)
//            ->update([
//                'revoked' => true
//            ]);
//
//
//        if (Auth::check()) {
//            Auth::user()->AauthAcessToken()->delete();
//        }

        ///////////////////////////////////////////////

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function lock($id)
    {
        $item = User::find($id);
        $item->is_locked = 1;
        $item->update();
        return response(null, Response::HTTP_OK);
    }

    public function unlock($id)
    {
        $item = User::find($id);
        $item->is_locked = 0;
        $item->update();
        return response(null, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $item = User::findOrFail($id);
        $input = $request->all();
        if (isset($input['name']))
            $input['email'] = $input['name'];
        $item->update($input);

        return response(null, Response::HTTP_OK);
    }

}
