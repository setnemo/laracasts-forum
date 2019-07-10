@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Create new thread</div>

                    <div class="card-body">
                        <form action="/threads" method="post" role="form">
                            <legend>Form Title</legend>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="channel_id">Please choice channel:</label>
                                <select name="channel_id" id="" class="form-control" required>
                                    <option value>Choose one...</option>
                                    @foreach(\App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected':'' }}>{{$channel->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Input title..." required>
                            </div>

                            <div class="form-group">
                                <label for="">Body</label>
                                <textarea class="form-control" name="body" placeholder="Input body..." rows="9" required>{{ old('body')}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
