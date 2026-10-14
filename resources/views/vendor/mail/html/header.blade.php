@props(['url'])
@php
    $logoSrc = null;
    $logoPath = public_path('adobe.png');
    if (isset($message) && is_object($message) && method_exists($message, 'embed') && file_exists($logoPath)) {
        try {
            $logoSrc = $message->embed($logoPath);
        } catch (\Throwable $e) {
            $logoSrc = null;
        }
    }
    if (!$logoSrc) {
        if (file_exists($logoPath)) {
            $logoSrc = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        } else {
            $logoSrc = asset('adobe.png');
        }
    }
@endphp
<tr>
    <td class="header" style="background: linear-gradient(135deg, #031b4e 0%, #082873 100%); padding: 22px 20px; text-align: center; border-radius: 16px 16px 0 0; border-bottom: 3px solid #fbc043;">
        <a href="{{ $url ?? config('app.url') }}" style="display: inline-block; text-decoration: none;">
            <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
                <tr>
                    <td align="center">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding-right: 12px; vertical-align: middle;">
                                    <img src="{{ $logoSrc }}" 
                                         alt="Warriors Educare" 
                                         width="44" 
                                         height="44" 
                                         style="display: block; width: 44px; height: 44px; max-width: 44px; max-height: 44px; object-fit: contain; border-radius: 8px; border: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;" />
                                </td>
                                <td style="vertical-align: middle; text-align: left;">
                                    <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 20px; font-weight: 900; color: #ffffff; letter-spacing: 1px; text-transform: uppercase; display: block; line-height: 1.2;">
                                        WARRIORS <span style="color: #fbc043;">EDUCARE</span>
                                    </span>
                                    <span style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 10px; font-weight: 700; color: #93c5fd; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-top: 2px;">
                                        India's Trusted Education Network
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </a>
    </td>
</tr>
