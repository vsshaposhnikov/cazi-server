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
}
