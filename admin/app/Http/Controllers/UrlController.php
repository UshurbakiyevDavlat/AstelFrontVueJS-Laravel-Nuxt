<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlController extends Controller
{

	public function resolve(Request $request)
	{
		$params = $request->input();
		if (($params['do'] ?? '') == 'cat' && ($params['category'] ?? '') == 'razrabotka-proektno-smetnoj-dokumentacii') {
			return redirect('https://www.astel.kz/services/uslugi-proektirovaniya/razrabotka-proektno-smetnoy-dokumentacii');
		}
	}

}
