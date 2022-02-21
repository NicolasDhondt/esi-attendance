<?php
  //  namespace App\Http\Controllers\Auth;
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Laravel\Socialite\Facades\Socialite;
    use Exception;
    use App\Models\User;
    use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class LoginCtrl  extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle(Request $request)
    {
        Session::put('seanceId', $request->seanceId);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $parsedEmail = explode("@", $user->email);
            $studentId = $parsedEmail[0];
            $seanceId = Session::pull('seanceId');
            $finduser = StudentCtrl::isStudentInSeance($studentId, $seanceId);

            $authenticated = 0;
            if ($finduser) {
                AttendanceCtrl::makeStudentAttended($studentId, $seanceId);
                $authenticated = 1;
            }
            return redirect("/toValidationPage?isAuthenticated=$authenticated");
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
