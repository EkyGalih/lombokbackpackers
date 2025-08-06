<title>
    {{ $title . app(\App\Settings\WebsiteSettings::class)->site_name ?: (app(\App\Settings\WebsiteSettings::class)->site_name ?? config('app.name')) }}
</title>
