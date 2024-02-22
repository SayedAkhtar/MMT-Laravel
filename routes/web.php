<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\ApplicationDefaultCredentials;
use Kreait\Firebase\Messaging\ApiClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/creds', function () {
    $credentialsPath = '/Users/apple/Desktop/Freelance/MMT/Backend/mmt-firebase-admin-v3.json';
    $d = json_decode(file_get_contents($credentialsPath), true);
    // Create ServiceAccountCredentials object
    $credentials = new ServiceAccountCredentials(['https://www.googleapis.com/auth/firebase.messaging'], $d);

    // Obtain the access token
    try {
        $scope = 'https://www.googleapis.com/auth/firebase.messaging';
// $credentials = ApplicationDefaultCredentials::getCredentials($scope);
$tempauxarrayresult = $credentials->fetchAuthToken();
        // $accessToken = new AccessToken($credentials);
        // $token = $accessToken->fetchAuthToken();
        // $accessTokenString = $token['access_token'];
        dd($tempauxarrayresult);
        // Use $accessTokenString as needed
    } catch (\Exception $e) {
        // Handle exception
        dd($e->getMessage());
    }
});

//Route::group(['middleware' => ['auth']], function () {
Route::get('/agora-chat', [App\Http\Controllers\AgoraVideoController::class, 'index']);
Route::post('/agora/token', [App\Http\Controllers\AgoraVideoController::class, 'token']);
Route::post('/agora/call-user', [App\Http\Controllers\AgoraVideoController::class, 'callUser']);
//});

Route::get('email/verify/{token}', function (Illuminate\Http\Request $request) {
    $email = Crypt::decrypt($request->route('token'));

    $user = User::where('email', $email)->firstOrfail();
    $user->update(['email_verified_at' => Carbon::now()]);

    return response()->json(['success' => 'Email verified successfully']);
});

include 'social-routes.php';
