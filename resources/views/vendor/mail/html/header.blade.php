@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
{{ $slot }}

</a>
</td>
</tr>
