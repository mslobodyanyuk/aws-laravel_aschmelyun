Getting started with Amazon S3 storage in Laravel
=================================================

* ***Actions on the deployment of the project:***

- Making a new project aws-laravel_aschmelyun.loc:

	sudo chmod -R 777 /var/www/LARAVEL/AWS/aws-laravel_aschmelyun.loc

	//!!!! .conf
	sudo cp /etc/apache2/sites-available/test.loc.conf /etc/apache2/sites-available/aws-laravel_aschmelyun.loc.conf
		
	sudo nano /etc/apache2/sites-available/aws-laravel_aschmelyun.loc.conf

	sudo a2ensite aws-laravel_aschmelyun.loc.conf

	sudo systemctl restart apache2

	sudo nano /etc/hosts

	cd /var/www/LARAVEL/AWS/aws-laravel_aschmelyun.loc

- Deploy project:

	`git clone << >>`
	
	`or Download`
	
	_+ Сut the contents of the folder up one level and delete the empty one._

	`composer install`	

---

Andrew Schmelyun

[Getting started with Amazon S3 storage in Laravel (14:54)]( https://www.youtube.com/watch?v=BQ0gi9YHuek&ab_channel=AndrewSchmelyun )

In this 15 minute video, I'll show you how to set up an Amazon S3 bucket to store images and files with your Laravel app using a few built-in methods. Skip the introduction by going to 
[(5:02)]( https://youtu.be/BQ0gi9YHuek?t=302 ).

Join my weekly newsletter for tips on Laravel + more: 
<https://aschmelyun.substack.com>

You'll learn how to:

- Upload files and store them locally with Laravel's request store method
- Set up an Amazon S3 bucket on AWS
- Change your file upload in Laravel to point to your S3 bucket
- Modify permissions for S3 URLs allowing them to be public or private

If you want to see the full source code for this video, check out the following GitHub repository: 
<https://github.com/aschmelyun/video-amazon-s3-storage>

	composer create-project --prefer-dist laravel/laravel
												
[(1:20)]( https://youtu.be/BQ0gi9YHuek?t=80 )
`routes/web.php`:

```php
use Illuminate\Support\Facades\Route;

Route::get('/', [ImageController::class, 'create']);
Route::post('/', [ImageController::class, 'store']);
Route::get('/{image}', [ImageController::class, 'show']);
```
		
	php artisan make:controller ImageController

[(1:35)]( https://youtu.be/BQ0gi9YHuek?t=95 )
		
	php artisan make:model Image --migration
		
```php		
protected $guarded = [];		
```
		
[(2:10)]( https://youtu.be/BQ0gi9YHuek?t=130 )
`...create_images_table.php`:

```php
public function up()
{
	Schema::create('images', function (Blueprint $table) {
		$table->bigIncrements('id');
		$table->string('filename');
		$table->string('url');
		$table->timestamps();
	});
}
```

[(3:00)]( https://youtu.be/BQ0gi9YHuek?t=180 )
`ImageController.php`:

```php
...
use App\Image;
...
public function create()
{
	return view('images.create');
}
```

[(3:55)]( https://youtu.be/BQ0gi9YHuek?t=235 )
`resources/views/images/create.blade.php`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Image App</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="max-w-lg mx-auto py-8">
    <form action="/" method="post" class="flex items-center justify-between border border-gray-300 p-4 rounded" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="image" id="image">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload File</button>
    </form>
</div>
</body>
</html>
```

`In Browser`:

	http://aws-laravel_aschmelyun.loc/

Error:
_"Illuminate\Contracts\Container\BindingResolutionException Target class [ImageController] does not exist."_

<https://newbedev.com/laravel-8-illuminate-contracts-container-bindingresolutionexception-target-class-controller-does-not-exist-code-example>

`routes/web.php`:

```php
use App\Http\Controllers\ImageController;
```

[(4:30)]( https://youtu.be/BQ0gi9YHuek?t=270 )
`ImageController.php`:

```php
public function store(Request $request)
{
	$path = $request->file('image')->store('images');

	return $path;
}
```

[(5:00)]( https://youtu.be/BQ0gi9YHuek?t=300 )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/1.png )

[(5:35)]( https://youtu.be/BQ0gi9YHuek?t=335 ) `AWS Management Console-> S3-> Create Bucket`.

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/1.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/2.png )

_"Everything on remaining screens I'm just going to keep the defaults for..."_

`Create Bucket`.

_"We need to generate credentials for our application to access that bucket via the AWS API."_

[(6:45)]( https://youtu.be/BQ0gi9YHuek?t=405 ) `IAM-> Users-> Add Users-> Add user`.

_"We're going to generate an `API token` and `Secret` for our S3 Bucket."_

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/3.png )

`Next: Permissions`.

[(7:25)]( https://youtu.be/BQ0gi9YHuek?t=445 ) `Attach existing policies directly-> S3-> Check AmazonS3FullAccess`.

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/4.png )

`Next: Tags`.

`Create User`.

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/5.png )

`Access key ID`, `Secret access key`. After leaving this window, the `Secret access key` is no longer shown in the system. 

- Access key ID
												
- Secret access key

[(7:40)]( https://youtu.be/BQ0gi9YHuek?t=460 ) `.env`.
												
```
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=eu-north-1
AWS_BUCKET=mslobodyanyuk-laravel-images
```

`Close`.

Regions: 
<https://docs.aws.amazon.com/general/latest/gr/rande.html>

[(8:30)]( https://youtu.be/BQ0gi9YHuek?t=510 )
`ImageController.php`:

```php
public function store(Request $request)
{
	$path = $request->file('image')->store('images', 's3');

	return $path;
}
```

[(8:40)]( https://youtu.be/BQ0gi9YHuek?t=520 )

	composer require league/flysystem-aws-s3-v3 
	
_"- Got Error:"_	

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/terminal/1.png )

	composer require league/flysystem-aws-s3-v3  ^1.0 -W	

[(9:00)]( https://youtu.be/BQ0gi9YHuek?t=540 ) `In Browser`:	
	
	http://aws-laravel_aschmelyun.loc/
	
![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/2.png )

_"- NO Errors, that's a goood start."_

[(9:10)]( https://youtu.be/BQ0gi9YHuek?t=550 )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/6.png )

`Open`.

[(9:20)]( https://youtu.be/BQ0gi9YHuek?t=560 )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/3.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/4.png )

_"- To access this image directly we get an Access Denied code..."_

[(9:40)]( https://youtu.be/BQ0gi9YHuek?t=580 ) 
_"Let's say that we want to store these paths to each image uploaded and utilize that database table and model that we create earlier"_

`Create databse in phpMyAdmin`: //aws-s3-aschmelyun

`Edit .env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aws-s3-aschmelyun
DB_USERNAME=
DB_PASSWORD=
```

	php artisan migrate 
	
_"- OK. We have a our `images` table."_	
	
[(10:35)]( https://youtu.be/BQ0gi9YHuek?t=635 )	
`ImageController.php`:

```php
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
...
public function store(Request $request)
{
	$path = $request->file('image')->store('images', 's3');

	$image = Image::create([	
		'filename' => basename($path),
		'url' => Storage::disk('s3')->url($path)
	]);

	return $image;
}
```

[(10:40)]( https://youtu.be/BQ0gi9YHuek?t=640 ) `In Browser`:	
	
	http://aws-laravel_aschmelyun.loc/
	
![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/7.png )
	
![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/5.png )

[(11:30)]( https://youtu.be/BQ0gi9YHuek?t=690 )	
`ImageController.php`:

```php
public function show(Image $image)
{
	return Storage::disk('s3')->response('images/' . $image->filename);
}
```

[(11:40)]( https://youtu.be/BQ0gi9YHuek?t=700 )

_"If we go to our app and visit the route using the `ID` of the image model. - Laravel retrieves the image from the `S3 Bucket` and generates appropriate response to display that image right in our `Browser`."_

	http://aws-laravel_aschmelyun.loc/1

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/6.png )

[(12:00)]( https://youtu.be/BQ0gi9YHuek?t=720 )	

_"- That works great but sometimes we do want our users to be able to access files ctraight from the `Amazon S3 URL's`"_

`ImageController.php`:

```php
public function show(Image $image)
{
	return $image->url;
}
```

_"...Since these are by default set to `private` we'll have to make some slight adjustments to our `code` and to our `S3 Bucket`"_

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/7.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/8.png )

[(12:25)]( https://youtu.be/BQ0gi9YHuek?t=745 )
`ImageController.php`:

```php
public function store(Request $request)
{

	$path = $request->file('image')->store('images', 's3');

	Storage::disk('s3')->setVisibility($path, 'public');
	
		$image = Image::create([	
		`filename` => basename($path),
		`url` => Storage::disk('s3')->url($path)
	]);

	return $image;
}
```

_"- This essentially changes the access details ... Also in `S3 Bucket` we must:"_

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/aws/8.png )

`Save changes`.

`To confirm the settings, enter `confirm` in the field`.

`Confirm`.

[(13:00)]( https://youtu.be/BQ0gi9YHuek?t=780 )
_"Now if we go back to our application we see our `image` coming from `S3`."_

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/9.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/10.png )

[(13:15)]( https://youtu.be/BQ0gi9YHuek?t=795 )

_"- You might be wondering if this means that now all of your `files` in that `Bucket` are visible with URLs and that not the case. Our files are previously uploaded without this set visibility public trait are still under `private access`. And if we remowe this call and upload file again we can't access that file with return URL."_

`ImageController.php`:

```php
public function store(Request $request)
{
...
//	Storage::disk('s3')->setVisibility($path, 'public');
...			
```

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/11.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/12.png )

[(13:50)]( https://youtu.be/BQ0gi9YHuek?t=830 )
_"Well what if you do want all of your files public by default"_

`config/filesystems.php`:

```
's3' => [
	'driver' => 's3',
	'key' => env('AWS_ACCESS_KEY_ID'),
	'secret' => env('AWS_SECRET_ACCESS_KEY'),
	'region' => env('AWS_DEFAULT_REGION'),
	'bucket' => env('AWS_BUCKET'),
	'url' => env('AWS_URL'),
	'visibility' => 'public'
],
```

_"Uploading yet another picture the `S3 Bucket Url` is open to the `public` without us having to specify that using the set visibility trait."_

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/13.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/14.png )

[(14:10)]( https://youtu.be/BQ0gi9YHuek?t=850 ) 

_"Of course you can do the opposite as well - let's add back that setVisibility call and change public to private. Going back to our app and uploading one more image."_

`ImageController.php`:

```php
public function store(Request $request)
{
...
Storage::disk('s3')->setVisibility($path, 'private');
...
}
```

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/15.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/aws-laravel_aschmelyun/blob/main/public/images/firefox/16.png )

_"The Amazon S3 Bucket URL is NOT open and return the Access Denied Error."_

#### Useful links:

Andrew Schmelyun

[Getting started with Amazon S3 storage in Laravel]( https://www.youtube.com/watch?v=BQ0gi9YHuek&ab_channel=AndrewSchmelyun )

<https://aschmelyun.substack.com>

<https://github.com/aschmelyun/video-amazon-s3-storage>

---

<https://docs.aws.amazon.com/general/latest/gr/rande.html>

Possible Errors

<https://newbedev.com/laravel-8-illuminate-contracts-container-bindingresolutionexception-target-class-controller-does-not-exist-code-example>

<https://stackoverflow.com/questions/68016830/illuminate-contracts-container-bindingresolutionexception-target-class-hotelsee>
