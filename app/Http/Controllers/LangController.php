<?php
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App;
  
class LangController extends Controller
{
  
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function change(Request $request)
    {
        $lang = $request->lang;
        App::setLocale($lang);
        session()->put('locale', $lang);
        // Also store in cookie so language persists after session expiry
        \Cookie::queue('locale', $lang, 60 * 24 * 365); // 1 year

        return redirect()->back();
    }
}