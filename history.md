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

