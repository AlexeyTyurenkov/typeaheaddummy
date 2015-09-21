<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;




class TypeAheadController extends Controller
{
    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  int  $lang
     * @return Response
     */
    public function index(Request $request, $lang)
    {
	$searchTerm = $request->input('search-term','');
	if($lang == "us" || $lang == 'uk')
	{
	    return response()->json($this->jsondata($lang,$searchTerm)); 
	}
	else
	{
    	    abort(404,"Search term not found");
	}
    }

    function jsondata($lang,$searchTerm)
    {

	if($searchTerm == "")
	{
	    $result = "{\"error\":\"Search Term is a mandatory parameter\"}";
	}
	else if($searchTerm == "error500")
	{
	    abort(500);
	}
	else if($searchTerm =="emptyjson")
	{
	    $result = "{}";
	}
	else
	{
		$fullPath = "/var/www/typeaheaddummy/storage/data/".$lang."/".$searchTerm.".json";
		if(file_exists($fullPath))
		{
		    $result = file_get_contents($fullPath);
		}
		else
		{
		    $result = "{
			    \"navigation\": [
			    null
			],
			\"searchFeatures\": {
			\"searchTerm\": \"".$searchTerm."*\",
			\"autoCorrection\": null
			}
}";
		}
	}
	return json_decode($result,true);
    }

}