<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionsAnswers extends Model
{
    public $timestamps = false;

    protected $table = 'questions_answers';

    protected $fillable = ['id', 'question', 'answer'];

}
