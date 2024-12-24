<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Backend\TaxesController;
use App\Http\Controllers\Backend\OrdersController;
use App\Http\Controllers\Backend\TopicsController;
use App\Http\Controllers\Backend\CoursesController;
use App\Http\Controllers\Backend\RepliesController;
use App\Http\Controllers\Backend\ThreadsController;
use App\Http\Controllers\Backend\InvoicesController;
use App\Http\Controllers\backend\ProfilesController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\QuestionsController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\FavouritesController;
use App\Http\Controllers\Backend\CourseChaptersController;
use App\Http\Controllers\Frontend\PracticeTestsController;
use App\Http\Controllers\Backend\CourseChapterContentsController;
use App\Http\Controllers\Backend\MenuAndFooterController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\SectionViewsController;
use App\Http\Controllers\Backend\SectionsController;
use App\Http\Controllers\Backend\CollectionsController;
use App\Http\Controllers\Backend\ThreadSubscriptionsController;
use App\Http\Controllers\Backend\UserNotificationsController;
use App\Http\Controllers\Backend\FlagsController;
use App\Http\Controllers\Backend\ChannelsController;
use App\Http\Controllers\Backend\UserTestsController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\DiscountsController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Frontend\TakeTestsController;
use App\Http\Controllers\Backend\CommentController;

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

Route::get('/get-id-encrypted', function(Request $request){
    $id = $request->id;
    return \Crypt::encrypt($id);
});

/**
 * Dashboard route for the application.
 */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/**
 * All backend routes prefixed with backend.
 */
