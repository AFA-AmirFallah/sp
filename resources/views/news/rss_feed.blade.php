<?=
'<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>

<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
    <channel>
        <title>{{ \App\myappenv::CenterName }}</title>
        <atom:link href="{{ route('rss_feed') }}" rel="self" type="application/rss+xml" />
        <link>{{ route('home') }}</link>
        <description>{{ \App\myappenv::DefultPageTitr }}</description>

        <language>fa-IR</language>
        <sy:updatePeriod>hourly</sy:updatePeriod>
        <sy:updateFrequency>1</sy:updateFrequency>
        <image>
            <url>{{ url('/') . \App\myappenv::FavIcon }}</url>
            <title>{{ \App\myappenv::CenterName }}</title>
            <link>{{ route('home') }}</link>
            <width>32</width>
            <height>32</height>
        </image>

        @foreach ($Posts as $post)
            @if ($loop->first)
                <lastBuildDate>{{ date('D, d M Y H:i:s T', strtotime($post->updated_at)) }}</lastBuildDate>
            @endif
            <item>
                <title>
                    <![CDATA[{{ $post->Titel }}]]>
                </title>
                @if ($post->OutLink == null)
                    <link>
                    {{ str_replace('http://', 'https://', route('ShowNewsItem', ['NewsId' => $post->id, 'newsitem' => $post->Titel])) }}
                    </link>
                @else
                    <link>
                    {{ str_replace('http://', 'https://', route('ShowNewsItem', ['NewsId' => $post->OutLink])) }}
                    </link>
                @endif

                <description>
                    <![CDATA[{!! $post->Content !!}]]>
                </description>
                <category>{{ $post->cat_name }}</category>
                <author>
                    <![CDATA[afa.private@gmail.com]]>
                </author>
                <pubDate>{{ date('D, d M Y H:i:s T', strtotime($post->created_at)) }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
