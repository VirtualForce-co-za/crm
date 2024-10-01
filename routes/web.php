<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstancesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\AgentResponsesController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\DispositionsController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('addinstance', function () {return view('instance/addinstance');})->name('addinstance');
    Route::post('/addinstancesubmit', [InstancesController::class, 'addinstancesubmit'])->name('addinstancesubmit');
    Route::get('/editinstance', [InstancesController::class, 'editinstance'])->name('editinstance');
    Route::post('/editinstancesubmit', [InstancesController::class, 'editinstancesubmit'])->name('editinstancesubmit');
    Route::get('/instances', [InstancesController::class, 'instances'])->name('instances');

    Route::get('adddisposition', function () {return view('disposition/adddisposition');})->name('adddisposition');
    Route::post('/adddispositionsubmit', [DispositionsController::class, 'adddispositionsubmit'])->name('adddispositionsubmit');
    Route::get('/editdisposition', [DispositionsController::class, 'editdisposition'])->name('editdisposition');
    Route::post('/editdispositionsubmit', [DispositionsController::class, 'editdispositionsubmit'])->name('editdispositionsubmit');
    Route::get('/dispositions', [DispositionsController::class, 'dispositions'])->name('dispositions');

    Route::get('/users', [UsersController::class, 
    'users'])->name('users');

    Route::get('/adduser', [UsersController::class, 
    'adduser'])->name('adduser');

    Route::post('/addusersubmit', [UsersController::class, 
    'addusersubmit'])->name('addusersubmit');

    Route::post('/editusersubmit', [UsersController::class, 
    'editusersubmit'])->name('editusersubmit');

    Route::get('/edituser', [UsersController::class, 
    'edituser'])->name('edituser');

    Route::get('/agents', [AgentsController::class, 'agents'])->name('agents');
    Route::get('/addagent', [AgentsController::class, 'addagent'])->name('addagent');
    Route::post('/addagentsubmit', [AgentsController::class, 'addagentsubmit'])->name('addagentsubmit');
    Route::post('/editagentsubmit', [AgentsController::class, 'editagentsubmit'])->name('editagentsubmit');
    Route::get('/editagent', [AgentsController::class, 'editagent'])->name('editagent');

    Route::get('/agentresponses', [AgentResponsesController::class, 'agentresponses'])->name('agentresponses');
    Route::get('/addagentresponse', [AgentResponsesController::class, 'addagentresponse'])->name('addagentresponse');
    Route::post('/addagentresponsesubmit', [AgentResponsesController::class, 'addagentresponsesubmit'])->name('addagentresponsesubmit');
    Route::get('/editagentresponse', [AgentResponsesController::class, 'editagentresponse'])->name('editagentresponse');
    Route::post('/editagentresponsesubmit', [AgentResponsesController::class, 'editagentresponsesubmit'])->name('editagentresponsesubmit');

    Route::get('/campaigns', [CampaignsController::class, 'campaigns'])->name('campaigns');
    Route::get('/addcampaign', [CampaignsController::class, 'addcampaign'])->name('addcampaign');
    Route::post('/addcampaignsubmit', [CampaignsController::class, 'addcampaignsubmit'])->name('addcampaignsubmit');
    Route::get('/editcampaign', [CampaignsController::class, 'editcampaign'])->name('editcampaign');
    Route::post('/editcampaignsubmit', [CampaignsController::class, 'editcampaignsubmit'])->name('editcampaignsubmit');
    Route::get('/actioncampaign', [CampaignsController::class, 'actioncampaign'])->name('actioncampaign');
    

});
