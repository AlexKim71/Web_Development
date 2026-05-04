@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <article class="article">
        <div class="meta">
            <span>{{ $news->category }}</span>
            <span>{{ $news->author }}</span>
            <span>{{ optional($news->published_at)->format('d.m.Y H:i') }}</span>
        </div>

        <h1>{{ $news->title }}</h1>

        <p>{{ $news->content }}</p>

        <a class="button" href="{{ route('news.index') }}">Повернутися до списку</a>
    </article>
@endsection
