<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ $base }}/</loc>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ $base }}{{ route('blog.index', [], false) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ $base }}{{ route('blog.show', $post, false) }}</loc>
            @if ($post->published_at)
                <lastmod>{{ optional($post->published_at)->format('Y-m-d') }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
