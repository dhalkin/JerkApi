<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\ORM\Model\Dance\Role;
use App\ORM\Model\Dance\CompanyUser;
use App\ORM\Model\Dance\Company;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginAgainController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/olala';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web2');
    }
    
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|alpha_num',
            'password' => 'required|string'
        ]);
    }
    
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
    
        return response()->json([
            'message' => trans('Success logged in'),
            'type' => 'success'
        ], 200);
    }
    
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['active'=>'1']);
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'message' => trans('auth.failed'),
            'type' => 'warning'
        ], 422);
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        
        $request->session()->invalidate();
    
        return response()->json([
            'message' => trans('Success logged out'),
            'type' => 'success'
        ], 200);
    }
    
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
            'companyUid' =>'required|string'
        ]);
        
        // is there a right company
        $company = Company::where('unique_id', '=', $request->get('companyUid'))
            ->first();
        if(!$company){
            return response()->json([
                'message' => trans('auth.unknown_company'),
                'type' => 'warning'
            ], 409);
        }
        
        // unique phone
        $isset = CompanyUser::where('phone', $request->phone)->first();
        if($isset){
            return response()->json([
                'message' => trans('auth.duplicate_tel'),
                'type' => 'warning'
            ], 409);
        }
    
        $user = new CompanyUser([
            'first_name' => $request->name,
            'company_id' => $company->getAttributes()['id'],
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'api_token' => Str::random(60),
            'active' => true,
            'role_id' => Role::ROLE_STUDENT
        ]);
        
        // and login in a hurry
        if ($user->save()) {
            if (true !== $this->guard()->attempt(
                    $this->credentials($request), $request->filled('remember')
                )){
                    $this->sendFailedLoginResponse($request);
            }
        }
        return response()->json([
            'message' => 'Welcome aboard!',
            'type' => 'success'
        ], 200);
    }
}
