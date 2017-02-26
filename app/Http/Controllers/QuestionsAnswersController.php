<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionsAnswers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionsAnswersController extends Controller
{
    public function getQuestionsAnswers(){
        $questionsAnswers = QuestionsAnswers::all();
        return response($questionsAnswers, 200);
    }
    public function createOrUpdateQuestionsAnswers(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $questionInfo = $request->input('questionInfo');
            if(isset($questionInfo['edit'])){
                if(QuestionsAnswers::where('id', $questionInfo['id'])->update([
                        'question' => $questionInfo['question'],
                        'answer' => $questionInfo['answer']
                    ]) > 0)
                return response(1, 200);
            }else{
                return response(QuestionsAnswers::create([
                        'question' => $questionInfo['question'],
                        'answer' => $questionInfo['answer']
                ]), 200);
            }
        } else {
            return response('invalid token', 500);
        }
    }
    public function deleteQuestionsAnswers(Request $request){
        if (Controller::checkToken($request->input('token'))) {
            $questionInfo = $request->input('questionInfo');
            $deleteQuestion = QuestionsAnswers::where('id', $questionInfo['id'])->delete();
            if($deleteQuestion > 0){
                return response(1, 200);
            }else{
                return response('not delete', 500);
            }
        } else {
            return response('invalid token', 500);
        }
    }
}
