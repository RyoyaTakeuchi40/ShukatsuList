<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user_id;

        // ユーザーが所有する会社とそれに関連する面接および選考を取得
        $companies = Company::with(['interviews' => function ($query) {
            $query->select('id', 'company_id', 'interview', 'result')
                ->orderBy('interview', 'asc');
        }])
            ->leftJoin('selections', 'companies.id', '=', 'selections.company_id')
            ->select(
                'companies.id as id',
                'companies.name as name',
                'companies.favorite as favorite',
                'companies.url as url',
                'companies.login as login',
                'selections.es as es',
                'selections.es_result as es_result',
                'selections.test as test',
                'selections.test_type as test_type',
                'selections.test_result as test_result',
                'selections.gd as gd',
                'selections.gd_result as gd_result',
                'selections.result as result',
            )
            ->where('companies.user_id', $userId)
            ->get();

            // interviews を連想配列に変換
            $companies->transform(function ($company) {
                $interviews = [];
                foreach ($company->interviews as $interview) {
                    $interviews[$interview->id] = $interview->toArray();
                }
                $company->interviews = $interviews;
                return $company;
            });
        return response()->json($companies);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $company = Company::with(['interviews' => function ($query) {
            $query->select('id', 'company_id', 'interview', 'note', 'result')
                ->orderBy('interview', 'asc');
            }])
                ->leftJoin('selections', 'companies.id', '=', 'selections.company_id')
                ->select(
                    'companies.id as id',
                    'companies.name as name',
                    'companies.favorite as favorite',
                    'companies.url as url',
                    'companies.login as login',
                    'companies.note as note',
                    'selections.es as es',
                    'selections.es_note as es_note',
                    'selections.es_result as es_result',
                    'selections.test as test',
                    'selections.test_type as test_type',
                    'selections.test_note as test_note',
                    'selections.test_result as test_result',
                    'selections.gd as gd',
                    'selections.gd_note as gd_note',
                    'selections.gd_result as gd_result',
                    'selections.result as result',
                )
            ->find($id); // 一件だけ取得
        
            // interviews を連想配列に変換
            $interviews = [];
            foreach ($company->interviews as $interview) {
                $interviews[$interview->id] = $interview->toArray();
            }
            $company->interviews = $interviews;
        
            return response()->json($company);
    }
}
