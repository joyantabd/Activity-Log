## Custom User Log Activity in Laravel App <br>

After reviewing all codes, you can understand how it works and simple. we will manage log without using anymore package. In this ripo i created "log_activities" table with following column as listed bellow:

1)ID<br>
2)Subject<br>
3)URL<br>
4)Method<br>
5)IP<br>
6)Agent<br>
7)user_id<br>
8)created_at<br>
9)updated_at<br>

As listed above fields. I always put on log, so you can simply modify table structure and add new fields. I create LogActivity helper for put on log helper. So just follow few step and get very basic example of keep log activity.
After creating successfully this example, you will have layout as like bellow screen shot.


## Step 1 : Install Laravel Fresh Application

we are going from scratch, So we require to get fresh Laravel application using bellow command, So open your terminal OR command prompt and run bellow command:

```composer create-project --prefer-dist laravel/laravel blog```

## Step 2: Database Configuration

In this step we have to make database configuration for example database name, username, password etc. So let's open .env file and fill all details like as bellow:

## .env

```
DB_CONNECTION=mysql<br>
DB_HOST=127.0.0.1<br>
DB_PORT=3306<br>
DB_DATABASE=here your database name(blog)<br>
DB_USERNAME=here database username(root)<br>
DB_PASSWORD=here database password(root)<br>
```

## Step 3: Create LogActivity Table and Model

In this step we have to create migration for log_activities table using Laravel 5.4 php artisan command, so first fire bellow command:

 ``` php artisan make:migration create_log_activity_table```

After this command you will find one file in following path database/migrations and you have to put bellow code in your migration file for create contactus table.

```
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateLogActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->string('url');
            $table->string('method');
            $table->string('ip');
            $table->string('agent')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_activities');
    }
}
```

Now run above migration by following command:

```php artisan migrate```

After creating table we have to create model for "log_activities" table so just run bellow command and create new model:

```php artisan make:model LogActivity```

Ok, so after run bellow command you will find app/LogActivity.php and put bellow content in LogActivity.php file:

app/LogActivity.php

```
<?php
namespace App;
use Illuminate\Database\Eloquent\Model;


class LogActivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id'
    ];
}

```
## Step 4: Create LogActivity Helper Class

In this step we will create new directory "Helpers" in App directory. After created Helpers folder we require to create create LogActivity.php file and put bellow code:

app/Helpers/LogActivity.php

```
<?php


namespace App\Helpers;
use Request;
use App\LogActivity as LogActivityModel;


class LogActivity
{


    public static function addToLog($subject)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogActivityModel::create($log);
    }


    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }


}

```

## Step 5: Register Helper Class

In this step we have to register Helper class as facade in configuration file. So let's open app.php file and add Helper facade with load class. open app.php file and add bellow Helper facade line.

config/app.php
```
....

'aliases' => [

	....

	'LogActivity' => App\Helpers\LogActivity::class,

]
```
## Step 6: Add Route

In this step we will add two new routes. i added "add-to-log" route for testing you can simply use addToLog() with subject title like you can add "User created Successfully", "User updated successfully" etc subject as argument. another route for listing on user activity logs what was did by user. So let's add bellow two route.

routes/web.php
```
Route::get('add-to-log', 'HomeController@myTestAddToLog');
Route::get('logActivity', 'HomeController@logActivity');
```
## Step 7: Add Controller Method

In this step, we will add new two methods in HomeController file. i write how to add log on logs table and listing. So let's add bellow code.

app/Http/Controllers/HomeController.php
```
<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTestAddToLog()
    {
        \LogActivity::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('logActivity',compact('logs'));
    }
}
```
## Step 8: Add View File

In last step, we will create logActivity.blade.php file for display all logs with details form table. So let's copy from bellow code and put.

resources/views/logActivity.php
```
<!DOCTYPE html>
<html>
<head>
	<title>Log Activity Lists</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>


<div class="container">
	<h1>Log Activity Lists</h1>
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Subject</th>
			<th>URL</th>
			<th>Method</th>
			<th>Ip</th>
			<th width="300px">User Agent</th>
			<th>User Id</th>
			<th>Action</th>
		</tr>
		@if($logs->count())
			@foreach($logs as $key => $log)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $log->subject }}</td>
				<td class="text-success">{{ $log->url }}</td>
				<td><label class="label label-info">{{ $log->method }}</label></td>
				<td class="text-warning">{{ $log->ip }}</td>
				<td class="text-danger">{{ $log->agent }}</td>
				<td>{{ $log->user_id }}</td>
				<td><button class="btn btn-danger btn-sm">Delete</button></td>
			</tr>
			@endforeach
		@endif
	</table>
</div>


</body>
</html>

```
Now we are ready to run our example so run bellow command for quick run:

```php artisan serve```

Now you can open bellow URL on your browser:
```
http://localhost:8000/add-to-log

http://localhost:8000/logActivity
```
