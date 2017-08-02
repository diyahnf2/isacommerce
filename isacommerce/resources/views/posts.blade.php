@foreach ($posts as $post)

    <article>
        <h2>{{ $post->product_name }}</h2>
        {{ $post->price }}
    </article>

@endforeach

{{ $posts->links() }}