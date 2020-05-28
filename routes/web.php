<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/dashboard', 'MainController@dashboard')->name('dashboard')->middleware(['auth', 'verified']);

Route::middleware(['auth', 'can:view departments'])->group(function () {
    Route::resource('departments', 'DepartmentController', ['except' => 'show']);
});

Route::middleware(['auth', 'verified', 'admin.not'])->group(function () {
    Route::resource('/threads', 'MessengerController', ['except' => 'edit']);
});

Route::middleware(['auth', 'verified', 'can:view roles'])->group(function () {
    Route::resource('roles', 'RoleController', ['except' => 'show']);
    Route::get('/structure', 'RoleController@structure')->name('structure');
});

Route::get('/employees/avatars', 'EmployeeController@avatars')->name('employees.avatars')->middleware('auth');
Route::middleware(['auth', 'verified', 'can:view employees'])->group(function () {
    Route::get('/employees/details', 'EmployeeController@details')->name('employees.details');
    Route::resource('employees', 'EmployeeController');
});

Route::middleware(['auth', 'verified', 'can:manage settings'])->group(function () {
    Route::get('/settings', 'SettingController@edit')->name('settings.edit');
    Route::put('/settings/{setting}/update', 'SettingController@update')->name('settings.update');
});

Route::middleware(['auth', 'verified', 'can:view doc-types'])->group(function () {
    Route::resource('doc-types', 'DocTypeController');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('tasks', 'TaskController', ['except' => ['show', 'destroy']]);
    Route::get('/tasks/all', 'TaskController@indexAll')->name('tasks.all');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('teams', 'TeamController');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('documents', 'DocumentController', ['except' => 'edit']);
    Route::get('/documents/{docType}/fill', 'DocumentController@fill')->name('documents.fill');
    Route::get('/documents/{document}/approve', 'DocumentController@approve')->name('documents.approve');
    Route::get('/documents/{document}/resubmit', 'DocumentController@resubmit')->name('documents.resubmit');
});

Route::middleware(['auth', 'verified', 'can:manage profile-form'])->prefix('profile-form')->group(function () {
    Route::get('/fields', 'ProfileFormController@index')->name('profile.form.index');
    Route::post('/', 'ProfileFormController@store')->name('profile.form.store');
    Route::put('/{field}/update', 'ProfileFormController@update')->name('profile.form.update');
    Route::delete('/{field}', 'ProfileFormController@destroy')->name('profile.form.destroy');
});

Route::middleware(['auth', 'admin.not', 'verified'])->prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@show')->name('profile.show');
    Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('/update', 'ProfileController@update')->name('profile.update');
    Route::post('/update/avatar', 'ProfileController@updateAvatar')->name('profile.update-avatar');
});

