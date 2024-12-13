@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
{{-- <a href="{{ $url }}" class="button button-{{ $color }}" target="_blank" rel="noopener">{{ $slot }}</a> --}}
<a href="{{ $url }}"
   style="background-color: #ff0000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;"
   target="_blank"
   rel="noopener">
   {{ $slot }}
</a>

</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>