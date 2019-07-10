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
                                <label for="">Title</label>
                                <input type="text" class="form-control" name="title" id="" placeholder="Input title...">
                            </div>

                            <div class="form-group">
                                <label for="">Body</label>
                                <textarea class="form-control" name="body" id="" placeholder="Input body..." rows="9"></textarea>
                            </div>




                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
