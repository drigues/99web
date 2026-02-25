<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title>Blog 99web</title>
        <link>{{ route('blog.index') }}</link>
        <description>Dicas, novidades e tendências do mundo digital — Insights da equipa 99web.</description>
        <language>pt-PT</language>
        <copyright>99web</copyright>
        <atom:link href="{{ route('blog.feed') }}" rel="self" type="application/rss+xml"/>

        @foreach($posts as $post)
        <item>
            <title><![CDATA[{{ $post->title }}]]></title>
            <link>{{ route('blog.show', $post->slug) }}</link>
            <guid isPermaLink="true">{{ route('blog.show', $post->slug) }}</guid>
            <description><![CDATA[{{ $post->excerpt }}]]></description>
            <pubDate>{{ $post->published_at->toRfc2822String() }}</pubDate>
            @if($post->category)
            <category>{{ $post->category->name }}</category>
            @endif
            @if($post->author)
            <author>{{ $post->author->name ?? '99web' }}</author>
            @endif
        </item>
        @endforeach

    </channel>
</rss>
