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
            $query->orderBy('times', 'asc');
        }, 'selections'])
            ->where('companies.user_id', $user_id)
            ->get();

        if (!$companies) {
            return response()->json(['message' => 'Companies not found.'], 404);
        }

        $formattedCompanies = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'favorite' => $company->favorite,
                'url' => $company->url,
                'login' => $company->login,
                'es' => [
                    'date' => $company->selections->es,
                    'result' => $company->selections->es_result,
                ],
                'test' => [
                    'date' => $company->selections->test,
                    'type' => $company->selections->test_type,
                    'result' => $company->selections->test_result,
                ],
                'gd' => [
                    'date' => $company->selections->gd,
                    'result' => $company->selections->gd_result,
                ],
                'result' => $company->selections->result,
                'interviews' => $company->interviews->map(function ($interview) {
                    return [
                        'times' => $interview->times,
                        'date' => $interview->interview,
                        'result' => $interview->result,
                    ];
                }),
            ];
        });

        return response()->json($formattedCompanies);
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
            'es' => $request->es['date'],
            'es_note' => $request->es['note'],
            'test' => $request->test['date'],
            'test_type' => $request->test['type'],
            'test_note' => $request->test['note'],
            'gd' => $request->gd['date'],
            'gd_note' => $request->gd['note'],
        ]);
                
        foreach ($request->interviews as $index => $interview) {
            $company->interviews()->create([
                'times' => $index + 1,
                'interview' => $interview['date'],
                'note' => $interview['note'],
            ]);
        }
        
        return response()->json(['message' => 'Company created successfully.'], 201);
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
            $query->orderBy('times', 'asc');
        }, 'selections'])
            ->where('companies.user_id', $user_id)
            ->find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    
        // ユーザーIDのチェック
        if ($company->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $formattedCompany = [
            'id' => $company->id,
            'name' => $company->name,
            'favorite' => $company->favorite,
            'url' => $company->url,
            'login' => $company->login,
            'note' => $company->note,
            'es' => [
                'date' => $company->selections->es,
                'note' => $company->selections->es_note,
                'result' => $company->selections->es_result,
            ],
            'test' => [
                'date' => $company->selections->test,
                'type' => $company->selections->test_type,
                'note' => $company->selections->test_note,
                'result' => $company->selections->test_result,
            ],
            'gd' => [
                'date' => $company->selections->gd,
                'note' => $company->selections->gd_note,
                'result' => $company->selections->gd_result,
            ],
            'result' => $company->selections->result,
            'interviews' => $company->interviews->map(function ($interview) {
                return [
                    'times' => $interview->times,
                    'date' => $interview->interview,
                    'note' => $interview->note,
                    'result' => $interview->result,
                ];
            }),
        ];

        return response()->json($formattedCompany);
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

                'es' => $request->es['date'],
                'es_note' => $request->es['note'],
                'es_result' => $request->es['result'],
                'test' => $request->test['date'],
                'test_type' => $request->test['type'],
                'test_note' => $request->test['note'],
                'test_result' => $request->test['result'],
                'gd' => $request->gd['date'],
                'gd_note' => $request->gd['note'],
                'gd_result' => $request->gd['result'],
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
                        'interview' => $interviewData['date'],
                        'note' => $interviewData['note'],
                        'result' => $interviewData['result'],
                    ]);
                } else {
                    // 入力されたデータの方が多かった場合新規作成
                    $company->interviews()->create([
                        'times' => $index + 1,
                        'interview' => $interviewData['date'],
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
                    'interview' => $interviewData['date'],
                    'note' => $interviewData['note'],
                    'result' => $interviewData['result'],
                ]);
            }
        }

        return response()->json(['message' => 'Company edited successfully.'], 200);
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
    
        return response()->json(['message' => 'Favorite changed successfully.'], 200);
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

        return response()->json(['message' => 'Company and its related data deleted successfully.'], 201);
    }
}
