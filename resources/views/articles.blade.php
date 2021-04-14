@extends('index')

@section('content')
    <form action="{{ url('/search') }}" method="POST">
        @csrf
        <input
            style="margin-bottom: 20px; height: 50px; font-size: 20px"
            type="text"
            name="searchTerm"
            placeholder="Type to search . . . "
            value="{{ request('searchTerm') }}"
        />
    </form>
    @foreach($articles as $article)
        <div style="background-color: #d7d7d7; margin-bottom: 20px; border-radius: 10px; padding: 1px 20px 5px 20px">
            <div style="margin-bottom: 7px">
                <h1>{{$article->title}}</h1>
            </div>
            <div>
                {{$article->text}}
            </div>
            <div style="display: flex; flex-direction: row">
                @foreach($article->tags as $tag)
                    <div style="margin-right: 20px; background-color: #7aa4ff; padding: 0 2px 0 2px; border-radius: 8px">{{$tag->title}}</div>
                @endforeach
            </div>
        </div>
        <br>
    @endforeach
@endsection