Route::prefix('/backend')->group(function () {
    /**
     * Tax related routes.
     */
    Route::resource('/tax', TaxesController::class)->only(['index', 'edit', 'update']);

    /**
     * Topic related routes.
     */
    Route::resource('/topic', TopicsController::class)->except(['show']);

    /**
     * Course related routes.
     */
    Route::resource('/course', CoursesController::class)->except(['show', 'destroy']);
    Route::get('/course-excel', [CoursesController::class, 'fetchCourseExcel'])->name('course.excel.upload');
    Route::post('/course-excel', [CoursesController::class, 'uploadCourseExcel']);

    /**
     * Chapter related routes.
     */
    Route::resource('/course/{course}/chapter', CourseChaptersController::class);
    Route::get('/chapter-excel', [CourseChaptersController::class, 'fetchChapterExcel'])->name('chapter.excel.upload');
    Route::post('/chapter-excel', [CourseChaptersController::class, 'uploadChapterExcel']);

    /**
     * Content Related route
     */
    Route::get('/course/{course}/chapter/content', [CourseChapterContentsController::class, 'index'])->name('show');
    Route::get('/course/{course}/chapter/{chapter}/content', [CourseChapterContentsController::class, 'index'])->name('content.index');

    /**
    *Content Create route
    */
    Route::get('/course/{course}/chapter/{chapter}/content/create', [CourseChapterContentsController::class, 'create'])->name('content.create');

    /**
    *Content Store route
    */
    Route::post('/course/{course}/chapter/{chapter}/content', [CourseChapterContentsController::class, 'store'])->name('content.store');

    /**
     * Question related routes.
     */
    Route::resource('/question', QuestionsController::class);
    Route::post('/search-questions', [QuestionsController::class, 'search']);
    Route::get('/question-excel', [QuestionsController::class, 'fetchQuestionExcel'])->name('question.excel.upload');
    Route::post('/question-excel', [QuestionsController::class, 'uploadQuestionExcel']);

    /**
     * Order related routes.
     */
    Route::get('/order', [OrdersController::class, 'index'])->name('order.index');
    Route::get('/order/checkout/{course}', [OrdersController::class, 'checkout'])->name('order.checkout');
    Route::post('/order', [OrdersController::class, 'store']);
    Route::post('/order/payment/response', [OrdersController::class, 'paymentResponse']);
    Route::get('/order/{order}/details', [OrdersController::class, 'details'])->name('order.details');

    /**
     * Invoice related routes
     */
    Route::get('/invoice', [InvoicesController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/{invoice}/details', [InvoicesController::class, 'details'])->name('invoice.details');
    Route::get('/invoice/{invoice}/download', [InvoicesController::class, 'download'])->name('invoice.download');

    /**
     * Test related routes.
     */
    Route::get('/course/{course}/test-details', [CoursesController::class, 'editTestDetails'])->name('test.details.edit');
    Route::patch('/course/{course}/test-details', [CoursesController::class, 'updateTestDetails']);

    /**
     * Menu and Footer related routes.
     */
    Route::get('/menu', [MenuAndFooterController::class, 'indexMenuItem'])->name('menu.index');
    Route::get('/menu/create', [MenuAndFooterController::class, 'createMenuItem'])->name('menu.create');
    Route::post('/menu', [MenuAndFooterController::class, 'storeMenuItem']);
    Route::get('/menu/{menu}/edit', [MenuAndFooterController::class, 'editMenuItem'])->name('menu.edit');
    Route::patch('/menu/{menu}', [MenuAndFooterController::class, 'updateMenuItem']);
    Route::get('/menu/{menu}/move-up', [MenuAndFooterController::class, 'moveUpMenuItem'])->name('menu.move.up');
    Route::get('/menu/{menu}/move-down', [MenuAndFooterController::class, 'moveDownMenuItem'])->name('menu.move.down');
    Route::delete('/menu/{menu}', [MenuAndFooterController::class, 'destroyMenuItem'])->name('menu.destroy');
    Route::get('/footer', [MenuAndFooterController::class, 'editFooter'])->name('footer.edit');
    Route::patch('/footer/{footerObj}', [MenuAndFooterController::class, 'updateFooter']);

    /**
     * Pages related routes.
     */
    Route::resource('/page', PagesController::class)->except(['show']);
    Route::patch('/page/{page}/update-meta-information', [PagesController::class, 'updateMetaInformation'])->name('page.update.meta');

    /*
    ** Banner
    */
    Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
    Route::get('/banner/add', [BannerController::class, 'create'])->name('banner.create');
    Route::post('/banner/save', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/banner/edit/{banner}', [BannerController::class, 'edit'])->name('banner.edit');
    Route::post('/banner/update/{banner}', [BannerController::class, 'update'])->name('banner.update');
    Route::delete('/banner/delete/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');


    /**
     * Comment (Reported)
     */
    Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
    Route::delete('/comment/delete/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    /**
     * Section views related routes.
     */
    Route::resource('/section-view', SectionViewsController::class)->except(['show']);

    /**
     * Sections related routes.
     */
    Route::get('/{type}/{typeId}/section', [SectionsController::class, 'create'])->name('section.create');
    Route::post('/{type}/{typeId}/section', [SectionsController::class, 'store'])->name('section.store');
    Route::get('/{type}/section/{section}/edit', [SectionsController::class, 'edit'])->name('section.edit');
    Route::patch('/section/{section}', [SectionsController::class, 'update'])->name('section.update');
    Route::get('/section/{section}/move-up', [SectionsController::class, 'moveUp'])->name('section.move.up');
    Route::get('/section/{section}/move-down', [SectionsController::class, 'moveDown'])->name('section.move.down');
    Route::delete('/{type}/section/{section}/destroy', [SectionsController::class, 'destroy'])->name('section.destroy');
    Route::post('/section/{section}/add-banner-for-page', [SectionsController::class, 'addBannerForPage'])->name('section.add.banner.for.page');
    Route::post('/section/{section}/add-faq', [SectionsController::class, 'addFaq'])->name('section.add.faq');

    /**
     * Collections related routes.
     */
    Route::get('/section/{section}/collection/{item}/move-up', [CollectionsController::class, 'moveUp'])->name('collection.item.move.up');
    Route::get('/section/{section}/collection/{item}/move-down', [CollectionsController::class, 'moveDown'])->name('collection.item.move.down');
    Route::delete('/section/{section}/destroy-collection-item/{item}', [CollectionsController::class, 'destroyCollectionItem'])->name('collection.item.destroy');
    Route::resource('/collection', CollectionsController::class)->except(['show']);
    Route::get('/collection/{collection}/item/{item}/move-up', [CollectionsController::class, 'moveUpDirect'])->name('collection.item.move.up.direct');
    Route::get('/collection/{collection}/item/{item}/move-down', [CollectionsController::class, 'moveDownDirect'])->name('collection.item.move.down.direct');
    Route::delete('/collection/{collection}/destroy-collection-item/{item}', [CollectionsController::class, 'destroyCollectionItemDirect'])->name('collection.item.destroy.direct');
    Route::post('/collection/{collection}/items', [CollectionsController::class, 'storeItem'])->name('collection.item.store');

    /**
     * Ask Expert related routes.
     */
    Route::get('/enquiry', [DashboardController::class, 'enquiryIndex'])->name('enquiry.index');

    /**
     * Flagging related routes.
     */
    Route::get('/flagged-replies', [DashboardController::class, 'flaggedRepliesIndex'])->name('flagged.replies.index');

    /**
     * Channel related routes.
     */
    Route::resource('/channel', ChannelsController::class)->except(['show']);

    /**
     * Update user from dashboard route.
     */
    Route::post('update-user', [DashboardController::class, 'updateUser'])->name('user.update');

    /**
     * User related routes for administrator.
     */
    Route::get('user', [UsersController::class, 'index'])->name('user.index');
    Route::post('/search-users', [UsersController::class, 'search']);
    Route::get('/user/{user}/change-status', [UsersController::class, 'changeStatus'])->name('user.change.status');
    Route::get('/userDetailsDownloadCsv', [UsersController::class, 'userDetailsDownloadCsv'])->name('userDetailsDownloadCsv');
    Route::get('/allUserDetailsDownloadCsv', [UsersController::class, 'allUserDetailsDownloadCsv'])->name('allUserDetailsDownloadCsv');

    /**
     * Discount related routes.
     */
    Route::resource('/discount', DiscountsController::class)->except(['show']);
});

/**
 * API routes.
 */
Route::prefix('/api')->group(function () {
    /**
     * Check username, phone number and email related routes.
     */
    Route::post('check-username', [APIController::class, 'checkUsername'])->name('check-username');
    Route::post('check-phone-number', [APIController::class, 'checkPhoneNumber'])->name('check-phone-number');
    Route::post('check-email', [APIController::class, 'checkEmail'])->name('check-email');

    /**
     * Chapters by course route.
     */
    Route::post('get-chapters-by-course-id', [APIController::class, 'getChaptersByCourseId'])->name('get-chapters-by-course-id');

    /**
     * Questions by practice test route.
     */
    Route::post('get-questions-by-practice-test-id', [APIController::class, 'getQuestionsByPracticeTestId'])->name('get-questions-by-practice-test-id');
    
    /**
     * Update practice test question route.
     */
    Route::post('update-practice-test-question-by-id', [APIController::class, 'updatePracticeTestQuestionById'])->name('update-practice-test-question-by-id');

    /**
     * Save notes for practice test
     */
    Route::post('save-note-practice-test', [APIController::class, 'saveNotePracticeTest'])->name('save-note-practice-test');
    Route::post('report-comment', [APIController::class, 'report_comment'])->name('report-comment');



    /**
     * Questions by take test route.
     */
    Route::post('get-take-test-qn-by-id', [APIController::class, 'get_take_test_qn_by_id'])->name('get-take-test-qn-by-id');
    Route::post('save-answer-take-test-by-id', [APIController::class, 'save_answer_take_test_by_id'])->name('save-answer-take-test-by-id');
   
    /**
     * OTP related routes.
     */
    Route::post('send-otp', [APIController::class, 'sendOTP'])->name('send-otp');
    Route::post('verify-otp', [APIController::class, 'verifyOTP'])->name('verify-otp');

    /**
     * Update user route.
     */
    Route::post('update-user', [APIController::class, 'updateUser'])->name('update-user');

    /**
     * Total questions by the chapters, difficulty and type route.
     */
    Route::post('get-total-questions-by-chapters-difficulty-and-type', [APIController::class, 'getTotalQuestionsByChaptersDifficultyAndType'])->name('get-total-questions-by-chapters-difficulty-and-type');

    /**
     * Comments related routes.
     */
    Route::post('get-comments-by-question-id', [APIController::class, 'getCommentsByQuestionId'])->name('get-comments-by-question-id');
    Route::post('save-comment-by-practice-test-question-id', [APIController::class, 'saveCommentByPracticeTestQuestionId'])->name('save-comment-by-practice-test-question-id');

    /**
     * Questions by user test route.
     */
    Route::post('get-questions-by-user-test-id', [APIController::class, 'getQuestionsByUserTestId'])->name('get-questions-by-user-test-id');

    /**
     * Update user test question route.
     */
    Route::post('update-user-test-question-by-id', [APIController::class, 'updateUserTestQuestionById'])->name('update-user-test-question-by-id');

    /**
     * Check discount code related routes.
     */
    Route::post('check-discount-code', [APIController::class, 'checkDiscountCode'])->name('check-discount-code');
});

/**
 * Frontend related routes.
 */
Route::get('/beta', [FrontendController::class, 'home'])->name('home');
// Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about.us');
// Route::get('/courses', [FrontendController::class, 'courses'])->name('courses');
// Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
// Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('contact.us');
Route::get('/privacy-policy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [FrontendController::class, 'terms'])->name('terms');
Route::get('/course/{course:slug}', [FrontendController::class, 'courseBySlug'])->name('single.course');
Route::post('/enquiry', [FrontendController::class, 'enquiry']);

/**
 * Practice Test Routes
 */
Route::get('/course/{course:slug}/practice', [PracticeTestsController::class, 'create'])->name('practice.test.create');
Route::post('/course/{course:slug}/practice', [PracticeTestsController::class, 'store']);
Route::get('/course/{course:slug}/practice/{practice}', [PracticeTestsController::class, 'show'])->name('practice.test.show');
Route::get('/course/{course:slug}/practice/{practice}/finish', [PracticeTestsController::class, 'finish'])->name('practice.test.finish');
Route::get('/course/{course:slug}/practice/{practice}/result', [PracticeTestsController::class, 'result'])->name('practice.test.result');

/**
 * Take Test Routes
 */
Route::get('/course/{course:slug}/take-test', [TakeTestsController::class, 'create'])->name('take.test.create');
Route::get('/course/{course:slug}/take-test/{take}', [TakeTestsController::class, 'show'])->name('take.test.show');
Route::get('/course/{course:slug}/take-test/{take}/finish', [TakeTestsController::class, 'finish'])->name('take.test.finish');
Route::get('/course/{course:slug}/take/{take}/result', [TakeTestsController::class, 'result'])->name('take.test.result');

/**
 * Course Test Routes
 */
Route::get('/course/{course:slug}/test', [UserTestsController::class, 'create'])->name('user.test.create');
Route::get('/course/{course:slug}/test/{test}', [UserTestsController::class, 'show'])->name('user.test.show');
Route::get('/course/{course:slug}/test/{test}/finish', [UserTestsController::class, 'finish'])->name('user.test.finish');
Route::get('/course/{course:slug}/test/{test}/result', [UserTestsController::class, 'result'])->name('user.test.result');

/**
 * Redirection route for logging in of the user.
 */
Route::get('/logging-in/{user}', [FrontendController::class, 'logUserInByPhoneNumber'])->name('user.loggingin');

require __DIR__.'/auth.php';

/**
 * Forum routes.
 */
Route::get('forum', [ThreadsController::class, 'index'])->name('threads.index');
Route::post('/forum', [ThreadsController::class, 'store'])->name('threads.store');
Route::post('/forum-search', [ThreadsController::class, 'search'])->name('threads.search');
Route::prefix('/forum')->group(function () {
    Route::delete('/replies/{reply}', [RepliesController::class, 'destroy'])->name('reply.destroy');
    Route::get('/create', [ThreadsController::class, 'create'])->name('threads.create');
    Route::get('/{channel}/{thread}', [ThreadsController::class, 'show'])->name('thread.show');
    Route::delete('/{channel}/{thread}', [ThreadsController::class, 'destroy'])->name('thread.destroy');
    Route::get('/{channel}', [ThreadsController::class, 'index'])->name('thread.channel.index');
    Route::post('/{channel}/{thread}/replies', [RepliesController::class, 'store']);
    Route::post('/replies/{reply}/favourites', [FavouritesController::class, 'store']);
    Route::delete('/replies/{reply}/favourites', [FavouritesController::class, 'destroy']);
    Route::patch('/replies/{reply}', [RepliesController::class, 'update']);

    /**
     * Subscription related routes
     */
    Route::post('/{channel:slug}/{thread}/subscription', [ThreadSubscriptionsController::class, 'store'])->name('thread.subscribe');
    Route::delete('/{channel:slug}/{thread}/subscription', [ThreadSubscriptionsController::class, 'destroy'])->name('thread.unsubscribe');

    /**
     * Flagging related routes
     */
    Route::post('/replies/{reply}/flags', [FlagsController::class, 'store']);
    Route::post('/threads/{thread}/flags', [FlagsController::class, 'storeThreadFlag']);
});

/**
 * Profile route
 */
Route::get('/profiles/{username:username}', [ProfilesController::class, 'show'])->name('user.profile');

/**
 * Notification related routes
 */
Route::get('/profiles/{user:username}/notifications', [UserNotificationsController::class, 'index']);
Route::get('/profiles/{user:username}/notifications/{notification}', [UserNotificationsController::class, 'destroy'])->name('notification.destroy');

Route::get('/{page:slug}', [FrontendController::class, 'showPage'])->name('frontend.page.show');

Route::get('/run-test-script', function(){
    echo 'Run Test Script';
});