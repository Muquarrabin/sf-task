@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Original URL</th>
                                <th scope="col">Shortened URL</th>
                                <th scope="col">Clicks</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($urls as $url)
                            <tr>
                                <td>{{$url->url}}</td>
                                <td><a href="{{route('shorten-url-redirect', $url->shorten_code)}}">{{route('shorten-url-redirect', $url->shorten_code)}}</a></td>
                                <td>{{$url->clicks}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
