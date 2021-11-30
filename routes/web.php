<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Model\question;
use App\Model\comment;
use App\Model\banner;

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

/* 메인화면 */
Route::get('/', function () {
    $product = App\Model\product_list::selectRaw('product_list.*, tag')
                                     ->where([['category.status', 0], ['product_list.status', 0]])
                                     ->leftjoin('category', 'category.id', '=', 'product_list.category_id')
                                     ->orderBy('product_list.id', 'desc')
                                     ->limit(8)
                                     ->get();
    $banner = banner::get();

    return view('main', ['product' => $product, 'banner' => $banner]);
});


/* 고객용 */
/* 검색 Page */
Route::resource('/search', 'searchController');
/* 공지사항 */
Route::resource('/notice', 'NoticeController');
/* 제품 */
Route::resource('/product', 'ProductController');
/* 견적문의 */
Route::resource('/question', 'QuestionController');

// 비밀글 확인
Route::get('/password', 'PasswordCheckController@index');
// 비밀글 확인 API
Route::post('/password', 'PasswordCheckController@check');

// 댓글작성
Route::post('/comment', 'CommentController@create');
// 댓글삭제
Route::post('/comment/del', 'CommentController@delete');


/* 관리자 */
/* 배너 수정 */
Route::resource('/banner', 'BannerController');
/* 관리자 로그인 */
Route::get('/login', 'LoginController@index')->middleware('guest');
Route::post('/login', 'LoginController@login')->middleware('guest');
Route::get('/logout', 'LoginController@logout')->middleware('auth');
