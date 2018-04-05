<?php

namespace App\Http\Controllers;

use App\Article;
use App\Keyword;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public const FORMAT = "Y-m-d";
    public function keywordNewsCountReportByDayAction()
    {
        $result = [];
        $to = date(self::FORMAT, strtotime(date(self::FORMAT)) + 86400);
        for ($i = 0; $i < 10; $i++){
            $from =  date(self::FORMAT, strtotime(date(self::FORMAT)) - 86400 * $i);
            $result[$from] = Keyword::active()
                ->whereHas('articles', $takeByDate = function ($query) use ($to, $from) {
                    $query->where('publishedat', '>=', $from)->where('publishedat', '<', $to);
                })
                ->withCount(['articles' => $takeByDate])
                ->orderBy('articles_count', 'desc')
                ->take(10)
                ->get();
            $to = $from;
        }
        return view('reports.first', compact('result'));
    }

    /**
     * @param Keyword $keyword
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function keywordReportAction( Request $request)
    {
        $keyword = Keyword::find($request->id);
        $val = $request->val;
        $from = date(self::FORMAT, strtotime(date(self::FORMAT)) - 86400 * $val);
        $nextDay = date(self::FORMAT, strtotime($from) + 86400);
        $result[$from] = $keyword->articles()
            ->where('publishedat', '>=', $from)
            ->where('publishedat', '<', $nextDay)
            ->count();;
        for ($i = 1; $i < $val; $i++){
            $from = $nextDay;
            $nextDay = date(self::FORMAT, strtotime($from) + 86400);
            $result[$from] = $keyword->articles()
                ->where('publishedat', '>=', $from)
                ->where('publishedat', '<', $nextDay)
                ->count();
        }
        return view('reports.second', compact('result', 'keyword'));

    }

}
