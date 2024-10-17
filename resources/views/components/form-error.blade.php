@props(['name'])

@error($name)
<span class="font-semibold text-xs text-red-500">{{ $message }}</span>
@enderror