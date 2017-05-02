<?php

Route::get('/', function () {
    return view('welcome');
});

//common methods
Route::post('/api/login', 'SignController@login');
Route::post('/api/logout', ['middleware' => 'apiAuth', 'uses' => 'SignController@logout']);
Route::post('/api/changePassword', ['middleware' => 'apiAuth', 'uses' => 'UsersController@changePassword']);
Route::post('/api/getAvpzList', ['middleware' => 'apiAuth', 'uses' =>'AvpzListController@getAvpzList']);
Route::post('/api/getAvpzListByUser', ['middleware' => 'apiAuth', 'uses' =>'AvpzListController@getAvpzListByUser']);
Route::post('/api/getLegalBase', 'LegalBaseController@getLegalBase');
Route::post('/api/getQuestionsAnswers', 'QuestionsAnswersController@getQuestionsAnswers');

//admin methods
Route::post('/api/createOrUpdateUser', ['middleware' => 'apiAuth', 'uses' => 'UsersController@createOrUpdateUser']);
Route::post('/api/findUsers', ['middleware' => 'apiAuth', 'uses' => 'UsersController@findUsers']);
Route::post('/api/setActive', ['middleware' => 'apiAuth', 'uses' => 'UsersController@setActive']);
Route::post('/api/deleteAvpz', ['middleware' => 'apiAuth', 'uses' => 'AvpzListController@deleteAvpz']);
Route::post('/api/createOrUpdateAvpz', ['middleware' => 'apiAuth', 'uses' => 'AvpzListController@createOrUpdateAvpz']);
Route::post('/api/deleteFiles',  ['middleware' => 'apiAuth', 'uses' => 'AvpzListController@deleteFiles']);
Route::post('/api/getFilesList', ['middleware' => 'apiAuth', 'uses' => 'AvpzListController@getFilesList']);
Route::post('/api/createOrUpdateUrgentMsg', ['middleware' => 'apiAuth', 'uses' => 'UrgentMessagesController@createOrUpdateUrgentMsg']);
Route::post('/api/deleteUrgentMsg', ['middleware' => 'apiAuth', 'uses' => 'UrgentMessagesController@deleteUrgentMsg']);
Route::post('/api/publishUrgentMsg', ['middleware' => 'apiAuth', 'uses' => 'UrgentMessagesController@publishUrgentMsg']);
Route::post('/api/getUrgentMsgList', ['middleware' => 'apiAuth', 'uses' => 'UrgentMessagesController@getUrgentMsgList']);
Route::post('/api/adminMailRequest', ['middleware' => 'apiAuth', 'uses' => 'UrgentMessagesController@adminMailRequest']);
Route::post('/api/createOrUpdateQuestionsAnswers', ['middleware' => 'apiAuth', 'uses' => 'QuestionsAnswersController@createOrUpdateQuestionsAnswers']);
Route::post('/api/deleteQuestionsAnswers', ['middleware' => 'apiAuth', 'uses' => 'QuestionsAnswersController@deleteQuestionsAnswers']);
Route::post('/api/createOrUpdateLegalBase', ['middleware' => 'apiAuth', 'uses' => 'LegalBaseController@createOrUpdateLegalBase']);
Route::post('/api/deleteLegalBase', ['middleware' => 'apiAuth', 'uses' => 'LegalBaseController@deleteLegalBase']);
Route::post('/api/uploadLegalBaseAttachment', ['middleware' => 'apiAuth', 'uses' => 'LegalBaseController@uploadLegalBaseAttachment']);
Route::post('/api/getAllAvpzVendors', ['middleware' => 'apiAuth', 'uses' => 'AvpzVendorController@getAllAvpzVendors']);
Route::post('/api/createOrUpdateAvpzVendor', ['middleware' => 'apiAuth', 'uses' => 'AvpzVendorController@createOrUpdateAvpzVendor']);
Route::post('/api/deleteAvpzVendor', ['middleware' => 'apiAuth', 'uses' => 'AvpzVendorController@deleteAvpzVendor']);
Route::post('/api/getAllAvpzNomenclatureUser', 'AvpzNumenclatureController@getAllAvpzNomenclatureUser');
Route::post('/api/getAllAvpzNomenclature', ['middleware' => 'apiAuth', 'uses' => 'AvpzNumenclatureController@getAllAvpzNomenclature']);
Route::post('/api/createOrUpdateAvpzNomenclature', ['middleware' => 'apiAuth', 'uses' => 'AvpzNumenclatureController@createOrUpdateAvpzNomenclature']);
Route::post('/api/deleteAvpzNomenclature', ['middleware' => 'apiAuth', 'uses' => 'AvpzNumenclatureController@deleteAvpzNomenclature']);
Route::post('/api/getUserCreationInfo', ['middleware' => 'apiAuth', 'uses' => 'StatisticsController@getUserCreationInfo']);
Route::post('/api/getCountGovOrganizations', ['middleware' => 'apiAuth', 'uses' => 'StatisticsController@getCountGovOrganizations']);
Route::post('/api/getActiveUsers', ['middleware' => 'apiAuth', 'uses' => 'StatisticsController@getActiveUsers']);
Route::post('/api/getRegionsList', ['middleware' => 'apiAuth', 'uses' => 'StatisticsController@getRegionsList']);
Route::post('/api/getGovOrganizationList', ['middleware' => 'apiAuth', 'uses' => 'GovernmentController@getGovOrganizationList']);
Route::post('/api/createGovOrganization', ['middleware' => 'apiAuth', 'uses' => 'GovernmentController@createGovOrganization']);


