@extends('layouts.app')

@section('title', 'Головна сторінка новин')

@section('content')
    <section>
        <h1>Останні новини</h1>
        <p style="color: var(--muted); margin-top: 0;">Список новин формується з бази даних через модель та контролер.</p>

        <div class="grid news-list">
            @forelse($news as $item)
                <article class="news-card">
                    <div class="meta">
                        <span>{{ $item->category }}</span>
                        <span>{{ $item->author }}</span>
                        <span>{{ optional($item->published_at)->format('d.m.Y H:i') }}</span>
                    </div>
                    <h2>{{ $item->title }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($item->content, 150) }}</p>
                    <a class="button" href="{{ route('news.show', $item) }}">Читати далі</a>
                </article>
            @empty
                <p>Новини ще не додані.</p>
            @endforelse
        </div>
    </section>
@endsection
