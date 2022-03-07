<?php


Route::view('/', 'frontend.pages.home');

Route::get('/home', function () {

    if (session('status')) {

        return redirect()->route('admin.loan-applications.index')->with('status', session('status'));
        // return redirect()->route('admin.dashboard');
    }

    //return redirect()->route('admin.loan-applications.index');
    return redirect()->route('admin.dashboard');

});

Route::get('/index', 'Front\FrontendController@index')->name('index');
Route::get('/about', 'Front\FrontendController@about')->name('about');
Route::get('/products', 'Front\FrontendController@products')->name('products');
Route::get('/resources', 'Front\FrontendController@resources')->name('resources');
Route::get('/contact', 'Front\FrontendController@contact')->name('contact');
Route::get('/team', 'Front\FrontendController@team')->name('team');

//file download
Route::get('files/{uuid}/download', 'Front\FrontendController@download')->name('files.download');

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth' ,'twostep']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('users/{id}/disable', 'UsersController@disableUser')->name('users.disable');
    Route::post('users/{user}/update', 'UsersController@updateUserProfile')->name('users.update.profile');
    Route::get('users/{user}/profile', 'UsersController@getUserProfile')->name('users.profile');

    //admin only update
    Route::get('admin/{user}/profile', 'UsersController@getAdminProfile')->name('admin.profile');
    Route::post('admin/{user}/update', 'UsersController@updateAdminProfile')->name('admin.update.profile');
    Route::post('admin/image/update', 'UsersController@updateAdminProfileImage')->name('image.update');

    // Statuses
    Route::delete('statuses/destroy', 'StatusesController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusesController');

    // Loan Applications
    Route::get('loan-applications/staff/create', 'LoanApplicationsController@staffCreate')->name('staff.loanapplications');
    Route::delete('loan-applications/destroy', 'LoanApplicationsController@massDestroy')->name('loan-applications.massDestroy');
    Route::get('loan-applications/{loan_application}/analyze', 'LoanApplicationsController@showAnalyze')->name('loan-applications.showAnalyze');
    Route::post('loan-applications/{loan_application}/analyze', 'LoanApplicationsController@analyze')->name('loan-applications.analyze');
    Route::get('loan-applications/{loan_application}/send', 'LoanApplicationsController@showSend')->name('loan-applications.showSend');
    Route::post('loan-applications/{loan_application}/send', 'LoanApplicationsController@send')->name('loan-applications.send');
    Route::resource('loan-applications', 'LoanApplicationsController');

    //download loan files
    Route::get('/loans/pdf/{id}', 'LoanApplicationsController@createPdf')->name('loans.pdf');

    //Make loan Payment request
    Route::post('/loan-application-repayment','LoanApplicationsController@makeRepaymentAmount')->name('loan-applications.repay');

    //Make Partial Loan Rejection
    Route::post('/loan-application-rejection','LoanApplicationsController@partialLoanRequestRejection')->name('loan-applications.reject.partialy');

    //Update Loan Amount After Loan Rejection
    Route::post('/loan-application-amount-update','LoanApplicationsController@memberNewLoanAmountChoice')->name('loan-applications.rejected.update');

    Route::get('status/active/loan-applications', 'LoanApplicationsController@activeLoans')->name('active.loans');
    Route::get('status/cleared/loan-applications', 'LoanApplicationsController@clearedLoans')->name('cleared.loans');
    Route::get('status/rejected/loan-applications', 'LoanApplicationsController@rejectedLoans')->name('rejected.loans');
    Route::get('status/loan-applications/defaultors', 'LoanApplicationsController@defaultors')->name('defaultors');

    //bulck upload details
    Route::get('status/loan-applications/bulk-update', 'LoanApplicationsController@bulkView')->name('bulkView');
    Route::post('status/loan-applications/bulk-file', 'LoanApplicationsController@bulkFile')->name('bulkFile');
    Route::get('status/loan-applications/bulk/load-file', 'LoanApplicationsController@fetchDatatable')->name('loadFile');
    Route::get('status/loan-applications/bulk/load-file-Mo', 'LoanApplicationsController@fetchDatatableMo')->name('loadFileMo');
    Route::post('bulk/loan-applications/bulk/update', 'LoanApplicationsController@updateBulkFileDetails')->name('updatefileuploaddetails');
    Route::post('bulk/loan-applications/bulk/delete', 'LoanApplicationsController@deleteBulkFileDetails')->name('deletefileuploaddetails');
    Route::get('delete/loan-applications/files', 'LoanApplicationsController@deletePendingFile')->name('delete.pending.file');
    Route::get('download/file-templates', 'LoanApplicationsController@downloadMonthlyAndLoanTemplates')->name('template.download');

    // Comments
    Route::delete('comments/destroy', 'CommentsController@massDestroy')->name('comments.massDestroy');
    Route::resource('comments', 'CommentsController');

    //file upload
    Route::post('files/upload', 'HomeController@store')->name('files.store');
    Route::get('files/create', 'HomeController@createfile')->name('files.create');

    //show individual user details
    Route::get('user/show', 'UsersController@getUser')->name('user.show');

    //files download from the user
    Route::get('files/{uuid}/download', 'UsersController@download')->name('files.download');

    //update monthly contribution
    Route::post('/updatemonthlycontribution','UsersController@updateMonthlyContribution')->name('monthly.update');

    //update monthly contribution amount
    Route::post('/updatemonthlycontributionamount','UsersController@updateMonthlyContributionAmount')->name('monthly.update.amount');

    //get pdf for statements
    Route::get('/users/pdf/{id}', 'UsersController@createPdf')->name('users.pdf');
    Route::get('/user/statements', 'UsersController@memberStatements')->name('user.statements');
    Route::get('/user/forms', 'UsersController@memberForms')->name('user.forms');
    Route::get('/user/loans', 'UsersController@memberLoans')->name('user.loans');

    //notification routes and gurantor request reject or approve using ajax
    Route::post('/mark-as-read', 'HomeController@markNotification')->name('markNotification');
    Route::post('/mark-gurantor-request', 'HomeController@requestGurantor')->name('requestGurantor');
    Route::get('/view/notifications', 'HomeController@notifications')->name('viewnotification');

    //loan application request
    Route::post('/loan/request', 'CreateLoanRequestController@create')->name('loanRequest');
    Route::post('/loan/request/update', 'CreateLoanRequestController@update')->name('updateLoanRequest');
    //ajax get first 3 characters for users
    Route::get('autocomplete', 'CreateLoanRequestController@autocomplete')->name('autocomplete');

});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', 'twostep']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
