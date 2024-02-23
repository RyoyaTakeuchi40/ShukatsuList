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

        $companies = Company::with(['interviews' => function ($query) {
            $query->select('id', 'company_id', 'times', 'interview', 'result')
                ->orderBy('times', 'asc');
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
        if (!$companies) {
            return response()->json(['message' => 'Companies not found.'], 404);
        }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = 1;

        $company = Company::create([
            'user_id' => $userId,
            'name' => $request->name,
            'favorite' => $request->favorite,
            'url' => $request->url,
            'login' => $request->login,
            'note' => $request->note,
        ]);

        $company->selections()->create([
            'es' => $request->es,
            'es_note' => $request->es_note,
            'test' => $request->test,
            'test_type' => $request->test_type,
            'test_note' => $request->test_note,
            'gd' => $request->gd,
            'gd_note' => $request->gd_note,
        ]);
                
        foreach ($request->interviews as $index => $interview) {
            $company->interviews()->create([
                'times' => $index,
                'interview' => $interview['interview'],
                'note' => $interview['note'],
            ]);
        }
        

        return response()->json(['message' => 'Company created successfully'], 201);
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
            $query->select('id', 'company_id', 'times', 'interview', 'note', 'result')
                ->orderBy('times', 'asc');
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
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    
        // interviews を連想配列に変換
        $interviews = [];
        foreach ($company->interviews as $interview) {
            $interviews[$interview->id] = $interview->toArray();
        }
        $company->interviews = $interviews;
    
        return response()->json($company);
    }
     
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
        $company->name = $request->name;
        $company->favorite = $request->favorite;
        $company->url = $request->url;
        $company->login = $request->login;
        $company->note = $request->note;
        $company->save();
    
        $selections = $company->selections;
        if ($selections) {
            $selections->update([
                'es' => $request->es,
                'es_note' => $request->es_note,
                'es_result' => $request->es_result,
                'test' => $request->test,
                'test_type' => $request->test_type,
                'test_note' => $request->test_note,
                'test_result' => $request->test_result,
                'gd' => $request->gd,
                'gd_note' => $request->gd_note,
                'gd_result' => $request->gd_result,
                'result' => $request->result,
            ]);
        }
        
        $interviews = $company->interviews;
        if ($interviews) {
            foreach ($request->interviews as $index => $interviewData) {
                $interview = $interviews->where('times', $index)->first();
                if ($interview) {
                    // 更新
                    $interview->update([
                        'times' => $index,
                        'interview' => $interviewData['interview'],
                        'note' => $interviewData['note'],
                        'result' => $interviewData['result'],
                    ]);
                } else {
                    // 入力されたデータの方が多かった場合新規作成
                    $company->interviews()->create([
                        'times' => $index,
                        'interview' => $interviewData['interview'],
                        'note' => $interviewData['note'],
                        'result' => $interviewData['result'],
                    ]);
                }
            }
        } else {
            // $interviewsが空の場合は、全て新規作成する
            foreach ($request->interviews as $index => $interviewData) {
                $company->interviews()->create([
                    'times' => $index,
                    'interview' => $interviewData['interview'],
                    'note' => $interviewData['note'],
                    'result' => $interviewData['result'],
                ]);
            }
        }

        return response()->json(['message' => 'Company edited successfully'], 200);
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */public function destroy($id)
    {
        $company = Company::find($id);
        
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
        $company->selections()->delete();
        $company->interviews()->delete();
        $company->delete();

        return response()->json(['message' => 'Company and its related data deleted successfully'], 201);
    }
}
