<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{ config('app.name', 'Warriors Educare') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
border-radius: 0 !important;
}

.footer {
width: 100% !important;
}

.content-cell {
padding: 24px 18px !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
text-align: center !important;
}
}
</style>
{!! $head ?? '' !!}
</head>
<body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; color: #334155; margin: 0; padding: 20px 10px; width: 100% !important;">

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #f1f5f9; width: 100%; margin: 0; padding: 0;">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px; margin: 0 auto;">

<!-- Email Card Wrapper -->
<tr>
<td>
    <table class="inner-body" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);">
        
        <!-- Header -->
        {!! $header ?? '' !!}

        <!-- Email Body Content -->
        <tr>
            <td class="content-cell" style="padding: 32px 30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.65; color: #334155;">
                {!! Illuminate\Mail\Markdown::parse($slot) !!}

                {!! $subcopy ?? '' !!}
            </td>
        </tr>
    </table>
</td>
</tr>

<!-- Footer -->
{!! $footer ?? '' !!}

</table>
</td>
</tr>
</table>
</body>
</html>
