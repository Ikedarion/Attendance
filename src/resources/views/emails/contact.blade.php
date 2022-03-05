<p>下記の内容でお問い合わせがありました。</p><br>

<p>【お問い合わせ内容】</p>

@foreach ($contents as $key => $content)
    <p>{{ $key }}: {{ $content }}</p>
@endforeach
