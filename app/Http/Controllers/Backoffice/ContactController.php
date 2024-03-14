<?php
namespace App\Http\Controllers\Backoffice;

use App\Helper\PlatformHelper;
use App\Http\Controllers\Controller;
use App\Models\TContact;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function actionGetAll(Request $request, $currentPage)
    {
        $searchParameter=$request->has('searchParameter') ? $request->input('searchParameter') : '';

        $paginate=PlatformHelper::preparePaginate(TContact::whereRaw('compareFind(concat(completeNameContact, emailContact, affairContact, messageContact), ?, 77)=1',[$searchParameter])
        ->orderby('created_at', 'desc'), 7, $currentPage);

        return view('backoffice/contact/getall',
        [
            'listTContact' => $paginate['listRow'],
            'currentPage' => $paginate['currentPage'],
            'quantityPage' => $paginate['quantityPage'],
            'searchParameter' => $searchParameter
        ]);
    }
}