Route::middleware(['auth', 'admin.not', 'verified'])->prefix('calendar')->group(function () {
    Route::get('/', 'CalendarController@index')->name('calendar.index');
    Route::post('/settings/{employee}', 'CalendarController@update')->name('calendar.settings.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('vacancies', 'VacancyController', ['except' => 'show']);
    Route::resource('applicants', 'JobApplicantController');
    Route::resource('interviews', 'InterviewController');
    Route::get('/interviews/{interview}/redeemables', 'InterviewController@createFeedback')->name('interviews.redeemables.create');
    Route::post('/interviews/{interview}/redeemables', 'InterviewController@storeFeedback')->name('interviews.redeemables.store');
    Route::get('/interviews/{interview}/view-redeemables', 'InterviewController@showFeedback')->name('interviews.redeemables.show');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('events', 'EventController', ['except' => ['create', 'edit']]);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('taxes', 'TaxesController', ['except' => 'show']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('bonuses', 'BonusesController', ['except' => 'show']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('non_taxable_income', 'NonTaxableIncomeController', ['except' => 'show']);
});

Route::middleware(['auth', 'admin.not'])->group(function () {
    Route::resource('time-trackers', 'TimeTrackerController', ['except' => ['edit', 'show']]);
    Route::get('/timesheet', 'TimeTrackerController@timesheet')->name('time-sheet');
});

Route::middleware(['auth', 'admin.not'])->group(function () {
    Route::resource('time-offs', 'TimeOffController', ['except' => ['create', 'show', 'edit', 'update']]);
    Route::get('/time-offs/manage', 'TimeOffController@manage')->name('time-offs.manage');
    Route::get('/time-offs/{timeOff}/approve', 'TimeOffController@approve')->name('time-offs.approve');
    Route::put('/time-offs/manage', 'TimeOffController@update')->name('time-offs.update');
});

Route::middleware(['auth', 'admin.not'])->group(function () {
    Route::resource('notifications', 'NotificationController', ['except' => ['create', 'show', 'edit']]);
    Route::get('/notifications/mark-as-read', 'NotificationController@readAll')->name('notifications.readAll');
});

Route::middleware(['auth', 'can:manage blog'])->group(function () {
    Route::resource('blog-posts', 'BlogPostController');
});

Route::middleware(['auth', 'can:create surveys'])->group(function () {
    Route::resource('surveys', 'SurveyController', ['except' => ['create']]);
    Route::get('/surveys/execute/{survey}', 'SurveyController@execute')->name('surveys.execute');
});

Route::middleware(['auth', 'can:create surveys'])->prefix('survey')->group(function () {
    Route::post('/{survey}/questions', 'QuestionController@store')->name('questions.store');
    Route::get('/{survey}/questions/{question}', 'QuestionController@show')->name('questions.show');
    Route::put('/questions/{question}', 'QuestionController@update')->name('questions.update');
    Route::delete('/{survey}/questions/{question}', 'QuestionController@destroy')->name('questions.destroy');
});

Route::middleware(['auth', 'verified', 'admin.not'])->prefix('user-surveys')->group(function () {
    Route::get('/', 'SurveyController@userIndex')->name('surveys.index.user');
    Route::get('/{survey}/pass', 'SurveyController@pass')->name('surveys.pass');
    Route::post('/{survey}/pass', 'SurveyController@storeResults')->name('surveys.pass.store');
});

Route::middleware(['auth', 'can:manage quizzes'])->group(function () {
    Route::resource('quizzes', 'QuizController');
    Route::get('/quiz-reports', 'QuizController@reports')->name('quizzes.reports.index');
    Route::get('/quiz-reports/{quiz}/{scope}', 'QuizController@reportsShow')
         ->name('quizzes.reports.show');
    Route::get('/quiz-reports/{quiz}/{scope}/{quizable}', 'QuizController@reportsShowQuizable')
         ->name('quizzes.reports.show.quizable');
    Route::prefix('/quiz-questions')->group(function () {
        Route::get('/', 'QuestionController@index')->name('quiz.questions.index');
        Route::get('/create', 'QuestionController@create')->name('quiz.questions.create');
        Route::post('/', 'QuestionController@store')->name('quiz.questions.store');
        Route::get('/{question}', 'QuestionController@showForQuiz')->name('quiz.questions.show');
        Route::get('/{question}/edit', 'QuestionController@edit')->name('quiz.questions.edit');
        Route::put('/{question}', 'QuestionController@update')->name('quiz.questions.update');
        Route::delete('/{question}', 'QuestionController@destroyForQuiz')->name('quiz.questions.destroy');
    });
});
Route::middleware(['auth', 'verified', 'admin.not'])->prefix('user-quizzes')->group(function () {
    Route::get('/', 'QuizController@userIndex')->name('quizzes.index.user');
    Route::get('/{quiz}/pass', 'QuizController@pass')->name('quizzes.pass');
    Route::post('/{quiz}/pass', 'QuizController@storeResults')->name('quizzes.pass.store');
});

Route::middleware(['auth', 'can:manage rewards'])->group(function () {
    Route::resource('redeemables', 'RedeemableController', ['except' => ['create', 'edit']]);
    Route::get('/redeemed', 'RedeemableController@manage')->name('redeemables.manage');
});
Route::middleware(['auth', 'verified', 'admin.not'])->group(function () {
    Route::get('/redeem', 'RedeemableController@userIndex')->name('redeemables.index.user');
    Route::put('/redeem/{redeemable}', 'RedeemableController@redeem')->name('redeemables.redeem');
    Route::get('/rewards', 'RewardController@index')->name('rewards.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
//    Route::resource('payroll', 'PayrollController', ['except' => 'show']);
    Route::get('/payroll', 'PayrollController@index')->name('payroll.index');
    Route::get('/payroll/generate', 'PayrollController@pickMonth')->name('payroll.generate');
    Route::post('/payroll/generate', 'PayrollController@generatePayroll');
    Route::post('/payroll/store', 'PayrollController@store')->name('payroll.store');
    Route::get('/payroll/show/{month}', 'PayrollController@show')->name('payroll.show');
    Route::get('/payroll/calculate_tax_details/{employee_id}/{tax_id}/{salary}', 'PayrollController@calculateTaxDetails');
});

Route::middleware(['auth', 'can:view reports'])->prefix('reports')->group(function () {
    Route::get('/', 'ReportController@index')->name('reports.index');
    Route::get('/{report}', 'ReportController@show')->name('reports.show');
    Route::post('/search', 'ReportController@search')->name('reports.search');
});

// Public routes
Route::get('/', 'MainController@index')->name('home');

Route::prefix('careers')->group(function () {
    Route::get('/', 'PublicPart\CareersController@index')->name('careers.index');
    Route::get('/{vacancy}', 'PublicPart\CareersController@show')->name('careers.show');
    Route::get('/apply/{vacancy}', 'PublicPart\CareersController@apply')->name('careers.apply');
    Route::post('/apply/{vacancy}', 'PublicPart\CareersController@store')->name('careers.store');
});

Route::prefix('blog')->group(function () {
    Route::get('/posts/{blogTag?}', 'PublicPart\BlogController@index')->name('blog.index');
    Route::get('/post/{blogPost}', 'PublicPart\BlogController@show')->name('blog.show');
    Route::post('/posts/search', 'PublicPart\BlogController@search')->name('blog.search');
});

Route::prefix('pass-quiz')->group(function () {
    Route::get('/{quiz}/{token}', 'QuizController@passPublic')->name('quizzes.public.pass');
    Route::post('/{quiz}/{applicant}', 'QuizController@storePublic')->name('quizzes.public.store');
});

//Route::get('mailable/docs/approve/{document}', function( Document $document ) {
//	return new App\Mail\DocumentForApprove($document);
//});
