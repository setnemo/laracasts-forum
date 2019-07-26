## History

### Episode 1
```bash
php artisan make:model Thread -mr
php artisan migrate
php artisan make:model Reply -mc
php artisan tinker
>>> factory('App\Thread', 50)->create();
php artisan migrate:refresh 
>>> $threads = factory('App\Thread', 50)->create();
>>> $threads->each(function ($thread) { factory('App\Reply', 10)->create(['thread_id' => $thread->id]); });
```

### Episode 2
```bash
php artisan make:auth
```
Add to phpunit.xml
```xml
<server name="DB_CONNECTION" value="sqlite"/>
<server name="DB_DATABASE" value=":memory:"/>
```
Write first test cases

### Episode 3
Added relationship Thread => Reply

```bash
php artisan make:test ReplyTest --unit
```
Added relationship Reply => User 

### Episode 4
Refactor show, added replay.blade.php
```bash
phpunit --filter testThreadHasCreator # run 1 test method from files
php artisan make:test ParticipateInForum
```
Fixed app/Exceptions/Handler.php, added `if (app()->environment() === 'testing') throw $exception;`
```bash
phpunit --filter ThreadTest # run 1 file
```
```php
protected $guarded = [];
```

### Episode 5
```php
@if(auth()->check())
    {{ csrf_field() }}
@else
    <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
@endif
$this->be($user = factory('App\User')->create());
$this->expectException('Illuminate\Auth\AuthenticationException');
```

### Episode 6
```php
$this->middleware('auth')->only('store');
$this->actingAs(factory('App\User')->create());
$this->expectException('Illuminate\Auth\AuthenticationException');
```

### Episode 7
Refactor tests
```json
{
    "autoload": {
        "files": [
            "tests/utilities/functions.php"
        ]
    }
}
```
```bash
composer dump-autoload
```
```php
$this->signIn(); // in TestCase
```

### Episode 8
Refactor tests
```php
$this->middleware('auth')->except(['index', 'show']);
```
```php
$this->withExceptionHandling(); // testcases handling exceptions
```

### Episode 9
Refactor tests
```bash
php artisan make:model Channel -m # with migration
```
Added slug to route

### Episode 10
Refactor tests, add request validation
```php
$this->validate($request, [
    'title' => 'required',
    'body' => 'required',
    'channel_id' => 'required|exists:channels,id',
]);
```

### Episode 11
Add route to channel
```php
Route::get('/threads/{channel}', 'ThreadsController@index');
```
Added menu for Channels

### Episode 12
Fixed create thread
```blade
@if ($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
```

### Episode 13
Fixed AppServiceProvider::boot()
```blade
\View::composer('threads.create', function ($view) {
    $view->with('channels', \App\Channel::all());
});
\View::share('channels', \App\Channel::all());
```

### Episode 14
Refactor test to DatabaseTestCase
```blade
@if (auth()->check())
{{ auth()->user()->name }}
@endif
```

### Episode 15
Refactor ThreadsControllers

### Episode 16
Refactor Thread, add global scope for replies count
```php
protected static function boot()
{
    parent::boot();

    static::addGlobalScope('replyCount', function ($builder) {
        $builder->withCount('replies');
    });
}
```
Refactor ThreadsController
```php
public function show(string $channel, Thread $thread)
{
    return view('threads.show', [
        'thread' => $thread,
        'replies' => $thread->replies()->paginate(5),
    ]);
}
```

### Episode 17

```php
$response = $this->getJson('/threads?popular=all')->json();

$this->builder->getQuery()->orders = [];
return $this->builder->orderBy('replies_count', 'desc');

if (\request()->wantsJson()) {
    return $threads;
}
```

### Episode 18

```bash
php artisan make:test Favorites
php artisan make:controller FavoritesController
php artisan make:migration create_favorites_table --create=favorites
php artisan make:model Favorite
```

```php
// 1
DB::table('favorites')->insert([
    'user_id' => auth()->id(),
    'favorited_id' => $reply->id,
    'favorited_type' => get_class($reply),
]);
// 2
Favorite::create([
    'user_id' => auth()->id(),
    'favorited_id' => $reply->id,
    'favorited_type' => get_class($reply),
]);
// 3
$reply->favorites()->create(['user_id' => auth()->id()]);
public function favorites()
{
    return $this->morphMany(Favorite::class, 'favorited');
}
//4 
$reply->favorite();
public function favorite()
{
    $this->favorites()->create(['user_id' => auth()->id()]);
}
```

### Episode 19

```php
public function replies()
{
    return $this->hasMany(Reply::class)->withCount('favorites');
}
```
```php
public function show(string $channel, Thread $thread)
{
    return $thread->load('replies.favorites')->load('replies.owner');
}
```

### Episode 20

```php
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
    public function boot()
    {
        \View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function () {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });
    }
```
```php
public function replies()
{
    return $this->hasMany(Reply::class)
        ->withCount('favorites')
        ->with('owner');
}
```

### Episode 21

```php
protected $with = ['owner', 'favorites'];
```

### Episode 22
User profile
```blade
<li><a href="{{ route('profile', auth()->user()->name) }}"  class="dropdown-item"  >My Threads</a></li>
```
```php
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
```

### Episode 23
Delete threads
```php
$this->json('DELETE', $thread->getPath());
$response = $this->delete($thread->getPath());
```
```php
$thread->replies()->delete();

```
```php
static::deleting(function ($thread) {
    $thread->replies()->delete();
});

```

### Episode 24
```php
if (auth()->id() != $thread->user_id) {
    abort(403, 'Permission denied');
}
```
```bash
php artisan make:policy ThreadPolicy --model=Thread
```
```php
protected $policies = [
     'App\Thread' => 'App\Policies\ThreadPolicy',
];
Gate::before(function ($user) {
    if ($user->name == 'Artem Pakhomov') {
        return true;
    }
});```

### Episode 25
```php
class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }
}
```
```php
trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        static::created(function ($thread) {
            $thread->recordActivity('created');
        });
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActyvityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }
}
```
