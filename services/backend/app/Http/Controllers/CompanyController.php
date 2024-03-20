<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

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
                'selections.test as test',
                'selections.test_type as testType',
                'selections.test_result as testResult',
                'selections.gd as gd',
                'selections.gd_result as gdResult',
                'selections.result as result',
            )
            ->where('companies.user_id', $user_id)
            ->get();
        if (!$companies) {
            return response()->json(['message' => 'Companies not found.'], 404);
        }

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
        $user_id = Auth::user()->id;

        $company = Company::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'url' => $request->url,
            'login' => $request->login,
            'note' => $request->note,
        ]);

        $company->selections()->create([
            'es' => $request->es,
            'es_note' => $request->esNote,
            'test' => $request->test,
            'test_type' => $request->testType,
            'test_note' => $request->testNote,
            'gd' => $request->gd,
            'gd_note' => $request->gdNote,
        ]);
                
        foreach ($request->interviews as $index => $interview) {
            $company->interviews()->create([
                'times' => $index + 1,
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
        $user_id = Auth::user()->id;

        $company = Company::with(['interviews' => function ($query) {
            $query->select('id', 'company_id', 'times', 'interview', 'note', 'result')
                ->orderBy('times', 'asc');
        }])
            ->leftJoin('selections', 'companies.id', '=', 'selections.company_id')
            ->select(
                'companies.id as id',
                'companies.user_id as user_id',
                'companies.name as name',
                'companies.favorite as favorite',
                'companies.url as url',
                'companies.login as login',
                'companies.note as note',
                'selections.es as es',
                'selections.es_note as esNote',
                'selections.es_result as esResult',
                'selections.test as test',
                'selections.test_type as testType',
                'selections.test_note as testNote',
                'selections.test_result as testResult',
                'selections.gd as gd',
                'selections.gd_note as gdNote',
                'selections.gd_result as gdResult',
                'selections.result as result',
            )
            ->find($id); // 一件だけ取得
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    
        // ユーザーIDのチェック
        if ($company->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

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
        $user_id = Auth::user()->id;

        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    
        // ユーザーIDのチェック
        if ($company->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
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
                'es_note' => $request->esNote,
                'es_result' => $request->esResult,
                'test' => $request->test,
                'test_type' => $request->testType,
                'test_note' => $request->testNote,
                'test_result' => $request->testResult,
                'gd' => $request->gd,
                'gd_note' => $request->gdNote,
                'gd_result' => $request->gdResult,
                'result' => $request->result,
            ]);
        }
        
        $interviews = $company->interviews;
        if ($interviews) {
            foreach ($request->interviews as $index => $interviewData) {
                $interview = $interviews->where('times', $index + 1)->first();
                if ($interview) {
                    // 更新
                    $interview->update([
                        'times' => $index + 1,
                        'interview' => $interviewData['interview'],
                        'note' => $interviewData['note'],
                        'result' => $interviewData['result'],
                    ]);
                } else {
                    // 入力されたデータの方が多かった場合新規作成
                    $company->interviews()->create([
                        'times' => $index + 1,
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
                    'times' => $index + 1,
                    'interview' => $interviewData['interview'],
                    'note' => $interviewData['note'],
                    'result' => $interviewData['result'],
                ]);
            }
        }

        return response()->json(['message' => 'Company edited successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function favorite(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    
        // ユーザーIDのチェック
        if ($company->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $company->favorite = $request->favorite;
        $company->save();
    
        return response()->json(['message' => 'Favorite changed successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;

        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    
        // ユーザーIDのチェック
        if ($company->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $company->selections()->delete();
        $company->interviews()->delete();
        $company->delete();

        return response()->json(['message' => 'Company and its related data deleted successfully'], 201);
    }
}
