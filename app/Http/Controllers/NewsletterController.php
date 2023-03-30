<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade;

class NewsletterController extends Controller
{


    /**
     * Store a newly created email .
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {


        $this->validate($request, [
            'email' => 'required|email',
            // 'gdpr'  => 'required',
        ]);


        $isSubscribed = NewsletterFacade::isSubscribed($request->email);

        if ($isSubscribed) {
            return response()->json(['error' => 'Email alerady subscribed to newsletter']);
        } else {
            NewsletterFacade::subscribe($request->email);
        }

        return response()->json(['success' => 'Email sucessfuly subscribed!']);
    }

}
